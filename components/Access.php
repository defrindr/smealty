<?php
namespace appp\components;


class Access {
    public function isBlock($model){
        if($model->status_pengajuan == $model::STATUS_PENGAJUAN_BARU){
            return true;
        }
        return false;
    }
}
