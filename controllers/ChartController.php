<?php
namespace app\controllers;

class ChartController extends \yii\web\Controller {
    public function actionIndex(){
        $this->layout = false;
        return $this->render('new_mocata');
    }
}