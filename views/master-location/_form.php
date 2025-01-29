<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MasterLocation */
/* @var $form yii\widgets\ActiveForm */

$cityList =ArrayHelper::map($city,'id','city');
if(isset($town))
{
    $townList = ArrayHelper::map($town,'id','town');
}
else {
    $townList = [''=>'Select'];
}
?>

<div class="master-location-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select','style'=>'width:500px','onchange'=>'
            $.post( "'.Yii::$app->urlManager->createUrl('master-location/townlist?id=').'"+$(this).val(), function( data ) {
              $( "select#townId" ).html( data );
            });
        ']);?>

    <?= $form->field($model, 'townId')->dropDownList($townList,['style'=>'width:500px','id'=>'townId']) ?>

    <?= $form->field($model, 'conveyance')->textInput(['style'=>'width:500px']) ?>

    <?= $form->field($model, 'extraKms')->textInput(['style'=>'width:500px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
