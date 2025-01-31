<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoansSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loans-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'address') ?>

    <?php echo $form->field($model, 'mobile') ?>


    <?php echo $form->field($model, 'loanAppliedAmount') ?>

    <?php // echo $form->field($model, 'pancard') ?>

    <?php // echo $form->field($model, 'creditScore') ?>

    <?php // echo $form->field($model, 'employmentType') ?>

    <?php // echo $form->field($model, 'loanType') ?>

    <?php // echo $form->field($model, 'sourceType') ?>

    <?php // echo $form->field($model, 'sourceId') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sanctionedBank') ?>

    <?php // echo $form->field($model, 'createdOn') ?>

    <?php // echo $form->field($model, 'lastUpdatedOn') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
