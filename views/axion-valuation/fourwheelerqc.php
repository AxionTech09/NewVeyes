<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\VehicleMake;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\AxionValuationFourwheeler */
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


$generalArray = $model->ltrearValue;
if($role == 'Surveyor')
{
    $generalList =[
              ['id' => '1', 'name' => 'Average'],
              ['id' => '3', 'name' => 'Excellent'],
              ['id' => '2', 'name' => 'Good'],
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '-2', 'name' => 'VeryBad'],
              ['id' => '-3', 'name' => 'NA'],
    ];
    $generalArray = ArrayHelper::map($generalList, 'id','name');
     return $generalArray;
}
 
$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$paintArray = $model->paintValue;
$transmissionArray = $model->transmissionValue;
$tyreconditionArray = $model->tyreconditionValue;
$noOftyreArray = $model->noOftyreValue;
$windshieldArray = $model->WindshieldValue;
$bagsArray = $model->bagsValue;
$seatsArray = $model->seatsValue;
$insuranceArray = $model->insuranceValue;
$VTypeArray = $model->VTypeValue;
$vehicleParkingLocationArray = $model->vehicleParkingLocationValue;
$monthArray = $model->monthValue;
$yearArray = $model->yearValue;
$rcstatusArray = $model->rcstatusValue;
$fuelTypeArray = $model->fuelTypevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
$damageType5Array = $model->damageType5value;

$centreLockList= [
  ['id' => '', 'name' => '-Select-'],
  ['id' => 'YES', 'name' => 'YES'],
  ['id' => 'NO', 'name' => 'NO'],
];
$centreLockArray = ArrayHelper::map($centreLockList, 'id', 'name');


$companyList =ArrayHelper::map($company,'id','companyName');

$callerList = ArrayHelper::map($caller,'id','firstName');

$makeList =ArrayHelper::map($cmodel,'id','make');

$modelList = ArrayHelper::map($vmodel,'id','model');

$variantList = ArrayHelper::map($exmodel,'id','variant');

?>

<div class="axion-preinspection-fourwheelerqc" style="color:black;">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'options' => ['enctype' => 'multipart/form-data']]); ?>
    <table class="table" border="2">
  <th>
    <h2 style="text-align: center">FOUR WHEELER QC</h2>
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
    <?= $form->field($premodel, 'actualCashCollected')->textInput(['readonly' => true,'maxlength' => true]) ?>
    </div> 
    
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerAddress') ?>
    </div> 
        
    <div class="form-prerow-other">     
    <?= $form->field($premodel, 'callerDetails') ?>
    </div> 
   
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'customerAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->customerAppointDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->customerAppointDateTime )):'']) ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'completedSurveyDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]) ?>    
    <?php //echo $form->field($premodel, 'completedSurveyDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):'']) ?>
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

    <?= $form->field($premodel, 'registrationYear')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>  
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
    <?= $form->field($premodel, 'exShowroomPrice')->hiddenInput()->label(false);?>
    </div>
    <!-- <div class="form-prerow-other">
    <?= $form->field($premodel, 'depriAmount')->textInput(); ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'syd1to5')->textInput(); ?>
    </div>
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'syd6to8')->textInput(); ?>
    </div>

    <div class="form-prerow-other">
        <?= $form->field($premodel, 'age')->textInput(); ?>        
    </div>
    <div class="form-prerow-other">
        <?= $form->field($premodel, 'calculation')->textInput(); ?>
    </div>
    <div class="form-prerow-other">
        <?= $form->field($premodel, 'currentDepric')->textInput(); ?>
    </div> -->

    <div class="form-prerow-other">     
       <?= $form->field($premodel, 'fixedMarketValue')->hiddenInput()->label(false) ?>
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
        <?= $form->field($model, 'rcOwnerName')->textInput() ?>
         </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'fuelType')->dropDownList($fuelTypeArray)  ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'paint')->dropDownList($paintArray) ?>
         </div>
          <div class="form-prerow-other">
        <?= $form->field($model, 'paintCondition')->dropDownList($generalArray) ?>
         </div>

         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleType')->dropDownList($VTypeArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleCondition')->dropDownList($generalArray) ?>
         </div>
  
         <div class="form-prerow-other">
        <?= $form->field($model, 'noOfOwners')->dropDownList($noOftyreArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'chassisAndVehicleFrame')->dropDownList($generalArray) ?>
         </div>
         
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'powerWindows')->dropDownList($bagsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'alloyWheels')->dropDownList($bagsArray) ?>
         </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'cruiseControl')->dropDownList($bagsArray) ?>
         </div>
       
       <div class="form-prerow-other">
    <?= $form->field($model, 'airCondition')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'cubicCapacity') ?>
         </div>
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLampAndTailLamp')->dropDownList($generalArray) ?>
         </div>
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyreCondition')->dropDownList($tyreconditionArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'noOfTyre') ?>
         </div>
         

        
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontBumperBonnet')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearBumperBonnet')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rhFenderDoors')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'lhFenderDoors')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'engineCondition')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'chassisCondition')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'brakes')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'suspension')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'transmissionCondition')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'airBags')->dropDownList($bagsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'absDrop')->dropDownList($bagsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'windShield')->dropDownList($windshieldArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'interierAccessories')->dropDownList($generalArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'seats')->dropDownList($seatsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'seatsCondition')->dropDownList($generalArray) ?>
         </div>
        
         <div class="form-prerow-other">
                <?= $form->field($model, 'colour') ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'batteryCondition')->dropDownList($generalArray) ?>
         </div>
        
         
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'insuranceType')->dropDownList($insuranceArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'vehicleParkingLocation')->dropDownList($vehicleParkingLocationArray) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'insuranceDate')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'taxValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>

         <div class="form-prerow-other">
        <?= $form->field($model, 'fcValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'hpaStatus')->dropDownList($bagsArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'hpaBank') ?>
         </div>
         
            

        <div class="form-prerow-other">     
            <?= $form->field($premodel, 'systemGeneratedMarketValue')->textInput(['readonly' =>true,'maxlength' => true])->label('System Market Value'); ?>
         </div>
         
         

         <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'finalRating')->textInput(); ?>
         </div> -->

         <div class="form-prerow-other">     
       <?= $form->field($premodel, 'fixedMarketValue') ?>
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
    <div id="inspection_photos"  style="background-color:white;" class="preinspection-box" style="margin-bottom: 30px">
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
    <!--  -->
 </th></table>
</th></table>
    <div class="clear"></div>
    <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
        <!-- echo "save"; -->
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->
        
        <?php 
        // echo $premodel->status;
        if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200 )
            // || $premodel->status == 200 
        {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-valuation/fourwheelerpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
        ]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200 ) { echo Html::a('Download Photos', ['/axion-valuation/downloadphotos?id='.$premodel->id], [
    'class'=>'btn btn-primary',  
    'data-toggle'=>'tooltip', 
    'title'=>'Download Photos'
        ]); }?>
        <?php if($role != 'Customer' && $role != '') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-danger']) ?>
        <?php } ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- axion-preinspection-fourwheelerqc -->

<?php $this->registerJs(
"$('.remove-image').on('click', function(){
    var id = $(this).attr('id');
    //alert('#photo-'+id);
    //return false; 
 $.post(
        '".Yii::$app->request->baseUrl."/axion-valuation/remove-photo', 
        {
            id : id,
        },
        function (data) {
          if(data == 1)
          {
             $('#photo-'+id).css('margin','0px');
             $('#photo-'+id).html('');
          }
        }
    );
    return false;
});



    "
); 

?>


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
