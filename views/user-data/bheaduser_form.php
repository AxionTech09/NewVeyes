<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */

$activeList= [
  ['id' => 'Y', 'name' => 'Y'],
  ['id' => 'N', 'name' => 'N'],
];
$activeArray = ArrayHelper::map($activeList, 'id', 'name');
$cityList =ArrayHelper::map($city,'id','city');

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

<div class="userdata-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?php if($model->isNewRecord){ ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
    
    <?php } ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select']);?>
    
    <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','id'=>'companyId','onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('user-data/divisionlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#divisionId" ).html( data );
                  $( "select#branchId" ).html("<option value=\'\'>Select</option>");
                });
            ']);?>

    <?= $form->field($model, 'divisionId')->dropDownList($divisionList,['id'=>'divisionId','onchange'=>'
               $.get("'.Yii::$app->urlManager->createUrl('user-data/branchlist').'",{id:$(this).val(),cid:$("#companyId").val()}, 
                function( data ) {
                $( "select#branchId" ).html( data );
                });
            ']) ?>

    <?= $form->field($model, 'branchId')->dropDownList($branchList,['id'=>'branchId']) ?>
    
    <?= $form->field($model, 'active')->dropDownList($activeArray);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
