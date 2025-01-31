<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MasterFieldexecutives */
/* @var $form yii\widgets\ActiveForm */
$cityList =ArrayHelper::map($city,'id','city');

?>

<div class="master-fieldexecutives-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['style'=>'width:500px']) ?>
    
    <?= $form->field($model, 'valuationUserId')->textInput(['style'=>'width:500px']) ?>
    
    <?= $form->field($model, 'piUserId')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'address')->textInput(['style'=>'width:500px']) ?>
    
    <div style="width:500px">
    <?= $form->field($model, 'dob')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]); ?>
     </div>

    <?= $form->field($model, 'email')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'mobile')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'nominee')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'spouseName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'mobile2')->textInput(['style'=>'width:500px']) ?>

   <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select','style'=>'width:500px']);?>

    <?= $form->field($model, 'basicSalary')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'caseRate')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'loans')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'repaymentInstalment')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'bankName')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'accNumber')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'ifsc')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'branchName')->textInput(['style'=>'width:500px']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
