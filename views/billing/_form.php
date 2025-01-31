<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

date_default_timezone_set('Asia/Calcutta');
$paymentArray = $model->paymentValue;
$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];

?>

<div class="preinspection-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
    
    <div id="company_details" class="preinspection-box">
       
   
    <div class="form-group">
    <?= $form->field($model, 'referenceNo')->textInput(['readonly' =>true]) ?>
    </div>        

        <div class="form-group">
        <?= $form->field($model, 'surveyLocation')->textInput(['maxlength' => true])->label('Survey From Location*') ?>
        </div>
        <div class="form-group">
        <?= $form->field($model, 'surveyLocation2')->textInput(['maxlength' => true])->label('Survey To Location*') ?>
        </div>
                   
        <div class="form-group">  
        <?= $form->field($model, 'paymentMode')->dropDownList($paymentArray,['id' => 'paymentMode'])->label('Payment Mode') ?>
        </div>  
        
        <div class="form-group">
        <?= $form->field($model, 'cashCollection')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="form-group">     
            <?= $form->field($model, 'extraKM')->textInput() ?>
        </div>   
        
    <div class="clear"></div>
    
    <?php  echo Html::hiddenInput('name', $model->isNewRecord?"Y":"N", ['id' => 'newRecord']); ?>
    <?php if($model->billStatus == 'Initiated' || $role == 'Superadmin'){ ?>
    <div class="form-group">
        <?= Html::submitButton( 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
<?php } ?>
    <div id="ajaxLoad">
        <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
    </div>
    <?php
    
    ActiveForm::end(); ?>
    
</div>

<?php
$script = <<< JS
        
$('#AxionPreinspection').on('beforeSubmit', function(e) 
{
        var lastStatus = $('#lastStatus').val();
        var newRecord = $('#newRecord').val();
        // var companyId=$('#companyId').find('option:selected').val();
        var extraKM = $('#axionpreinspection-extrakm').val();
        var surveyLocation = $('#axionpreinspection-surveylocation').val();
        var surveyLocation2 = $('#axionpreinspection-surveylocation2').val();
        
        if(extraKM =='')
        {
            alert("Please enter extra KM");
            return false;
        }

            if(surveyLocation == '')
            {
             alert("Please enter Survey From Location");
             return false;
            }
             if(surveyLocation2 == '')
            {
             alert("Please enter Survey To Location");
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
                   if(data != '')
                   {
                      if(data == 'noajax success')
                      {
                        
                        alert("Request  Created Successfully...");
                        
                        window.location.href = "./";
                      }
                      else{
                        alert("Records Updated Succesfully");
                        
                        $(document).find('#create-modal').modal('hide');
                        $(document).find('#update-modal').modal('hide');
                        $(form).trigger("reset");
                        //$('#w0').yiiGridView('applyFilter');
                        $("#loading-image").hide();
                        location.reload();
                      }
                    }
            },
            error: function (jqXHR, exception) {
                //alert("Something went wrong");
                alert(jqXHR.responseText);
            }
        });
}).on('submit', function(e){
    e.preventDefault();
});

JS;
$this->registerJS($script);
?>


