<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

$statusList= [
    ['id' => '9', 'name' => 'Cancelled'], 
];  
$statusArray = ArrayHelper::map($statusList, 'id', 'name');

$cancelReasonArray = $premodel->cancelReasonsvalue;

?>

<div class="cancellation-form-container">

    <?php $form = ActiveForm::begin(['id' => 'cancellation-form']); ?>

        <div class="row">
    
            <div class="col-sm-4 col-md-4">
                <?= $form->field($premodel, 'status')->dropDownList($statusArray); ?>  
            </div>    

            <div class="col-sm-4 col-md-4">
                <?= $form->field($premodel, 'cancellationReason')->dropDownList($cancelReasonArray); ?>  
            </div> 

            <div class="col-sm-4 col-md-4">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success mt-30']) ?>
            </div>

            <div id="ajaxLoad">
                <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
            </div>

        </div>
   
    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
        
$('#cancellation-form').on('beforeSubmit', function(e) 
{
    if (!confirm('Are you sure to cancel this case')) {
        return false;
    }

    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        beforeSend: function() {
            $("#loading-image").show();
        },
        success: function (data) {
            $('#cancelCase-modal').modal('toggle');
            $('#MasterState').trigger("reset");
            $('#w0').yiiGridView('applyFilter');
            $("#loading-image").hide();   
        },
        error: function (jqXHR, exception) {
            alert(jqXHR.responseText);
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});

JS;
$this->registerJS($script);
?>