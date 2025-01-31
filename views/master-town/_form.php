<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MasterTown */
/* @var $form yii\widgets\ActiveForm */

$cityList =ArrayHelper::map($city,'id','city');
?>

<div class="master-town-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select','style'=>'width:500px']);?>

    <?= $form->field($model, 'town')->textInput(['style'=>'width:500px']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
