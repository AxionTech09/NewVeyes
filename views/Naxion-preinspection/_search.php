<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preinspection-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'referenceNo') ?>

    <?= $form->field($model, 'insurerName') ?>

    <?= $form->field($model, 'insurerDivision') ?>

    <?= $form->field($model, 'insurerBranch') ?>

    <?php // echo $form->field($model, 'intimationDate') ?>

    <?php // echo $form->field($model, 'callerName') ?>

    <?php // echo $form->field($model, 'callerMobileNo') ?>

    <?php // echo $form->field($model, 'callerDetails') ?>

    <?php // echo $form->field($model, 'insuredName') ?>

    <?php // echo $form->field($model, 'insuredMobile') ?>

    <?php // echo $form->field($model, 'contactPersonMobileNo') ?>

    <?php // echo $form->field($model, 'insuredAddress') ?>

    <?php // echo $form->field($model, 'registrationNo') ?>

    <?php // echo $form->field($model, 'engineNo') ?>

    <?php // echo $form->field($model, 'chassisNo') ?>

    <?php // echo $form->field($model, 'vehicleType') ?>

    <?php // echo $form->field($model, 'vehicleTypeRadio') ?>

    <?php // echo $form->field($model, 'manufacturer') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'manufacturingYear') ?>

    <?php // echo $form->field($model, 'intimationRemarks') ?>

    <?php // echo $form->field($model, 'extraKM') ?>

    <?php // echo $form->field($model, 'surveyLocation') ?>

    <?php // echo $form->field($model, 'surveyorName') ?>

    <?php // echo $form->field($model, 'surveyorContactNo') ?>

    <?php // echo $form->field($model, 'sendLink') ?>

    <?php // echo $form->field($model, 'surveyorAppointDateTime') ?>

    <?php // echo $form->field($model, 'rescheduleReason') ?>

    <?php // echo $form->field($model, 'rescheduleDateTime') ?>

    <?php // echo $form->field($model, 'inspectionType') ?>

    <?php // echo $form->field($model, 'paymentMode') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'customerAppointDateTime') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'preinspectionType') ?>

    <?php // echo $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'created_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
