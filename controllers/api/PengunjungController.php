<?php

namespace app\controllers\api;

use app\models\Pengunjung;
use Yii;
use yii\web\Response;

/**
 * This is the class for REST controller "PengunjungController".
 */

class PengunjungController extends \yii\rest\ActiveController
{

    // status
    // 0 : gagal
    // 1 : berhasil

    public $modelClass = 'app\models\Pengunjung';

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['view']);
        unset($parent['create']);
        unset($parent['update']);
        unset($parent['delete']);

        return $parent;
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Pengunjung();
        $model->timestamp = date("Y-m-d H:i:s");

        $foto = $_POST['foto'];
        if (isset($foto) == false) {
            return [
                "status" => 0,
                "message" => "Foto tidak boleh kosong",
            ];
        }

        $tegangan_piezoelektrik = $_POST['tegangan_piezoelektrik'];
        if (isset($tegangan_piezoelektrik) == false) {
            return [
                "status" => 0,
                "message" => "Tegangan Piezoelektrik tidak boleh kosong",
            ];
        }
        
        $tegangan_piezoelektrik = $_POST['tegangan_piezoelektrik'];
        if (isset($tegangan_piezoelektrik) == false) {
            return [
                "status" => 0,
                "message" => "Tegangan Piezoelektrik tidak boleh kosong",
            ];
        }
        
        $pakai_masker = $_POST['pakai_masker'];
        if (isset($pakai_masker) == false) {
            return [
                "status" => 0,
                "message" => "Status pemakaian masker tidak boleh kosong",
            ];
        }

        $model->foto = $this->uploadFoto($foto);
        if($model->foto == "-"){
            return [
                "status" => 0,
                "message" => "Foto gagal diupload",
            ];
        }

        $model->tegangan_piezoelektrik =  $tegangan_piezoelektrik;
        $model->pakai_masker =  $pakai_masker;

        if($model->validate() == false){
            return [
                "status" => 0,
                'message' => "validasi gagal"
            ];
        }
        $model->save();

        return [
            "status" => 1,
            'message' => "data berhasil disimpan"
        ];
    }

    public function actionListData(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $today = date("Y-m-d");
        $tomorrow = date("Y-m-d", strtotime($today. " +1 day"));
        $model = Pengunjung::find()->where([
            'and',
            ['<=', 'timestamp', $tomorrow],
            ['>=', 'timestamp', $today],
        ])->orderBy(['id' => SORT_DESC])->limit(3)->all();
        $count = Pengunjung::find()->where([
            'and',
            ['<=', 'timestamp', $tomorrow],
            ['>=', 'timestamp', $today],
        ])->orderBy(['id' => SORT_DESC])->count();

        return [
            "success" => true,
            "data" => $model,
            "count_today" => (int)$count
        ];
    }


    public function uploadFoto($foto){
        $date = date("Y-m-d");
        $filename = Yii::$app->security->generateRandomString(32) . ".png";

        $real_path = Yii::getAlias("@webroot/uploads/pengunjung/{$date}/");
        $url_path = Yii::getAlias("/uploads/pengunjung/{$date}/");

        if (file_exists($real_path) == false) {
            mkdir($real_path, 0777, true);
        }

        $allow = [
            "\xFF\xD8\xFF",
            "GIF",
            "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a",
            "BM",
            "8BPS",
            "FWS",
        ];

        $binary_image = base64_decode(str_replace("data:image/png;base64,", "", $foto));
        $flag = 0;

        foreach ($allow as $item) {
            if (substr($binary_image, 0, strlen($item)) == $item) {
                $flag = 1;
            }
        }

        if ($flag == 1) {
            file_put_contents("{$real_path}{$filename}", $binary_image);
            $path = "{$url_path}{$filename}";
        } else {
            $path = "-";
        }

        return $path;
    }
}
