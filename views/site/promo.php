<?php
/* @var $this yii\web\View */
use app\models\Promo;
?>

<div class="master-slider ms-skin-default" id="masterslider">
    <?php foreach ($detpromo as $data) {
      $model = Promo::find()->where(['id' => $data->id_promo])->one();
    ?>
    <div class="ms-slide">
        <img src="<?= \yii\helpers\Url::to(["css/blank.gif"]) ?>" data-src="<?= \yii\helpers\Url::to(["uploads/$model->foto"]) ?>" alt="lorem ipsum dolor sit"/>
    </div>
  <?php } ?>
</div>

<?php $this->registerJs('

var slider = new MasterSlider();
slider.setup(\'masterslider\' , {
    width:800,
    height:430,
    fullwidth:true,
    space:5,
    view:"basic",
    autoHeight:true
});
slider.control(\'arrows\');
slider.control(\'bullets\' , {autohide:false});
slider.control(\'scrollbar\' , {dir:\'h\'});


'); ?>
