<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */
// $divisionList = ArrayHelper::map($division,'id','divisionName');



$activeList= [
  ['id' => 'Y', 'name' => 'Y'],
  ['id' => 'N', 'name' => 'N'],
];
$zoneList= [
    ['id' => '', 'name'=>'Select'],
    ['id' => 'North', 'name' => 'North'],
    ['id' => 'South', 'name' => 'South'],
    ['id' => 'East', 'name' => 'East'],
    ['id' => 'West', 'name' => 'West'],
];
$zoneArray = ArrayHelper::map($zoneList, 'id', 'name');
$activeArray = ArrayHelper::map($activeList, 'id', 'name');
$cityList =ArrayHelper::map($city,'id','city');
$roName=ArrayHelper::map($roName,'id','firstName');

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

if(isset($bhead))
{
    $bheadList = ArrayHelper::map($bhead,'id','firstName');
}
else {
    $bheadList = [''=>'Select'];
}
?>

<div class="userdata-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <div class="panel">
        <div class="panel-heading form-subheading"><h4>Basic Details</h4></div>
        <div class="panel-body">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select']);?>
            </div>

            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'companyId')->dropDownList($companyList,['prompt'=>'Select','id'=>'companyId','onchange'=>'
                    $.post( "'.Yii::$app->urlManager->createUrl('user-data/divisionlist?id=').'"+$(this).val(), function( data ) {
                    $( "select#divisionId" ).html( data );
                    $( "select#branchId" ).html("<option value=\'\'>Select</option>");
                    });$.get("'.Yii::$app->urlManager->createUrl('user-data/bheadlist').'",{id:$(this).val()}, 
                    function( data ) {
                    $( "select#bheadId" ).html( data );
                    });
                ']);?>
            </div>  
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'divisionId')->dropDownList($divisionList,['id'=>'divisionId','onchange'=>'
                $.get("'.Yii::$app->urlManager->createUrl('user-data/branchlist').'",{id:$(this).val(),cid:$("#companyId").val()}, 
                    function( data ) {
                    $( "select#branchId" ).html( data );
                    });
                ']) ?>
            </div>  
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'branchId')->dropDownList($branchList,['id'=>'branchId']) ?>
            </div>  

            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'branchHeadId')->dropDownList($bheadList,['id'=>'bheadId','prompt'=>'Select']) ?>
            </div>  
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>
            </div>  
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'agent_code')->textInput(['maxlength' => true])->label('Employee / Agent code') ?>
            </div>  
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'zone')->dropDownList($zoneArray);?>
            </div>
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'roId')->dropDownList($roName,['prompt'=>'Select RO Name'])->label('RO Name') ?> 
            </div>
        </div>
    </div>



    <div class="panel">
        <div class="panel-heading form-subheading"><h4>Contact Details</h4></div>
        <div class="panel-body">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <?php if($model->isNewRecord){ ?>
                <div class="col-md-4 form-group">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                </div>    
                <div class="col-md-4 form-group">
                    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
                </div>
            <?php } ?>   
        </div>
    </div>
    
    <div class="panel">
        <div class="panel-body">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'active')->dropDownList($activeArray);?>
            </div>
        
            <div class="col-md-4 form-group">    
                <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
            
    <div class="col-md-12 text-center">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
