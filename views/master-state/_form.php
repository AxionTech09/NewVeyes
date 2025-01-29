<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\MasterCity */
/* @var $form yii\widgets\ActiveForm */
	
	$country=[['id'=>1,'name'=>'India']];
	$country_list=ArrayHelper::map($country, 'id', 'name');
    $stateStatus = $model->stateStatusArray;
?>

<div class="master-state-form">

    <?php $form = ActiveForm::begin(); ?>

    <div id="state_details" class="panel panel-primary pb-15">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">State Details</h4>
        </div>

        <div class="panel-body">
            <div class="col-sm-4 col-md-3 text-error">
                <?= $form->field($model, 'countryId')->dropDownList($country_list, ['prompt'=>'Select Country']);?>
            </div>
            <div class="col-sm-4 col-md-3 text-error">
                <?= $form->field($model, 'state')->textInput() ?>
            </div>
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'regCode')->textInput() ?>
            </div>
            <div class="col-sm-4 col-md-3 text-error">
                <?= $form->field($model, 'stateStatus')->dropDownList($stateStatus) ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? FA::icon('plus-circle', ['class' => 'mr-3 mt-5 text-white']).' Create' : FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
