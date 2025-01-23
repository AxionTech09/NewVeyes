<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCaller */
/* @var $form yii\widgets\ActiveForm */

$companyList =ArrayHelper::map($company,'id','companyName');
if(isset($division))
{
    $divisionList = ArrayHelper::map($division,'id','divisionName');
}
else {
    $divisionList = [''=>'Select'];
}
if(isset($branch))
{
    $branchList = ArrayHelper::map($branch,'id','branchName');
}
else {
    $branchList = [''=>'Select'];
}
?>

<div class="preinspection-client-caller-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','style'=>'width:500px','id'=>'companyId','onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('preinspection-client-caller/divisionlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#divisionId" ).html( data );
                  $( "select#branchId" ).html("<option value=\'\'>Select</option>");
                });
            ']);?>

    <?= $form->field($model, 'divisionId')->dropDownList($divisionList,['style'=>'width:500px','id'=>'divisionId','onchange'=>'
               $.get("'.Yii::$app->urlManager->createUrl('preinspection-client-caller/branchlist').'",{id:$(this).val(),cid:$("#companyId").val()}, 
                function( data ) {
                $( "select#branchId" ).html( data );
                });
            ']) ?>

    <?= $form->field($model, 'branchId')->dropDownList($branchList,['style'=>'width:500px','id'=>'branchId']) ?>

    <?= $form->field($model, 'callerName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'callerDesignation')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'callerMobileNo')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'callerEmailId')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'callerAdditionInfo')->textInput(['style'=>'width:500px']) ?>
    
    <?= $form->field($model, 'supervisorName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'supervisorDesignation')->textInput(['style'=>'width:500px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
