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

?>
<div class="axion-preinspection-fourwheelerqc">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'options' => ['enctype' => 'multipart/form-data']]); ?>
    <h2 style="text-align: center">FOUR WHEELER QC</h2>
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
    <?php if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) { ?>
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
        <?= $form->field($model, 'stereoMake')->dropDownList(['COMPANY FITTING'=>'COMPANY FITTING']);?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'otherElectrical')->dropDownList(['COMPANY FITTING'=>'COMPANY FITTING']);?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'centerLock')->dropDownList($centreLockArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontBumper')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'grill')->dropDownList($damageType1Array) ?>
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
        <?= $form->field($model, 'tallLamp')->dropDownList($damageType1Array) ?>
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
        <?= $form->field($model, 'ltPillarDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltPillarCentre')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltPillarRear')->dropDownList($damageType1Array) ?>
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
        <?= $form->field($model, 'rtCenterPillar')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRearPillar')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRunningBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontFender')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearViewMirror')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyres')->dropDownList($damageType5Array) ?>
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
        <?= $form->field($model, 'backGlass')->dropDownList($damageType2Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontwsGlassLaminated')->dropDownList($damageType3Array) ?>
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

         
        <?php if($role != 'Customer') { ?>
        <div class="form-prerow-other">
            <?= $form->field($premodel, 'surveyorName')->dropDownList($valuatorData);?>
        </div> 
        <? } ?>
            
        <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 
     </div>
    <div class="clear"></div>
    
    <?php if($premodel->surveyorName == 0 ) { ?>
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
        
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/fourwheelerpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
        ]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) { echo Html::a('Download Photos', ['/axion-preinspection/downloadphotos?id='.$premodel->id], [
    'class'=>'btn btn-primary',  
    'data-toggle'=>'tooltip', 
    'title'=>'Download Photos'
        ]); }?>
        <?php if($role != 'Customer' && $role != '') { ?>
         <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
        <? } ?>
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

