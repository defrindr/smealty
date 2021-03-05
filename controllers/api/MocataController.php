<?php

namespace app\controllers\api;

use app\components\MocataHelper;
use app\models\FunTrack;
use app\models\FunTrackParticipant;
use app\models\Mocata;
use app\models\MocataLog;
use Yii;
use yii\web\Response;

/**
 * This is the class for REST controller "MocataController".
 */

class MocataController extends \yii\rest\ActiveController
{
    // status
    // 0 : qr sudah dipakai
    // 1 : berhasil
    // 2 : qr tidak ada
    // 3 : suhu diatas normal

    // event
    // 1 : fun track
    // 2 : fun bike
    // 3 : painting
    // 4 : javanesse
    // 5 : english

    // event 4 & 5 di gabung jadi 1
    public $modelClass = 'app\models\Mocata';

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['create']);
        unset($parent['update']);
        unset($parent['view']);
        unset($parent['delete']);

        return $parent;
    }

    function require($data)
    {
        if ($data == "") {
            return true;
        }
        return false;
    }

    public function actionScanQr()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $event_id = $_POST['event_id'];
        $qrcode = $_POST['qr_code'];
        $action = $_POST['action'];
        $foto = $_POST['foto'];
        $suhu = (float) $_POST['suhu'];

        $data = [
            "event_id" => $event_id,
            "qr_code" => $qrcode,
            "action" => $action,
            "foto" => $foto,
            "suhu" => $suhu,
        ];

        if ($this->require($qrcode)) {
            $status = false;
            $message = "Qr code tidak boleh kosong.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }

        if ($this->require($action)) {
            $status = false;
            $message = "Action tidak boleh kosong.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }

        if ($this->require($foto)) {
            $status = false;
            $message = "Foto tidak boleh kosong.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }

        if ($this->require($suhu)) {
            $status = false;
            $message = "Suhu tidak boleh kosong.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }

        $check_qrcode = FunTrackParticipant::findOne(['qr_code' => $qrcode]);
        if ($check_qrcode == []) {
            $status = false;
            $message = "QR code anda tidak valid.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }

        $event = FunTrack::findOne(['id' => $event_id]);
        if ($event == []) {
            $status = false;
            $message = "Event tidak ditemukan.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => $check_qrcode->user->name,
            ];
        }
        if($event_id == 4) {
            if ( in_array($check_qrcode->fun_track_id, [4, 5]) == false) {
                $status = false;
                $message = "QR code anda tidak valid dengan event.";
                MocataHelper::log($data, $status, $message);
                return [
                    "status" => 2,
                    "name" => $check_qrcode->user->name,
                ];
            }
            $event = FunTrack::findOne(['id' => $check_qrcode->fun_track_id]);
            $data["event_id"] = $event->id;
        }else{
            if ($check_qrcode->fun_track_id != $event->id) {
                $status = false;
                $message = "QR code anda tidak valid dengan event.";
                MocataHelper::log($data, $status, $message);
                return [
                    "status" => 2,
                    "name" => $check_qrcode->user->name,
                ];
            }
        }

        $check_mocata = Mocata::findOne(['qr_code' => $qrcode, 'action' => $action]);
        if ($check_mocata) {
            $status = false;
            $message = "Anda telah melakukan scan Qr code sebelumnya.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 0,
                "name" => $check_qrcode->user->name,
            ];
        }

        $mocata = new Mocata();
        $mocata->qr_code = $qrcode;
        $mocata->fun_track_id = $event->id;
        $mocata->user_id = $check_qrcode->user->id;
        $mocata->fun_track_pack_id = $check_qrcode->funTrackPack->id;

        $filename = Yii::$app->security->generateRandomString(32) . ".png";

        $real_path = Yii::getAlias("@webroot/uploads/mocata/{$event->name}/");
        $url_path = Yii::getAlias("/uploads/mocata/{$event->name}/");

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

        $binary_image = base64_decode(str_replace("data:image/png;base64,", "", $mocata->foto));
        $flag = 0;

        foreach ($allow as $item) {
            if (substr($binary_image, 0, strlen($item)) == $item) {
                $flag = 1;
            }
        }

        if ($flag == 1) {
            file_put_contents("{$real_path}{$filename}", $binary_image);
            $mocata->foto = "{$url_path}{$filename}";
        } else {
            $mocata->foto = "-";
        }

        $mocata->fun_track_participant_id = $check_qrcode->id;
        $mocata->action = $action;
        $mocata->suhu = $suhu;
        $mocata->timestamp = date("Y-m-d H:i:s");
        $check_qrcode->start_scan = date("Y-m-d H:i:s");

        try {
            if ($mocata->validate()) {
                if ($suhu >= 37.2) {
                    $status = false;
                    $message = "Gagal masuk, suhu terlalu tinggi.";
                    MocataHelper::log($data, $status, $message);
                    return [
                        "status" => 3,
                        "name" => $mocata->user->name,
                    ];
                }
                $mocata->save();
                $check_qrcode->save();

                $status = true;
                $message = "Berhasil melakukan scan Qr code.";
                MocataHelper::log($data, $status, $message);
                return [
                    "status" => 1,
                    "name" => $mocata->user->name,
                ];
            }

            $status = false;
            $message = "Gagal menyimpan data karena data tidak valid.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        } catch (\Throwable $th) {
            $status = false;
            $message = "Telah terjadi kesalahan saat melakukan scan Qr code.";
            MocataHelper::log($data, $status, $message);
            return [
                "status" => 2,
                "name" => "-",
            ];
        }
    }

    public function actionListData($fun_track_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = FunTrack::findOne(['id' => $fun_track_id]);
        if ($model == []) {
            return [
                "success" => false,
                "message" => "Event tidak ditemukan",
            ];
        }

        $list_mocata = MocataLog::find()->where(['and', ['fun_track_id' => $model->id], ['like', 'foto', 'uploads/']])->orderBy(['id' => SORT_DESC])->limit(3)->all();

        return [
            "success" => true,
            "message" => "Data berhasil didapatkan.",
            "data" => $list_mocata,
        ];
    }
}
