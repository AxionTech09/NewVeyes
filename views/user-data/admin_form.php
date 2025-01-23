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
    
    <?= $form->field($model, 'active')->dropDownList($activeArray);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
