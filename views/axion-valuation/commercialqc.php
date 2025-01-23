<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\AxionValuationCommercial */
/* @var $form ActiveForm */


if(isset($valuator))
{
    $arr = [
            'add' => [
                'id' => '0',
                'firstName'=>'Customer'
            ],
        ];
    $valuator = ArrayHelper::merge($arr, $valuator);
    $valuatorData=ArrayHelper::map($valuator,'id','firstName');
    
}
else {
    $valuatorData= [''=>'Select','0'=>'Customer'];
}

$typeName = $phmodel[0]->typeName;
$locStatus = $phmodel[0]->locStatusValue;
$timeStatus = $phmodel[0]->timeStatusValue;

if($model->vehicleTonnage == '')
{
  $model->vehicleTonnage = 'NA';  
}

$statusArray = $model->qcStatusValue;
if($role == 'Surveyor')
{
  $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '8', 'name' => 'Survey Done'], 
    ]; 
  $statusArray = ArrayHelper::map($statusList, 'id', 'name');
}
else if($role == 'Superadmin' || $role == 'Admin')
{
    $statusArray = $statusArray +  ['9' => 'Cancelled']; 
}


$RatingArray = $model->CommenValue;
if($role == 'Surveyor')
{
    $RatingList =[
              ['id' => '1', 'name' => 'Average'],
              ['id' => '2', 'name' => 'Good'],
              ['id' => '3', 'name' => 'Excellent'],
              
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '-2', 'name' => 'VeryBad'],
              ['id' => '-3', 'name' => 'NA'],   
    ];
     $RatingArray = ArrayHelper::map($RatingList, 'id', 'name');
        return $RatingArray;
}
// else 
// {
//     return $RatingArray; 
// }


$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$fuelTypeArray = $model->fuelTypevalue;
$bodyTypeArray = $model->bodyTypevalue;
$cabinArray = $model->cabinValue;
$LoadBodyBuildArray =$model->LoadBodyBuildValue;
$paintArray = $model->paintValue;
$AbsArray = $model->AbsValue;
$AxleArray = $model->AxleValue;
$SeatsArray = $model->SeatsValue;
$WsArray = $model->WsValue;
$SteeringArray = $model->SteeringValue;
$noOftyreArray = $model->noOftyreValue;
$VPLocationArray = $model->VPLocationValue;
$VConditionArray = $model->VConditionValue;
$NoOfOwnersArray = $model->NoOfOwnersValue;
$monthArray = $model->monthValue;
$yearArray = $model->yearValue;
$InsuranceTypeArray = $model->InsuranceTypeValue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
$damageType5Array = $model->damageType5value;
$damageType6Array = $model->damageType6value;
$damageType7Array = $model->damageType7value;
$damageType8Array = $model->damageType8value;
$damageType9Array = $model->damageType9value;
$damageType10Array = $model->damageType10value;
$damageType11Array = $model->damageType11value;
$damageType12Array = $model->damageType12value;
$damageType13Array = $model->damageType13value;
$damageType14Array = $model->damageType14value;
$damageType15Array = $model->damageType15value;
$damageType16Array = $model->damageType16value;

$companyList =ArrayHelper::map($company,'id','companyName');

$callerList = ArrayHelper::map($caller,'id','firstName');

$makeList =ArrayHelper::map($cmodel,'id','make');

$modelList = ArrayHelper::map($vmodel,'id','model');

$variantList = ArrayHelper::map($exmodel,'id','variant');

?>


<div class="axion-preinspection-commercialqc" style="color:black;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
     <table class="table" border="2">
  <th>
    <h2 style="text-align: center">COMMERCIAL QC</h2>
     <table class="table" border="2">
  <th>
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
    <?= $form->field($premodel, 'insurerName')->dropDownList($companyList,['id'=>'companyId']); ?>
    </div>
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'actualCashCollected') ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerAddress') ?>
    </div> 
        
    <div class="form-prerow-other">     
    <?= $form->field($premodel, 'extraKm') ?>
    </div> 
   
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'customerAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->customerAppointDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->customerAppointDateTime )):'']) ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'completedSurveyDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                      

                            ]
                        ]
                ]) ?>    

    </div>
        
    
      
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerName')->dropDownList($callerList,['id'=>'callerId']) ?>
    </div>    

    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Mobile No') ?>
    </div>
    
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerDetails')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Email Id') ?>
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
    <?= $form->field($premodel, 'month')->dropDownList($monthArray); ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturingYear')->dropDownList($yearArray); ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'makeId')
    ->dropDownList($makeList); 
    ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'modelId')
     ->dropDownList($modelList);
     ?>
    </div>
     <div class="form-prerow-other" >
    <?= $form->field($premodel, 'variantId')
     ->dropDownList($variantList);
     ?> 
    </div>

   <div class="form-prerow-other">
    <?= $form->field($premodel, 'exShowroomPrice')->hiddenInput()->label(false); ?>
    </div>
    
    <?php if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) { ?>
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'contactPersonMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Unique Lead Number') ?>
    </div>   
     <?php
    } ?></th></table>
    </div>

    <div class="clear"></div> 
     <table class="table" border="2">
     <th>
    <h4 class="preinspection-box-title">Valuation Details</h4>
     <div id="inspection_details" class="preinspection-box">
        <div class="form-prerow-other">
        <?= $form->field($model, 'odometerReading') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'rcVerified')->dropDownList($rcArray) ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'bodyType')->dropDownList($LoadBodyBuildArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'fuelType')->dropDownList($fuelTypeArray)  ?>
        </div>
    
         <div class="form-prerow-other">
        <?= $form->field($model, 'interior')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontCabin')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rear')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cabinDoorRight')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cabinDoorLeft')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'paint')->dropDownList($paintArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cubicCapacity')->textInput() ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'transmissionCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'overAllLoadBody')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftBodyCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightBodyCondition')->dropDownList(
$RatingArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'abs')->dropDownList($AbsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cluthCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'steering')->dropDownList($SteeringArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLampTailLamp')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ac')->dropDownList($AbsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'liftAxile')->dropDownList($AbsArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'brakes')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'taxValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);  ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'fcValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);  ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'differentialCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'chassisCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleCondition')->dropDownList($VConditionArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleOwnership')->dropDownList($NoOfOwnersArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'dieselPump')->dropDownList($damageType16Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'hpa')->dropDownList($AbsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'paintCondition')->dropDownList(
$RatingArray) ?>
         </div>
          <div class="form-prerow-other">
        <?= $form->field($model, 'suspension')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'noOfSeats')->dropDownList($SeatsArray) ?>
         </div>
          <div class="form-prerow-other">
        <?= $form->field($model, 'seatsCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'noOfTyre')->textInput() ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'axleCondition')->dropDownList(
$RatingArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'windShield')->dropDownList($WsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'loadFloor')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tailGate')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyreCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'batteryCondition')->dropDownList(
$RatingArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'engineCondition')->dropDownList(
$RatingArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'hpaBank')->dropDownList($damageType9Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleParkingLocation')->dropDownList($VPLocationArray) ?>
         </div>
             
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleTonnage')->textInput(); ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rcOwnerName') ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'roadPermit')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'insuranceType')->dropDownList($InsuranceTypeArray); ?>
         </div>
        <div class="form-prerow-other">
         <?= $form->field($model, 'insuranceDate')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
                ?>
            </div>


      <div class="form-prerow-other">     
       <?= $form->field($premodel, 'systemGeneratedMarketValue')->textInput(['readonly' => true])->label('System Market Value'); ?>
         </div>
         
         
         <div class="form-prerow-other">     
            <?= $form->field($premodel, 'fixedMarketValue')->textInput(); ?>
         </div>
         
         <div class="form-prerow-other">     
            <?= $form->field($premodel, 'remarks') ?>
         </div>

        <div class="form-prerow-other">  
             <?= $form->field($premodel, 'status')->dropDownList($statusArray) ?>  
         </div>      
          <?php if($role != 'Customer') { ?>
        <div class="form-prerow-other">
            <?= $form->field($premodel, 'surveyorName')->dropDownList($valuatorData);?>
        </div> 
        <?php } ?>
            
         <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 
      </th></table>
  </div>

    <div class="clear"></div>
    
    <?php if($premodel->surveyorName == 0 ) { ?>
  <table class="table" border="2">
  <th>
    <h4 class="preinspection-box-title">Video Session</h4>
    <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px; text-align: center">

    <?php if($customerSession > 0) { 
        ?>
            <?= Html::a('Video Session', ['axion-valuation/video-session', 'id' => $premodel->id], ['class' => 'btn btn-primary']) ?>
           <?php 
        } else{ 
            if($role != '' && $role != 'Customer')
            {
            ?>
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Create Customer Video Session', ['class' => 'btn btn-primary', 'value'=>'create_session', 'name'=>'create_session']) ?>
        </div>
            <?php  }
            
            }   ?>
     </div>
    <?php  }   ?>
</th></table>
    <div class="clear"></div>

  <table class="table" border="2">
  <th>
    <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
    <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($vqcLoc.$obj->image);
            echo '<div class="form-prerow-image">';
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-valuation/image-upload']),
                        'uploadExtraData' => [
                            'id' => $obj->preinspection_id,
                            'type'=> $obj->type,
                        ],
                       'initialPreview' => [
                            $obj->image ? $imgUrl : null, // checks the models to display the preview
                        ],
                        'allowedFileExtensions' => ["jpg", "jpeg"],
                        //'maxImageWidth' => 500,
                        //'maxImageHeight' => 500,
                        'resizePreference' => 'height',
                        'maxFileCount' => 1,
                        'resizeImage' => true,
                        'resizeIfSizeMoreThan' => 100,
                        'showRemove' => false,
                        'showUpload' => false,
                        'overwriteInitial'=>false,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-valuation/remove-photo']),
                                'key'=> $obj->id,
                            ],

                        ],         
                    ],
            ])->label($typeName[$obj->type]);
           
            
            echo '</div>';
            echo '<div class="clear"></div>';

        }
       
        ?>
     </div>
    <div class="clear"></div>

</th></table>
</th></table>
  <div class="clear"></div>
      <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-valuation/commercialpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200) { echo Html::a('Download Photos', ['/axion-valuation/downloadphotos?id='.$premodel->id], [
    'class'=>'btn',  
    'data-toggle'=>'tooltip', 
    'title'=>'Download Photos'
        ]); }?>
        <?php if($role != 'Customer' && $role != '') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-danger']) ?>
        <?php } ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- axion-preinspection-commercialqc -->




<?php
if(!Yii::$app->session->get('user.lat') || !Yii::$app->session->get('user.long'))
{
    $appUrl = Yii::$app->request->baseUrl;
$script = <<< JS
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(storePosition,showError);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}

function storePosition(position) {
        $('#bLat').val(position.coords.latitude);
        $('#bLong').val(position.coords.longitude);
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        $.post(
        '$appUrl/axion-valuation/assign-location', 
        {
            lat : lat,
            long: long,
        },
        function (data) {
          if(data == 0)
          {
             //alert('location updated');
          }
        }
    );
}
        
        function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
    
$(document).ready( function () {
  getLocation();
});        

JS;
$this->registerJS($script);
}
?>