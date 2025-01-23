<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FieldexecutivesTasksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fieldexecutives-tasks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'processId') ?>

    <?= $form->field($model, 'processNo') ?>

    <?= $form->field($model, 'companyName') ?>

    <?= $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'customerAppointmentDateTime') ?>

    <?php // echo $form->field($model, 'fieldexecutiveId') ?>

    <?php // echo $form->field($model, 'processType') ?>

    <?php // echo $form->field($model, 'created_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
