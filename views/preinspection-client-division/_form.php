<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */
/* @var $form yii\widgets\ActiveForm */

$companyList =ArrayHelper::map($company,'id','companyName');
$regionList =ArrayHelper::map($region,'id','regionName');
// print_r($regionList);
?>

<div class="preinspection-client-division-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','style'=>'width:500px','onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('preinspection-client-division/divisionlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#regionId" ).html( data );
                });
            ']);?>

    <?= $form->field($model, 'regionId')->dropDownList($divisionList,['style'=>'width:500px','id'=>'regionId', 'value' => $model->regionId]) ?>
      
    <?= $form->field($model, 'divisionName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'divisionCode')->textInput(['style'=>'width:500px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
