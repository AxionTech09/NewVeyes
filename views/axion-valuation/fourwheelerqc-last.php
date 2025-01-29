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
/* @var $model app\models\AxionPreinspectionFourwheeler */
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
if($role == 'Valuator')
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
if($role == 'Valuator')
{
    $generalList =[
              ['id' => '1', 'name' => 'Average'],
              ['id' => '3', 'name' => 'Excellent'],
              ['id' => '2', 'name' => 'Good'],
              ['id' => '-1', 'name' => 'Bad'],
              ['id' => '-2', 'name' => 'VeryBad'],
              ['id' => '-3', 'name' => 'NA'],
    ];
    $generalArray = ArrayHelper::map($generalList = 'id','name');
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

$makeList =ArrayHelper::map($make_name,'id','make_name');

$modelList = ArrayHelper::map($model_name,'id','model_name');
  
$variantList = ArrayHelper::map($variant_name,'id','variant_name');


?>

<div class="axion-preinspection-fourwheelerqc">

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
    <?= $form->field($premodel, 'clientName')->dropDownList($companyList,['id'=>'companyId']); ?>
    </div>
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'actualCashCollected')->textInput(['readonly' => true,'maxlength' => true]) ?>
    </div> 
    
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'customerAddress') ?>
    </div> 
        
    <div class="form-prerow-other">     
    <?= $form->field($premodel, 'executiveEmailId') ?>
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
    <?= $form->field($premodel, 'executiveName')->dropDownList($callerList,['id'=>'callerId']) ?>
    </div>    

    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'executiveMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive Mobile No') ?>
    </div>
    
    <div class="form-prerow-other" >
    <?= $form->field($premodel, 'executiveEmailId')->textInput(['readonly' =>true,'maxlength' => true])->label('Executive
 Email Id') ?>
    </div>    

    
    
<div class="form-prerow-other">    

    <?= $form->field($premodel, 'registrationYear')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
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
    <?= $form->field($premodel, 'make')
    ->dropDownList($makeList); 
    ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'model')
     ->dropDownList($modelList);
     ?>
    </div>
     <div class="form-prerow-other" >
    <?= $form->field($premodel, 'variant')
     ->dropDownList($variantList);
     ?> 
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'exShowroomPrice')->hiddenInput()->label(false); ?>
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
    } ?>
    </th>
</table>
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
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]) ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'taxValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]) ?>
         </div>

         <div class="form-prerow-other">
        <?= $form->field($model, 'fcValidity')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
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
            <?= $form->field($premodel, 'systemGeneratedMarketValue')->textInput(['readonly' =>true,'maxlength' => true]); ?>
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
            <?= $form->field($premodel, 'valuatorName')->dropDownList($valuatorData);?>
        </div> 
        <?php } ?>
            
        <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 

    </th></table>
     </div>
    <div class="clear"></div>
    
    <?php if($premodel->valuatorName == 0 ) { ?>
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
            <?php  }
            
            }   ?>
     </div>
    <?php  }   ?>
</th></table>
    <div class="clear"></div>



    <h4 class="preinspection-box-title">Camera Photos</h4>
    Chassis Thumb
    <?php
$script = <<< JS
var constraints = { video: { facingMode: 'environment' }, audio: false };
        
        // Define constants
        const cameraView = document.querySelector('#cameraview'),
              cameraOutput = document.querySelector('#cameraoutput'),
              cameraSensor = document.querySelector('#camerasensor'),
              cameraTrigger = document.querySelector('#cameratrigger'),
              cameraUpload = document.querySelector('#cameraupload')
        
       
        function cameraStart() {alert('hl');
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(function(stream) {
                track = stream.getTracks()[0];
                cameraView.srcObject = stream;
            })
            .catch(function(error) {
                console.error('Oops. Something is broken.', error);
            });
        }
        
      
        cameraTrigger.onclick = function() {alert('hl');
        
            cameraSensor.width = cameraView.videoWidth;
            cameraSensor.height = cameraView.videoHeight;
            cameraSensor.getContext('2d').drawImage(cameraView, 0, 0);
            cameraOutput.src = cameraSensor.toDataURL('image/jpg');
            cameraOutput.classList.add('taken');
          };
            
              cameraupload.onclick = function(camerasensor) {alert('hl');
                return new Promise(function(resolve, reject) {
                   cameraOutput.src = cameraSensor.toDataURL('image/jpg', 1.0);
                    var fullQuality = cameraOutput.src;
                    //console.log(fullQuality);
                    cameraOutput.classList.add('taken');
                     var base64image = $('#cameraoutput').attr('src');
                     //alert(base64image);return false;
                    // AJAX request
           // var formValue = $(this).serialize();
           var urlParams = new URLSearchParams(window.location.search);
           var id = urlParams.get('id');
                   
                     $.ajax({
                        url: 'https://axionpcs.in/test/qcphotos/storeImage.php',
                        type: 'post',
                      data: {base64image: base64image,id:id},
                        success: function(data){
                             if (data.redirect) {
                    window.location.href = 'https://axionpcs.in/camera/final/index2.php';
                }
                     console.log('Upload successfully');
                          alert('Upload success');
                           window.history.back();
                        }
                     });
                })
            }
        
        //  $(this).hide();
        window.addEventListener('load', cameraStart, false);  


$('.cameratrigger').on('click', function(e) {
  
  imgData = cameraoutput.getImgData();
 
  var img = "<img style='width: 100%' src='data:image/png;base64," + imgData + "'></img>";
  $('.cameraoutput').html(img);
  $('#modal').modal('show');
  .load($(this).attr('value'));
})


});

JS;
$this->registerJs($script);
?>


    <?php                 

        Modal::begin([

                'header' => 'view',

                'id' => 'modal',

                'size' => 'modal-md',

            ]);

        echo "<div id='cameraoutput'></div>";

        Modal::end();

    ?>

<?= Html::button('Upload', [                        

     'value' => Yii::$app->urlManager->createUrl('/upload'),

     'class' => 'btn btn-primary',

     'id' => 'cameraUpload',

     'data-toggle'=> 'modal',

     'data-target'=> '#modal',

]) ?>


<main id="camera">
            <canvas id="camerasensor"></canvas>
            <video id="cameraview" autoplay playsinline></video>
            <img alt="" src="//:0" id="cameraoutput">
            <button id="cameratrigger">Capture</button>
            <button id="cameraupload">Upload</button>
            
    </main>


     <div class="clear"></div>
    <!--  -->
 </th></table>
</th></table>
    <div class="clear"></div>
    <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
        <!-- echo "save"; -->
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->
        
        <?php 
        // echo $premodel->status;
        if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200 )
            // || $premodel->status == 200 
        {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/fourwheelerpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
        ]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104 || $premodel->status == 200 ) { echo Html::a('Download Photos', ['/axion-preinspection/downloadphotos?id='.$premodel->id], [
    'class'=>'btn btn-primary',  
    'data-toggle'=>'tooltip', 
    'title'=>'Download Photos'
        ]); }?>
        <?php if($role != 'Customer' && $role != '') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
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
        '".Yii::$app->request->baseUrl."/axion-preinspection/remove-photo', 
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


$style = <<< CSS
#camera, #cameraview, #camerasensor, #cameraoutput{
    position: fixed;
    height: 20%;
    width: 20%;
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

<?php $this->registerJs(
    "$('body').on('click', '#activity-create-link', function() {
    $.get(
        '".Yii::$app->request->baseUrl."/axion-preinspection/create',
        {
            /*id: $(this).closest('tr').data('key')*/
        },
        function (data) {
            //alert(data);
            $('#create-modal').find('.modal-body').html(data);
            $('#create-modal').modal();
        }
    );
});
$('#create-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})


$(function(){
  $(document).on('click', '.showModalButton', function(){

    if ($('#modal').hasClass('in')) {
        $('#modal').find('#modalContent')
                .load($(this).attr('value'));
        document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
    } else {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
    }
});






    "
); ?>





<!-- <section id="contact" class="padd-section wow fadeInUp">

    <div class="container">
      <div class="row justify-content-center">

        <div class="col-lg-3 col-md-4">

          

        </div>

        <div class="col-lg-5 col-md-8">
          <div class="form">
    <form action="" method="post" role="form" class="contactForm">
              <div class="form-group">
        <input type="text" name="name" class="form-control">
                
              </div>
              <div class="form-group">
    <input type="email" class="form-control" name="email" >
                
              </div>
              <div class="form-group">
     <input type="text" class="form-control" name="subject">
                
              </div>
              <div class="form-group">
    <textarea class="form-control" name="message" rows="5" >
        
    </textarea>
                
              </div>
    <div class="text-center">
        <button type="submit">Send Message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> -->
