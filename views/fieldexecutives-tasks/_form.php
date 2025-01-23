<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FieldexecutivesTasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fieldexecutives-tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'processId')->textInput() ?>

    <?= $form->field($model, 'processNo')->textInput() ?>

    <?= $form->field($model, 'companyName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customerAppointmentDateTime')->textInput() ?>

    <?= $form->field($model, 'fieldexecutiveId')->textInput() ?>

    <?= $form->field($model, 'processType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
