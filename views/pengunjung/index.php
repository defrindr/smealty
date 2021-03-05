<?php

use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\PengunjungSearch $searchModel
 */

$this->title = 'Pengunjung';
$this->params['breadcrumbs'][] = $this->title;
?>

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-main', 'enableReplaceState' => false, 'linkSelector' => '#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']])?>

    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                <?=GridView::widget([
                    'layout' => '{summary}{pager}{items}{pager}',
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'class' => yii\widgets\LinkPager::className(),
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last'],
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                    'headerRowOptions' => ['class' => 'x'],
                    'columns' => [

                        \app\components\ActionButton::getButtons(),

                        [
                            'attribute' => 'foto',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $url = Yii::getAlias("@web") . str_replace("/web", "", $model->foto);
                                return $url;
                            },
                        ],
                        'tegangan_piezoelektrik',
                        [
                            'attribute' => 'pakai_masker',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $color = ($model->pakai_masker == 1) ? "success" : "danger";
                                $msg = ($model->pakai_masker == 1) ? "Pakai Masker" : "Tidak Pakai Masker";

                                return "<span class='label label-$color'>$msg</span>";
                            },
                        ],
                        'timestamp',
                    ],
                ]);?>
            </div>
        </div>
    </div>

    <?php \yii\widgets\Pjax::end()?>

