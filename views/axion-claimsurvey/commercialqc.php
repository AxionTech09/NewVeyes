<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionCommercial */
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

if($model->extraFittings == '')
{
  $model->extraFittings = 'NA';  
}

$statusArray = $model->qcStatusvalue;
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
$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$fuelTypeArray = $model->fuelTypevalue;
$bodyTypeArray = $model->bodyTypevalue;
$cabinArray = $model->cabinValue;
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

?>
<div class="axion-preinspection-commercialqc">

    <?php if(isset($_GET['response'])) { echo $_GET['response']; } ?>

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'options' => ['enctype' => 'multipart/form-data'],'enableAjaxValidation'=>true,'validationUrl' => ['axion-preinspection/validation','id' =>$premodel->id],]); ?>
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
    <?= $form->field($premodel, 'insuredName') ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'insuredMobile') ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'insurerName')->dropDownList($companyList,['id'=>'companyId']); ?>
    </div>
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'cashCollection') ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'insuredAddress') ?>
    </div> 
        
    <div class="form-prerow-other">     
    <?= $form->field($premodel, 'extraKM') ?>
    </div> 
   
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'customerAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->customerAppointDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->customerAppointDateTime )):'']) ?>
    </div> 
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'completedSurveyDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                // 'required'=>true,
            
                    'pluginOptions' => [
                        'autoclose' => true,

  
      
                        // 'validateOnSubmit'=>true
                        
                            ]
                        ]
                ]) ?>    
    <?php //echo $form->field($premodel, 'completedSurveyDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):'']) ?>
    </div>
        
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'inspectionType')->dropDownList($inspectionTypeArray) ?> 
    </div>
      
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerName')->dropDownList($callerList,['id'=>'callerId']) ?>
    </div>    

    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Caller Mobile No') ?>
    </div>
    
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'callerDetails')->textInput(['readonly' =>true,'maxlength' => true])->label('Caller Email Id') ?>
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
    <?= $form->field($premodel, 'makeId') ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'modelId') ?>
    </div>

        <div class="form-prerow-other">
    <?= $form->field($premodel, 'variantId') ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturingYear') ?>
    </div>
    <?php if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) { ?>
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'contactPersonMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Unique Lead Number') ?>
    </div>   
     <?php
    } ?>
    </div>
    </th>
</table>
    <div class="clear"></div> 
    <table class="table" border="2">
  <th>
    <h4 class="preinspection-box-title">Inspection Details</h4>
     <div id="inspection_details" class="preinspection-box">
        <div class="form-prerow-other">
        <?= $form->field($model, 'odometerReading') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'rcVerified')->dropDownList($rcArray) ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'typeOfBody')->dropDownList($bodyTypeArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'fuelType')->dropDownList($fuelTypeArray)  ?>
        </div>
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'cabin')->dropDownList($cabinArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'dashBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontSideBody')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearSideBody')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightSideBody')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftSideBody')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontExcavator')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'bonnet')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'craneBucket')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'craneHook')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ac')->dropDownList($damageType4Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'boom')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'fans')->dropDownList($damageType4Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'hydrualicSystem')->dropDownList($damageType5Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'chassisFrame')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'fuelTank')->dropDownList($damageType16Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'seats')->dropDownList($damageType6Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyres')->dropDownList($damageType7Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'spareTyre')->dropDownList($damageType8Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLights')->dropDownList($damageType9Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'indicatorLights')->dropDownList($damageType9Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'doors')->dropDownList($damageType10Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'wsGlass')->dropDownList($damageType11Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftWindowGlass')->dropDownList($damageType12Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightWindowGlass')->dropDownList($damageType13Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'backGlass')->dropDownList($damageType14Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'excavatorCabinGlass')->dropDownList($damageType15Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'craneCabinGlass')->dropDownList($damageType15Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearViewMirrors')->dropDownList($damageType15Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tailLamps')->dropDownList($damageType9Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'extraFittings') ?>
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
     </div>
     </th></table>
    <div class="clear"></div>
    
        <?php if($premodel->surveyorName == 0) { ?>
        <table class="table" border="2">
  <th>
    <h4 class="preinspection-box-title">Video Session</h4>
    <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px; text-align: center">

    <?php if($customerSession > 0) { 
        ?>
            <?= Html::a('Video Session', ['axion-preinspection/video-session', 'id' => $premodel->id], ['class' => 'btn btn-primary']) ?>
           <?php 
        } else{ 
            
            if($role != '' && $role != 'Customer')
            {
            
            ?>
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Create Customer Video Session', ['class' => 'btn btn-primary', 'value'=>'create_session', 'name'=>'create_session']) ?>
        </div>
            <?php } 
            
            }   ?>
     </div>
    <?php  }   ?>
    </th></table>
     <div class="clear"></div>
     
     <table class="table" border="2">
  <th>
     <h4 class="preinspection-box-title">Take Photos</h4>
     <div class="row">&nbsp;</div>
      <input type="hidden" name="" id="photoType">
     

        <?php
        

         foreach($phmodel as $obj)
          { 
            $qcLoc = \Yii::$app->params['qcLoc'];
            if($obj->image!= '')
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
            else
            $imgUrl = '';    
            ?>
             <div class="btn btn-primary cm-<?php echo $obj->type; ?>">Upload <?php echo $obj->type; ?></div>
             <img src="<?php echo $imgUrl; ?>" id="<?php echo $obj->type; ?>" />   
             <?= Html::a('Remove', '#', ['class' => 'btn btn-primary remove-image', 'id'=>''.$obj->id.'']) ?>
             <div class="clear" style="margin: 10px;"></div> 
             <hr>

             <?php }  ?>
            

    
    <div class="clear"></div> 
    </th></table>
    
    
        <table class="table" border="2">
  <th>
        <h4 class="preinspection-box-title">Upload Photos</h4>

        <?php if($role == 'Superadmin' || $role == 'Admin' || $role == 'BO User') { ?>
     
     <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">

        <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
            echo '<div class="form-prerow-image">';
          
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-preinspection/image-uploadbrowse']),
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
                        'overwriteInitial'=>true,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-preinspection/remove-photobrowse']),
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
    <?php } ?>

   
    
    
    
     </th></table>
   
     </th></table>
    <div class="clear"></div>
      <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> 
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/commercialpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) { echo Html::a('Download Photos', ['/axion-preinspection/downloadphotos?id='.$premodel->id], [
    'class'=>'btn',  
    'data-toggle'=>'tooltip', 
    'title'=>'Download Photos'
        ]); }?>
        <?php if($role != 'Customer' && $role != '') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- axion-preinspection-commercialqc -->

<?php $this->registerJs(
"$('.remove-image').on('click', function(){
    var id = $(this).attr('id');
    //alert('#photo-'+id);
    //return false; 
 $.post(
        '".Yii::$app->request->baseUrl."/axion-preinspection/remove-photo', 
        {
            id : id,
        },
        function (data) {
           // alert(data);
          $('#'+data).attr('src','');
        }
    );
    return false;
});
   
     
    "
);
  
  

   
   
   $style = <<< CSS

   
   
#camera, #cameraview, #camerasensor, #cameraoutput{
    
    position: fixed;
    height: 100%;
    width: 95%;
    object-fit: cover;

}

#cameratrigger{
    width: 100px;
    background-color: black;
    color: white;
    font-size: 16px;
    border-radius: 30px;
    border: none;
    padding: 15px 20px;
    text-align: center;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    position: fixed;
    bottom: 30px;
    left: calc(25% - 50px);
}


#cameraupload{
    width: 100px;
    background-color: black;
    color: white;
    font-size: 16px;
    border-radius: 30px;
    border: none;
    padding: 15px 20px;
    text-align: center;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    position: fixed;
    bottom: 30px;
    right: calc(25% - 50px);
}


.taken{
    height: 100px!important;
    width: 100px!important;
    transition: all 0.5s ease-in;
    border: solid 3px white;
    box-shadow: 0 5px 10px 0 rgba(0,0,0,0.2);
    top: 20px;
    right: 20px;
    z-index: 2;
}
CSS;
 $this->registerCss($style);
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
        '$appUrl/axion-preinspection/assign-location', 
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





<?php

$url = YII::$app->request->baseUrl.'/axion-preinspection/image-upload';
 
$script = <<< JS
$('.cm-chassisThumb').on('click', function() {
  $('#photoType').val('chassisThumb');
  loadPopup();
})

$('.cm-frontViewNumberPlate').on('click', function() {
  $('#photoType').val('frontViewNumberPlate');
  loadPopup();
})

$('.cm-rearViewImage').on('click', function() {
  $('#photoType').val('rearViewImage');
  loadPopup();
})

$('.cm-frontBumper').on('click', function() {
  $('#photoType').val('frontBumper');
  loadPopup();
})

$('.cm-rearBumper').on('click', function() {
  $('#photoType').val('rearBumper');
  loadPopup();
})

$('.cm-frontLeftCorner45').on('click', function() {
  $('#photoType').val('frontLeftCorner45');
  loadPopup();
})

$('.cm-frontRightCorner45').on('click', function() {
  $('#photoType').val('frontRightCorner45');
  loadPopup();
})

$('.cm-leftSideFullView').on('click', function() {
  $('#photoType').val('leftSideFullView');
  loadPopup();
})

$('.cm-rightSideFullView').on('click', function() {
  $('#photoType').val('rightSideFullView');
  loadPopup();
})

$('.cm-leftQtrPanel').on('click', function() {
  $('#photoType').val('leftQtrPanel');
  loadPopup();
})

$('.cm-rightQtrPanel').on('click', function() {
  $('#photoType').val('rightQtrPanel');
  loadPopup();
})


$('.cm-enginePhoto').on('click', function() {
  $('#photoType').val('enginePhoto');
  loadPopup();
})


$('.cm-chassisPlate').on('click', function() {
  $('#photoType').val('chassisPlate');
  loadPopup();
})


$('.cm-dickyOpenImage').on('click', function() {
  $('#photoType').val('dickyOpenImage');
  loadPopup();
})


$('.cm-underChassis').on('click', function() {
  $('#photoType').val('underChassis');
  loadPopup();
})


$('.cm-dashBoardPhoto').on('click', function() {
  $('#photoType').val('dashBoardPhoto');
  loadPopup();
})


$('.cm-odometerReading').on('click', function() {
  $('#photoType').val('odometerReading');
  loadPopup();
})



$('.cm-cngLpgKit').on('click', function() {
  $('#photoType').val('cngLpgKit');
  loadPopup();
})


$('.cm-rcCopy').on('click', function() {
  $('#photoType').val('rcCopy');
  loadPopup();
})


$('.cm-preInsuranceCopy').on('click', function() {
  $('#photoType').val('preInsuranceCopy');
  loadPopup();
})


$('.cm-dentsScratchImage1').on('click', function() {
  $('#photoType').val('dentsScratchImage1');
  loadPopup();
})

$('.cm-dentsScratchImage2').on('click', function() {
  $('#photoType').val('dentsScratchImage2');
  loadPopup();
})

$('.cm-dentsScratchImage3').on('click', function() {
  $('#photoType').val('dentsScratchImage3');
  loadPopup();
})


function loadPopup(){
 
    $('#modal-camera').modal('show');
  cameraStart();
  
}


var constraints = { video: { facingMode: "environment" }, audio: false };
        
        // Define constants
        const cameraView = document.querySelector("#cameraview"),
              cameraOutput = document.querySelector("#cameraoutput"),
              cameraSensor = document.querySelector("#camerasensor"),
              cameraTrigger = document.querySelector("#cameratrigger"),
              cameraUpload = document.querySelector("#cameraupload")
        
       
        function cameraStart() {
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(function(stream) {
                track = stream.getTracks()[0];
                cameraView.srcObject = stream;
            })
            .catch(function(error) {
                console.error("Oops. Something is broken.", error);
            });
        }
        
      
        cameraTrigger.onclick = function() {
      
            cameraSensor.width = cameraView.videoWidth;
            cameraSensor.height = cameraView.videoHeight;
            cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
            cameraOutput.src = cameraSensor.toDataURL("image/jpeg");
            cameraOutput.classList.add("taken");
          };
          
              $(document).ready(function(){
              $('#cameratrigger').click(function() {
              $('#cameraupload').toggle("slide");
                });
            });
            
            
              cameraUpload.onclick = function(camerasensor) {
                return new Promise(function(resolve, reject) {
                   cameraOutput.src = cameraSensor.toDataURL("image/jpeg", 1.0);
                    var fullQuality = cameraOutput.src;
                    //console.log(fullQuality);
                    cameraOutput.classList.add("taken");
                     var base64image = $('#cameraoutput').attr('src');
                     //alert(base64image);return false;
                    // AJAX request
           // var formValue = $(this).serialize();
           var urlParams = new URLSearchParams(window.location.search);
           var id = urlParams.get('id');
           var type = $('#photoType').val();
           //alert(type);
       
                     $.ajax({
                        // url: 'https://axionpcs.in/test/qcphotos/storeImage.php',
                        url: '$url',
                        type: 'post',
                      data: {base64image: base64image,id:id,type:type},
                        success: function(data){
                           $('.modal').modal('hide');
                        //alert(data);
                        $("#"+type).attr("src",data);  
                     //console.log('Upload successfully');
                          //alert('Upload success');
                           location.reload();
                        }
                     });
                })
            }
        
        //  $(this).hide();
       // window.addEventListener("load", cameraStart, false);



 $(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="Assessment' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="mail' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="phone' + counter + '"/></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});



function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}
           

JS;
$this->registerJS($script);
?>

<?php                 

        Modal::begin([
           'header' => '<main id="camera">',
               
            'id' => 'modal-camera',
            'size' => 'modal-md',
            
        ]);
        
        echo   "<div>
                  
                  <img alt='' src='//:0' id='cameraoutput'>
                    
                </div>"; 
        
        echo "<div class='modal-dialog'>
                     <canvas id='camerasensor'></canvas>
                     <video id='cameraview' autoplay playsinline></video></main>
                    <br><br><br><br><br><br><br><br><br><br><br><br>
                     
               </div>";       
                     
        echo "<div class='modal-body'></div>";     
             
       
        
        echo "<div class='modal-footer'>
               <button id='cameratrigger'>Capture</button>
               <button id='cameraupload', style='display:none'>Upload</button>
              </div>";

 Modal::end();

    ?>
    
    
    
    
    
    
    
    
    

