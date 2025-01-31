<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\file\FileInput;



/* @var $this yii\web\View */
/* @var $model app\models\Loans */
/* @var $form yii\widgets\ActiveForm */



$lstateArray = $model->loanStateValue;
$cardealersList = ArrayHelper::map($cardealers,'id','firstName');




?>



 <h4 class="preinspection-box-title">Customer Details</h4>
  
 <div class="preinspection-box">
    
    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'options' => ['enctype' => 'multipart/form-data']]); ?>
    <table class="table" border="2">  <td>
    <div class="form-prerow1">
     <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    </div>
   <div class="form-prerow-other">
    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="form-prerow-other">
      <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="form-prerow-other">
      <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
  </div>
    <div class="clear"></div>
      <div class="form-prerow1">
      <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="form-prerow-other">

      <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="form-prerow-other">
      <?= $form->field($model, 'city')->dropDownList($lstateArray) ?>
  </div>
  <div class="form-prerow-other">

      <?= $form->field($model, 'state')->dropDownList(['1' => 'TamilNadu' , '2' => 'Karnataka'],['prompt' => '-Select-']) ?>
  </div>
   <div class="clear"></div>
      <div class="form-prerow1">
      <?= $form->field($model, 'pincode')->textInput() ?>
  </div>
     <div class="form-prerow-other">
    <?= $form->field($model, 'dob')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]); ?>
     </div>

     <div class="form-prerow-other">
      <?= $form->field($model, 'vehicleRegNo')->textInput() ?>
  </div>
  <div class="form-prerow-other">
      <?= $form->field($model, 'loanAppliedAmount')->textInput() ?>
  </div>
  <div class="clear"></div>
  <div class="form-prerow1">
      <?= $form->field($model, 'panNumber')->textInput(['maxlength' => true]) ?>
  </div>
    
      <div class="form-prerow-other">
      <?= $form->field($model, 'aadharNumber')->textInput(['maxlength' => true]) ?>
  </div>
      <div class="form-prerow-other">
      <?= $form->field($model, 'creditScore')->textInput() ?>
  </div>
  <div class="form-prerow-other">
      <?= $form->field($model, 'employmentType')->dropDownList(['Salaried' => 'Salaried','Professional' => 'Professional' , 'Business'=> 'Business', 'Retired' => 'Retired'],['prompt' => 'select']) ?>
  </div>
    <div class="clear"></div>

  <div class="form-prerow1">
      <?= $form->field($model, 'loanType')->dropDownList(['NewCarLoan' => 'New Car Loan','UsedCarLoan' => 'Used Car Loan' , 'CommercialVehicleLoan'=> 'Commercial Vehicle Loan', 'ConstructionEquipmentLoan' => 'Construction Equipment Loan'],['prompt' => 'select']) ?>
    </div>
 
<?php if($role != 'Car Dealers') { ?>
            
           
       

    <div class="form-prerow-other">
      <?=
      $form->field($model, 'sourceType')->dropDownList(['associateDealers' => 'Associate Dealers','directCustomer' => 'Direct Customer'],['prompt' => 'select'])  ?>
    </div>

   
    <div class="form-prerow-other">
       <?php 
            
       echo $form->field($model, 'sourceId')->dropDownList($cardealersList,['prompt' => 'select'])

     ?>
    </div>

<?php } ?>
    
  </td></table>  
<?php if($role != 'Car Dealers' && $role != 'Surveyor') { ?>
      <div class="clear"></div>

 <?php if(isset($bkmodel)) { ?>


         <h4 class="preinspection-box-title">Loan Details</h4> 
             <table class="table" border="2"><td>
            
              <div class="row">
              <?php  foreach ($bkmodel as $obj) { ?>
                <div class="col-md-1">
                  <?php  //echo $form->field($obj,'id')->hiddenInput(); ?>
             
                
                    <?php echo $form->field($obj,'selected['.$obj->id.']')->checkBox([
                              'label' => $obj->bankdata->bankName,
                              'checked'=>($obj->selected == 1)?true:false
                            ]); 
                              ?>
                        
                </div>
                <div class="col-md-2">
                  <?php echo $form->field($obj,'bankBranch['.$obj->id.']')->dropDownList([$obj->bankdata->branch => $obj->bankdata->branch],['prompt'=>'select','value' => $obj->bankBranch]);?>
                </div>
      
                <div class="col-md-2">
                  <?php echo $form->field($obj,'bankAmount['.$obj->id.']')->textInput(['value'=>$obj->bankAmount]);?>
                </div>
                <div class="col-md-2">
                  <?php echo $form->field($obj,'loanTenure['.$obj->id.']')->textInput(['value'=>$obj->loanTenure]);?>
                </div>
                <div class="col-md-1">
                  <?php echo $form->field($obj,'rateOfIntrest['.$obj->id.']')->textInput(['value'=>$obj->rateOfIntrest]);?>
                </div>
            
                <div class="col-md-2">
                  <?php echo $form->field($obj,'emi['.$obj->id.']')->textInput(['value'=>$obj->emi]);?>
                </div>
                <div class="col-md-2"><?php
                      echo $form->field($obj, 'bankStatus['.$obj->id.']')->dropDownList(['new' => 'New','inProgress' => 'IN Progress' , 'onHold'=> 'ON Hold', 'approved' => 'Approved', 'disbursed' => 'Disbursed', 'rejected' => 'Rejected'],['prompt' => 'select','value' => $obj->bankStatus]); ?>
                        
                </div>
          <?php  print '&nbsp;<hr/>'; } ?>
          </div>
   </td></table>
   <?php  } ?>

   <?php } ?>
    <div class="clear"></div>


     <?php if(isset($ldmodel)) { ?>

  

      <h4 class="preinspection-box-title">Document Uploads</h4>
        <table class="table" border="2">  <td>
            <div class="row">
              <div class="col-md-5">
                <?php 
                  
                foreach ($ldmodel as $obj) {
                  
           echo  $form->field($obj, 'docFile['.$obj->docType.']')->widget(FileInput::classname(), [
                              'options' => [],
                              'pluginOptions' => [
                              'showPreview' => true,
                              'previewFileType' => 'any',
                              'showCaption' => false,
                              'showUpload' => false,
                            ]
            ])->label($obj->docTitle);

           //here u can give link to existing file - u can get document file in $obj->docFile.
          if($obj->docFile != '') {
            //echo $obj->docFile;
            echo '<a href="'.Url::to('@web/'.$obj->docFile).'" style="color:red;font-size:20px;"  target="_blank">View '.$obj->docTitle.' Document</a>';

          } 

        }  
    

         ?>
              </div>
            </div>
       <?php } ?>   
</td></table>

    <div class="clear"></div>



        <div class="form-group">
   
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',     ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

 <?php ActiveForm::end(); ?>

   

</div>



