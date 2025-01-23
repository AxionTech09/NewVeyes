<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */
/* @var $form yii\widgets\ActiveForm */

$companyList =ArrayHelper::map($company,'id','companyName');
?>

<div class="preinspection-client-region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','style'=>'width:500px']);?>
    
    <?= $form->field($model, 'regionName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'regionCode')->textInput(['style'=>'width:500px']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
