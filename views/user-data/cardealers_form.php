<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$activeList= [
  ['id' => 'Y', 'name' => 'Y'],
  ['id' => 'N', 'name' => 'N'],
];
$activeArray = ArrayHelper::map($activeList, 'id', 'name');


if(isset($surveyor))
{
    $surveyorList = ArrayHelper::map($surveyor,'id','firstName');
}
else {
    $surveyorList = [''=>'Select'];
}

?>

<div class="userdata-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
     
      <?= $form->field($model, 'alterMobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surveyorId')->dropDownList($surveyorList,
        ['id'=>'surveyorId','prompt'=>'Select']); ?>
     
    
    <?php if($model->isNewRecord){ ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
    
    <?php } ?>

   
    
    
 
    
    <?= $form->field($model, 'active')->dropDownList($activeArray);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
