<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="userdata-form">
    
    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,]); ?>

    <div class="row userform">
        <div class="col-md-4">
           <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?> 
        </div>
        <div class="col-md-4">
            <?= Html::label('New Password', 'user-password')?>
            <?= Html::input('password', 'User[password]', '', ['class' => 'form-control', 'id' => 'user-password']) ?>            
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label('Confirm Password') ?> 
        </div>

    </div>
    
    <div class="colmd-12 text-center form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
