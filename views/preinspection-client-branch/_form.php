<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientBranch */
/* @var $form yii\widgets\ActiveForm */

$companyList =ArrayHelper::map($company,'id','companyName');
if(isset($division))
{
    $divisionList = ArrayHelper::map($division,'id','divisionName');
}
else {
    $divisionList = [''=>'Select'];
}
?>

<div class="preinspection-client-branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','style'=>'width:500px','onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('preinspection-client-branch/divisionlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#divisionId" ).html( data );
                });
            ']);?>

    <?= $form->field($model, 'divisionId')->dropDownList($divisionList,['style'=>'width:500px','id'=>'divisionId']) ?>
    
    <?= $form->field($model, 'branchName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'branchCode')->textInput(['style'=>'width:500px']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
