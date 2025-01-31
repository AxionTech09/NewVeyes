<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

















//$model->insurerName = Yii::$app->user->identity->companyId;
//$model->insurerDivision = Yii::$app->user->identity->divisionId;
//$model->insurerBranch = Yii::$app->user->identity->branchId;

$stateList=ArrayHelper::map($state,'id','state');

?>

<div class="preinspection-form">

    <?php $form = ActiveForm::begin(['id'=>$smodel->formName()]); ?>
    
    
    <div id="changerolist" class="changerolist">
        
         <?php
       

          echo $form->field($smodel, 'state')->dropDownList($stateList,['id'=>'stateId','prompt'=>'Select RO Office State'])->label("Choose RO Office");
        
         ?>  
   
  
    
    
     </div>
    
    
    <br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Assign', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div id="ajaxLoad">
        <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
    </div>
   

    <?php ActiveForm::end(); ?>
    

</div>
<?php
$script = <<< JS
        
$('#MasterState').on('beforeSubmit', function(e) 
{


        // var stateId = $('#statseId').val();
        // var newRecord = $('#newRecord').val();
        var stateId = $('#stateId').find('option:selected').val();

       
         
        
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
                    var res = $.parseJSON(data)
                    if(data=='success')
                    {
                      alert('RO List Moved');
                      $('#changero-modal').modal('toggle');
                      //document.getElementById("output").innerHTML = data;
                        // $(document).find('#create-modal').modal('hide');
                        // $(document).find('#update-modal').modal('hide');
                        $('#MasterState').trigger("reset");
                        $('#w0').yiiGridView('applyFilter');
                        $("#loading-image").hide();
                    }
                    else
                    {
                      alert(res.msg);
                      return false;
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


