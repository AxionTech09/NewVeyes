<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <h2 style="text-align: center">COMMERCIAL QC</h2>
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
                    'pluginOptions' => [
                        'autoclose' => true
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
    <?= $form->field($premodel, 'manufacturer') ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'model') ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturingYear') ?>
    </div>
    <?php if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false) { ?>
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'contactPersonMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Unique Lead Number') ?>
    </div>   
     <?php
    } ?>
    </div>
    <div class="clear"></div> 
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
          <? } ?>
            
         <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 
     </div>
    <div class="clear"></div>
        <?php if($premodel->surveyorName == 0) { ?>
    <h4 class="preinspection-box-title">Video Session</h4>
    <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px; text-align: center">

    <?php if($customerSession > 0) { 
        ?>
            <?= Html::a('Video Session', ['axion-preinspection/video-session', 'id' => $premodel->id], ['class' => 'btn btn-primary']) ?>
           <?php 
        } else{ ?>
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Create Customer Video Session', ['class' => 'btn btn-primary', 'value'=>'create_session', 'name'=>'create_session']) ?>
        </div>
   <?php  }   ?>
     </div>
    <?php  }   ?>
    <div class="clear"></div>
    <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
    <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
            echo '<div class="form-prerow-image">';
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                'options' => [ 'multiple' => false, 'accept' => 'image/*;capture=camera'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-preinspection/image-upload']),
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
                        //'resizePreference' => 'height',
                        'maxFileCount' => 1,
                        //'resizeImage' => true,
                        //'resizeIfSizeMoreThan' => 100,
                        'showRemove' => false,
                        'showUpload' => false,
                        'overwriteInitial'=>false,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-preinspection/remove-photo']),
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
      <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/commercialpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
]);} ?>
        <?php if($role != 'Customer') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
        <? } ?>
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
); ?>


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