<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterBanks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-banks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bankName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
