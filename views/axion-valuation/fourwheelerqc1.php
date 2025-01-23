<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionFourwheeler */
/* @var $form ActiveForm */


if(isset($valuator))
{
    $valuatorData=ArrayHelper::map($valuator,'id','firstName');
}
else {
    $valuatorData= [''=>'Select'];
}

$statusArray = $model->qcStatusvalue;
$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$fuelTypeArray = $model->fuelTypevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;

$centreLockList= [
  ['id' => '', 'name' => '-Select-'],
  ['id' => 'YES', 'name' => 'YES'],
  ['id' => 'NO', 'name' => 'NO'],
];
$centreLockArray = ArrayHelper::map($centreLockList, 'id', 'name');
?>
<div class="axion-preinspection-fourwheelerqc">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <h2 style="text-align: center">FOUR WHEELER QC</h2>
    <h4 class="preinspection-box-title">Customer, Client and Vehicle Details</h4>
    <div id="company_details" class="preinspection-box">
    
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'referenceNo')->textInput(['readonly' => true,'maxlength' => true]) ?>
    </div>    
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerName') ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerMobile') ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'clientName') ?>
    </div>
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'actualCashCollected') ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerAddress') ?>
    </div> 
        
    <div class="form-prerow-other">     
    <?= $form->field($premodel, 'extraKM') ?>
    </div> 
   
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'customerAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->customerAppointDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->customerAppointDateTime )):'']) ?>
    </div> 
        
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'completedSurveyDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):'']) ?>
    </div>
        
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'variant')->dropDownList($inspectionTypeArray) ?> 
    </div>
      
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'executiveName')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Name') ?>
    </div>    

    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'executiveMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Mobile No') ?>
    </div>
    
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'executiveEmailId')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Email Id') ?>
    </div>    
    
    <div class="form-prerow-other">    
    <?= $form->field($premodel, 'registrationNo') ?>
    </div>    

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'engineNo') ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'chassisNo') ?>
    </div>    
    
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturer') ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'model') ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturingYear') ?>
    </div>
    
    </div>
    <div class="clear"></div> 
    <h4 class="preinspection-box-title">Inspection Details</h4>
     <div id="inspection_details" class="preinspection-box">
        <div class="form-prerow-other">
                <?= $form->field($model, 'colour') ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($model, 'odometerReading') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'rcVerified')->dropDownList($rcArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'fuelType')->dropDownList($fuelTypeArray)  ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'othersOption')->dropDownList(['COMPANY FITTING'=>'COMPANY FITTING']);?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cubicCapacity')->dropDownList(['COMPANY FITTING'=>'COMPANY FITTING']);?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'centerLock')->dropDownList($centreLockArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontBumper')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'paint')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLamp')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'indicatorLight')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'bonnet')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftApron')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightApron')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'dicky')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearBumper')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'transmission')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontFender')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRearDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRunningBoard')->dropDownList($damageType1Array) ?>
         </div>
       
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRear')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltQtrPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtQtrPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRearDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontPillar')->dropDownList($damageType1Array) ?>
         </div>
       <div class="form-prerow-other">
        <?= $form->field($model, 'rtRear')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRunningBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontFender')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyreCondition')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'noOfTyre')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRearTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRearTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'windShield')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'windShieldGlassCondition')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'underCarriage')->dropDownList($damageType4Array) ?>
         </div>
         
         <div class="form-prerow-other">     
            <?= $form->field($premodel, 'remarks') ?>
         </div>

        <div class="form-prerow-other">  
             <?= $form->field($premodel, 'status')->dropDownList($statusArray) ?>  
         </div>      

        <div class="form-prerow-other">
            <?= $form->field($premodel, 'valuatorName')->dropDownList($valuatorData);?>
        </div> 
            
         
     </div>
    <div class="clear"></div>
    <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
         <div class="form-prerow-other">
           <!--  <input type="file" accept="image/*;capture=camera">
             <?= $form->field($model, 'chassisPhoto')->fileInput() ?> -->
             <?= $form->field($model, 'chassisPhoto')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*;capture=camera'],
]); ?>
             
         </div> 
         <div class="clear"></div>
         <?php
         if($model->chassisPhoto != '')
         {
             ?>
         <div style="margin-bottom:30px" id='chassis-photo-<?= $model->id; ?>' >
         <?= Html::img('@web/'.$qcLoc.$model->chassisPhoto,["width"=>"200px","height"=>"200px"]) ?>
             <?= Html::a('Remove', '#', ['class' => 'btn btn-primary remove-chassis', 'id'=>''.$model->id.'']) ?>  
         </div>
         
         <?php
         }
         ?>
        <div class="form-prerow-other">
            <!--
                <?= $form->field($phmodel, 'photo[]')->fileInput(['multiple' => 'multiple', 'accept' => 'image/*'])->label('Photos') ?>
            -->
            <?= $form->field($phmodel, 'photo[]')->widget(FileInput::classname(), [
    'options' => ['multiple' => true,'accept' => 'image/*;capture=camera'],
]); ?>
        </div>
         <div class="clear"></div>
         <?php
         if($photos)
         {
             foreach($photos as $obj)
             {
             ?>
                <div class="form-prerow-other" style="margin-right: 30px;" id='other-photo-<?= $obj->id; ?>' >
                <?= Html::img('@web/'.$qcLoc.$obj->photo,["width"=>"200px","height"=>"200px"]) ?>
                 <?= Html::a('Remove', '#', ['class' => 'btn btn-primary remove-other', 'id'=>''.$obj->id.'']) ?>     
                </div>
                <?php
             }
         }
         ?>
         <div class="clear"></div>
     </div>
        

    <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->
        
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/fourwheelerpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
        ]);} ?> 
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- axion-preinspection-fourwheelerqc -->
<?php $this->registerJs(
"$('.remove-chassis').on('click', function(){
    var id = $(this).attr('id');
    //alert('#chassis-photo-'+id);
    //return false; 
 $.post(
        '".Yii::$app->request->baseUrl."/axion-preinspection/remove-photo', 
        {
            id : id,
            type: 'chassis',
            qc: 'fourwheeler'
        },
        function (data) {
          if(data == 1)
          {
             $('#chassis-photo-'+id).css('margin','0px');
             $('#chassis-photo-'+id).html('');
          }
          
        }
    );
    return false;
});
    "
); ?>

<?php $this->registerJs(
"$('.remove-other').on('click', function(){
    var id = $(this).attr('id');
    //alert('#other-photo-'+id);
    //return false; 
 $.post(
        '".Yii::$app->request->baseUrl."/axion-preinspection/remove-photo', 
        {
            id : id,
            type: 'other',
            qc: 'fourwheeler'
        },
        function (data) {
          if(data == 1)
          {
             $('#other-photo-'+id).css('margin','0px');
             $('#other-photo-'+id).html('');
          }
        }
    );
    return false;
});
    "
); ?>