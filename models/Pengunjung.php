<?php

namespace app\models;

use app\components\Tanggal;
use Yii;
use \app\models\base\Pengunjung as BasePengunjung;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pengunjung".
 */
class Pengunjung extends BasePengunjung
{
    public function fields()
    {
        $parent = parent::fields();
        unset($parent['foto']);
        unset($parent['timestamp']);

        $parent['foto'] = function($model){
            return Yii::getAlias("@web"). $model->foto;
        };
        
        $parent['date'] = function($model){
            $date = date("Y-m-d", strtotime($model->timestamp));
            return Tanggal::toReadableDate($date, false);
        };

        $parent['time'] = function($model){
            $time = date("H:i A", strtotime($model->timestamp));
            return $time;
        };

        $parent['status'] = function($model){
            return ($model->pakai_masker) ? "success" : "fail";
        };

        $parent['message'] = function($model){
            return ($model->pakai_masker) ? "Berhasil Masuk" : "Tidak memakai masker, Dilarang masuk.";
        };

        return $parent;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
