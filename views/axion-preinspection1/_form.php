<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

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


$paymentArray = $model->paymentValue;
$inspectionTypeArray = $model->inspectionTypevalue;

if($lastStatus == 1 || $lastStatus == 12)
{
    $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '1', 'name' => 'Intimation Re-Schedule'],
      ['id' => '8', 'name' => 'Survey Done'],
      ['id' => '9', 'name' => 'Cancelled'],
      ['id' => '100', 'name' => 'Change RO'],  
    ];
}
else if($lastStatus == 9)
{
    $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '12', 'name' => 'Scheduled'],
      ['id' => '1', 'name' => 'Intimation Re-Schedule'],
      ['id' => '9', 'name' => 'Cancelled'],
      ['id' => '100', 'name' => 'Change RO'],  
    ];
}
 else {    
     $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '12', 'name' => 'Scheduled'],
      ['id' => '8', 'name' => 'Survey Done'],
      ['id' => '9', 'name' => 'Cancelled'],
      ['id' => '100', 'name' => 'Change RO'],   
    ];  
}

if($role == 'Surveyor')
{
  $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '8', 'name' => 'Survey Done'], 
    ];  
}

$statusArray = ArrayHelper::map($statusList, 'id', 'name');


$cancelReasonArray = $model->cancelReasonsvalue;


$vehicleTypeRadioList= [
  ['id' => '', 'name' => 'SELECT'],
  ['id' => 'PVT', 'name' => 'PVT'],
  ['id' => 'TAXI', 'name' => 'TAXI'],
];
$vehicleTypeRadioArray = ArrayHelper::map($vehicleTypeRadioList, 'id', 'name');

$vehicleTypeList= [
  ['id' => '4-WHEELER', 'name' => '4-WHEELER'],
  ['id' => 'COMMERCIAL', 'name' => 'COMMERCIAL'],
];
$vehicleTypeArray = ArrayHelper::map($vehicleTypeList, 'id', 'name');


$followupReasonArray = $model->followupValue;

$id = '';
if(isset($_GET['id']))
{
    $id = $_GET['id']; 
}

$height = '';
if($role == 'Admin' || $role == 'Superadmin' || $role == 'BO User')
{
    if($lastStatus == 0 && !$model->isNewRecord){
        //$height = '1200px';
        $followupDisplay = "block";
    }
    else
    {
        $followupDisplay = "none";
        //$height = '1000px';
    }
    $inspectionDisplay = "block";
}
 else {
    $height = '';
    $followupDisplay = "none"; 
    $inspectionDisplay = "none";
}

/*
if($lastStatus == 0 && !$model->isNewRecord){
    $height = '1200px';
    $followupDisplay = "block";
}
else if($callerModel)
{
   $height = '1075px';
   $followupDisplay = "none";
}
else {
   $height = '1000px';
   $followupDisplay = "none";
}
 * 
 */



//checking followup status and blocking save feature if there is pending followups
if($block == 'Y' && $sameId == 'N')
{
    echo "<div style='color:red;font-weight:bold;font-size:20px;margin-bottom:6px;'>Cannot save this reference no! Please complete the pending followup remainders.</div>";
    $followUpCheckSave = 'N';
}
else {
    $followUpCheckSave = 'Y';
}

$cityList =ArrayHelper::map($city,'id','city');
if(isset($town))
{
    $townList = ArrayHelper::map($town,'id','town');
}
else {
    $townList = [''=>'Select'];
}

$companyList =ArrayHelper::map($company,'id','companyName');
if(isset($division))
{
    $divisionList = ArrayHelper::map($division,'id','divisionName');
}
else {
    $divisionList = [''=>'Select'];
}
if(isset($branch))
{
    $branchList = ArrayHelper::map($branch,'id','branchName');
}
else {
    $branchList = [''=>'Select'];
}

if(isset($caller))
{
    $callerList = ArrayHelper::map($caller,'id','firstName');
}
else {
    $callerList = [''=>'Select'];
}

//$model->insurerName = Yii::$app->user->identity->companyId;
//$model->insurerDivision = Yii::$app->user->identity->divisionId;
//$model->insurerBranch = Yii::$app->user->identity->branchId;
if($model->isNewRecord && ($role == 'Branch Head' || $role == 'Branch Executive'))
{
    $model->callerMobileNo = Yii::$app->user->identity->mobile;
    $model->callerDetails = Yii::$app->user->identity->email;
}
?>

<div class="preinspection-form" style="height:<?php echo $height;?>;">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),
            'enableAjaxValidation'=>true,'validationUrl' => ['axion-preinspection/validation','id' =>$id],]); ?>
    
    <h4 class="preinspection-box-title">Company Details</h4>
    <div id="company_details" class="preinspection-box">
   
    <div class="form-prerow1">
    <?= $form->field($model, 'referenceNo')->textInput(['readonly' =>true]) ?>
    </div>
    
    <div class="form-prerow-other">
 
    <?php 
    if($role == 'Branch Head' || $role == 'Branch Executive')
    {
        echo $form->field($model, 'insurerName')->dropDownList($companyList,['id'=>'companyId']);
    }
    else {
        echo $form->field($model, 'insurerName')->dropDownList($companyList,['prompt'=>'Select','id'=>'companyId','onchange'=>'
             $.post( "'.Yii::$app->urlManager->createUrl('user-data/divisionlist?id=').'"+$(this).val(), function( data ) {             
$( "select#divisionId" ).html( data );
               $( "select#branchId" ).html("<option value=\'\'>Select</option>");
               $( "select#callerId" ).html("<option value=\'\'>Select</option>");
               $( "#callerMobileNo" ).val("");
               $( "#callerDetails" ).val("");
             });
         ']);
    }

    ?> 
        
    </div>

    <div class="form-prerow-other">

    <?php 
    if($role == 'Branch Head' || $role == 'Branch Executive')
    {
        echo $form->field($model, 'insurerDivision')->dropDownList($divisionList,['id'=>'divisionId']);
    }
    else {
        echo $form->field($model, 'insurerDivision')->dropDownList($divisionList,['id'=>'divisionId','onchange'=>'
               $.get("'.Yii::$app->urlManager->createUrl('user-data/branchlist').'",{id:$(this).val(),cid:$("#companyId").val()}, 
                function( data ) {
                $( "select#branchId" ).html( data );
                $( "select#callerId" ).html("<option value=\'\'>Select</option>");
                $( "#callerMobileNo" ).val("");
                $( "#callerDetails" ).val("");
                });
            ']);
    }
    ?>
    </div>
        
     <div class="form-prerow-other">
    <?php 
    if($role == 'Branch Head' || $role == 'Branch Executive')
    {
        echo $form->field($model, 'insurerBranch')->dropDownList($branchList,['id'=>'branchId']);
    }
    else {
    
    echo $form->field($model, 'insurerBranch')->dropDownList($branchList,['id'=>'branchId','onchange'=>'
               $.get("'.Yii::$app->urlManager->createUrl('user-data/callerlist').'",{companyId:$("#companyId").val(),divisionId:$("#divisionId").val(),branchId:$(this).val()}, 
                function( data ) {
                $( "select#callerId" ).html( data );
                $( "#callerMobileNo" ).val("");
                $( "#callerDetails" ).val("");
                });
            ']);
    }
    ?>
    </div>   
    
    <div class="clear"></div>

    <div class="form-prerow1">
    
    <?php 
        if(!$model->isNewRecord)
        {
            echo $form->field($model, 'intimationDate')->textInput(['readonly' =>true,'maxlength' => true,'value' => $model->intimationDate?date( 'd/m/Y h:i A', strtotime( $model->intimationDate )):'']); 
            
        }
        else
        {
           echo $form->field($model, 'intimationDate')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
        }
    ?>    
        
        
    </div>    

    <div class="form-prerow-other">

    <?php 
    if($role == 'Branch Head' || $role == 'Branch Executive')
    {
        echo $form->field($model, 'callerName')->dropDownList($callerList,['id'=>'callerId']);
    }
    else {
    echo $form->field($model, 'callerName')->dropDownList($callerList,['id'=>'callerId','onchange'=>'
           $.get("'.Yii::$app->urlManager->createUrl('user-data/callerdetails').'",{callerId:$(this).val()}, 
            function( data ) {
            var arr = data.split("|&|");
            $("#callerMobileNo" ).val( arr[0] );
            $("#callerDetails" ).val( arr[1] );
            });
        ']);
    }
            ?>
    </div>
    
    
    <div class="form-prerow-other">
    <?= $form->field($model, 'callerMobileNo')->textInput(['id'=>'callerMobileNo','readonly' =>true,'maxlength' => true]) ?>
    </div>
        
    <div class="form-prerow-other">
    <?= $form->field($model, 'callerDetails')->textInput(['id'=>'callerDetails','readonly' =>true,'maxlength' => true]) ?>
    </div>
    
    <div class="clear"></div>
    
    <?php
    if($callerModel)
    {
    ?>
     <div class="form-prerow1" style="width:250px;">
    <?= $form->field($callerModel, 'callerName')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Name') ?>
    </div>    

    <div class="form-prerow-other" style="width:180px;">
    <?= $form->field($callerModel, 'callerMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Mobile No') ?>
    </div>
    
    <div class="form-prerow-other" style="width:270px;">
    <?= $form->field($callerModel, 'callerEmailId')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Email Id') ?>
    </div>
    
    <div class="clear"></div>
    
    <?php
    }
    ?>
    
    </div>
    <hr class="preinspection-box-hr">
    
    <h4 class="preinspection-box-title">Customer Details</h4>
    <div id="customer_details" class="preinspection-box">

    <div class="form-prerow1">
    <?= $form->field($model, 'insuredName')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($model, 'insuredMobile')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
    </div>    

    <div class="form-prerow-other">
     <?php if(strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false ) { 
       echo $form->field($model, 'contactPersonMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Unique Lead Number');  
     } else { 
    echo $form->field($model, 'contactPersonMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]);
    } ?>
    </div>    

    <div class="form-prerow-other">
    <?= $form->field($model, 'insuredAddress')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
    </div>
    
    <div class="clear"></div>
    
    </div>
    <hr class="preinspection-box-hr">  
    <h4 class="preinspection-box-title">Vehicle Details</h4>
    <div id="vehicle_details" class="preinspection-box">

    <div class="alert alert-danger" id="registrationNoWarning" style="display:none;">
        <strong>Warning!</strong> This Registration Number already exist for the current month.
    </div>


    <div class="form-prerow-other">

    <?php 
   
    echo $form->field($model, 'registrationNo')->textInput(['onchange'=>'
           $.get("'.Yii::$app->urlManager->createUrl('axion-preinspection/vehicle-check').'",{regno:$(this).val()}, 
            function( data ) {
                
                if(data == 1){
                    $("#registrationNoWarning").show();
                }
                else{
                    $("#registrationNoWarning").hide();
                }
            
            //$("#callerMobileNo" ).val( arr[0] );
          
            });
        ']);
    
            ?>
    </div>

      

    <div class="form-prerow-other">
    <?= $form->field($model, 'engineNo')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($model, 'chassisNo')->textInput(['maxlength' => true]) ?>
    </div>
        
    <div class="form-prerow-other" style="width:140px;">
        <?php
        if($model->isNewRecord)
        {
          echo $form->field($model, 'vehicleType')->dropDownList($vehicleTypeArray);
        }
        else {
          echo $form->field($model, 'vehicleType')->textInput(['readonly' =>true,'maxlength' => true]);
        }
    ?>  
    </div> 
        
    <div class="form-prerow-other" style="width:100px;margin-left:5px">
    <?= $form->field($model, 'vehicleTypeRadio')->dropDownList($vehicleTypeRadioArray) ?>
    </div>    
    
    <div class="clear"></div>
       
    <div class="form-prerow1">
    <?= $form->field($model, 'manufacturer')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($model, 'model')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($model, 'manufacturingYear')->textInput(['readonly' =>$model->isNewRecord?false:true]) ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($model, 'intimationRemarks')->textInput(['readonly' =>($model->isNewRecord || $role == 'Superadmin' || $role == 'Admin')?false:true,'maxlength' => true]) ?>
    </div>
    
    <div class="clear"></div>
    
    </div>
    <hr class="preinspection-box-hr" style="display: <?php echo $inspectionDisplay; ?>">
    
    <h4 class="preinspection-box-title" style="display: <?php echo $inspectionDisplay; ?>">Inspections Details</h4>
    <div id="inspection_details" class="preinspection-box" style="display: <?php echo $inspectionDisplay; ?>"> 
    
    <div class="form-prerow1" style="width:305px;">     
     <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select','style'=>'width:300px','id'=>'cityId','onchange'=>'
            $.post( "'.Yii::$app->urlManager->createUrl('axion-preinspection/townlist?id=').'"+$(this).val(), function( data ) {
              var output = data.split("|&|");
              $( "select#townId" ).html( output[0] );
              $( "select#axionpreinspection-surveyorname" ).html( output[1] );
              $( "input#axionpreinspection-extrakm" ).val(\'\');
            });
        ']);?>
    </div>
        
    <div class="form-prerow-other">
     <?= $form->field($model, 'townId')->dropDownList($townList,['style'=>'width:300px','id'=>'townId','onchange'=>'
               $.get("'.Yii::$app->urlManager->createUrl('axion-preinspection/kmsvalue').'",{id:$(this).val(),cid:$("#cityId").val()}, 
                function( data ) {
                $( "input#axionpreinspection-extrakm" ).val( data );
                });
            ']) ?>
    </div>    
      
    <div class="clear"></div>    
        
    <div class="form-prerow1" style="width:100px;">     
    <?= $form->field($model, 'extraKM')->textInput() ?>
    </div>    

    <div class="form-prerow-other">
    <?= $form->field($model, 'surveyLocation')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-prerow-other">
    <?= $form->field($model, 'surveyorName')->dropDownList($valuatorData,['prompt'=>'All','onchange'=>'
            $.post( "'.Yii::$app->urlManager->createUrl('axion-preinspection/surveyorall?id=').'"+$(this).val(), function( data ) {
              if(data != "noload")
              {
                $( "select#axionpreinspection-surveyorname" ).html( data );
              }
            });
        ']);?>
    </div>
        
    <div class="form-prerow-other">  
        <?= $form->field($model, 'surveyorAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $model->surveyorAppointDateTime?date( 'd/m/Y h:i A', strtotime( $model->surveyorAppointDateTime )):'']) ?>
    </div>   
     
    <div class="form-prerow-other" style="width:100px;">    
    <?= $form->field($model, 'sendLink')->textInput(['readonly' => true,'maxlength' => true]) ?> 
    </div>    
    
    <div class="clear"></div>
    
    
 
    <div class="form-prerow1" style="width:130px;">
     <?= $form->field($model, 'inspectionType')->dropDownList($inspectionTypeArray) ?> 
    </div>
    
    <?php
        //reschedule
        if(!$model->isNewRecord && ($model->paymentMode == 2 || $model->paymentMode == 3))
        {
          $cashCollectionDisplay = "Block";
        }
        else {
            $cashCollectionDisplay = "None";
        }
    ?>    
    <div class="form-prerow-other">  
    <?= $form->field($model, 'paymentMode')->dropDownList($paymentArray,['id' => 'paymentMode'
    ]) ?>
    </div>  
    
    <div class="form-prerow-other" style="display: <?php echo $cashCollectionDisplay; ?>; width:150px;" id="cashCollectionDiv">
    <?= $form->field($model, 'cashCollection')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="form-prerow-other">  
    <?php
    if(!$model->isNewRecord && ($lastStatus == 8))
    {
        echo $form->field($model, 'status')->dropDownList($statusArray,['disabled' =>true,'maxlength' => true]);

    }
    else
    {
        echo $form->field($model, 'status')->dropDownList($statusArray);
    }
    ?>       
    </div>
    
    <div class="form-prerow-other" style="width:100px;" >
    
    <div class="form-group">
<label class="control-label" >Status SMS</label>
   <?= Html::dropDownList('sendSms', null,['Y'=>'Y','N'=>'N'], [
            'class' => 'form-control'
        ]) ?>
<div class="help-block"></div>
</div>
     </div>
    
   <div class="clear"></div>
    
    <div class="form-prerow1" style="width:250px;">
    <?php 
        if((!$model->isNewRecord && $lastStatus == 0) || $model->isNewRecord)
        {
            echo $form->field($model, 'customerAppointDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);
        }
        else
        {
            echo $form->field($model, 'customerAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $model->customerAppointDateTime?date( 'd/m/Y h:i A', strtotime( $model->customerAppointDateTime )):'']); 
        }
    ?>
    </div>    
    <?php
    //reschedule
    if(!$model->isNewRecord && $lastStatus == 1)
    {
      $rescheduleDisplay = "Block";
    }
    else {
       $rescheduleDisplay = "None"; 
    }
    $reschedule1Display = "None";
    
    //cancellation
    if(!$model->isNewRecord && $lastStatus == 9)
    {
      $cancellationReasonDisplay = "Block";
    }
    else {
       $cancellationReasonDisplay= "None"; 
    }
    //completed survey
    if(!$model->isNewRecord && $lastStatus == 8)
    {
      $completedSurveyDateTimeDisplay = "Block";
    }
    else {
       $completedSurveyDateTimeDisplay= "None"; 
    }
    ?>
    
    <div class="form-prerow-other" style="display: <?php echo $rescheduleDisplay; ?>;width:250px;" id="rescheduleReasonDiv">
        <?php
        if(!$model->isNewRecord && $lastStatus == 1)
        {
            echo $form->field($model, 'rescheduleReason')->textInput(['readonly' =>true,'maxlength' => true]); 
            
        }
        else
        {
            echo $form->field($model, 'rescheduleReason')->textInput(['maxlength' => true]);
        }
        ?>
    </div>
    
    <div class="form-prerow-other" style="display: <?php echo $rescheduleDisplay; ?>;width:250px;" id="rescheduleDateTimeDiv">
     <?php 
        if(!$model->isNewRecord && $lastStatus == 1)
        {
            echo $form->field($model, 'rescheduleDateTime')->textInput(['readonly' =>true,'maxlength' => true,'value' => $model->rescheduleDateTime?date( 'd/m/Y h:i A', strtotime( $model->rescheduleDateTime )):'']); 
            
        }
        else
        {
           echo $form->field($model, 'rescheduleDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
        }
     ?>   
    </div>
    
    <div class="form-prerow-other" style="display: <?php echo $reschedule1Display; ?>;width:250px;" id="reschedule1ReasonDiv">
        <?php

            echo $form->field($model, 'rescheduleReason1')->textInput(['maxlength' => true]);
        ?>
    </div>
    
    <div class="form-prerow-other" style="display: <?php echo $reschedule1Display; ?>;width:250px;" id="reschedule1DateTimeDiv">
     <?php 

           echo $form->field($model, 'rescheduleDateTime1')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
     ?>   
    </div>
          
    <div class="form-prerow-other" style="display: <?php echo $cancellationReasonDisplay; ?>;width:250px;" id="cancellationReasonDiv">
        <?php
        if(!$model->isNewRecord && $lastStatus == 9)
        {
            echo $form->field($model, 'cancellationReason')->dropDownList($cancelReasonArray,['disabled' =>true,'maxlength' => true]);
            
        }
        else
        {
            echo $form->field($model, 'cancellationReason')->dropDownList($cancelReasonArray);
        }
        ?>
    </div>
    
    <div class="form-prerow-other" style="display: <?php echo $completedSurveyDateTimeDisplay; ?>;width:250px;" id="completedSurveyDateTimeDiv">
    <?php 

        if(!$model->isNewRecord && $lastStatus == 8)
        {
            echo $form->field($model, 'completedSurveyDateTime')->textInput(['readonly' =>true,'maxlength' => true,'value' => $model->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $model->completedSurveyDateTime )):'']); 
            
        }
        else
        {
           echo $form->field($model, 'completedSurveyDateTime')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
        }

    ?>
    </div> 
    <?php
    if($lastStatus == 1)
    {
    ?>
        <div class="clear"></div>
        <div class="form-prerow1">     
        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
        </div>
        
    <?php
    }
    else {
     ?>
       <div class="form-prerow-other">     
        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
        </div>
    <?php    
    }
    ?>
                <div class="clear"></div>
    </div>
    
    
    <hr class="preinspection-box-hr">
    
    
    <div id="followup" style="display: <?php echo $followupDisplay; ?>">
        <h4 class="preinspection-box-title">Follow Up</h4>
        <div class="preinspection-box">
            <div class="form-row1">
                <?= $form->field($model, 'followupReason')->dropDownList($followupReasonArray); ?>
            </div>
           <div class="form-row-other">
                <?= $form->field($model, 'followupRemainder')->widget(DateControl::classname(), [
               'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                       'pluginOptions' => [
                           'autoclose' => true
                               ]
                           ]
                   ]) ?>
            </div>
           <div class="form-row-other">
                <?= $form->field($model, 'followupUpdatedDateTime')->textInput(['readonly' =>true,'maxlength' => true,'value' => $model->followupUpdatedDateTime?date( 'd/m/Y h:i A', strtotime( $model->followupUpdatedDateTime )):'']) ?>
            </div>
           <div class="clear"></div>
           <div class="form-row1">
                <?= $form->field($model, 'followupUpdatedBy')->textInput(['maxlength' => true]) ?>
            </div>
           <div class="clear"></div>

              <hr class="preinspection-box-hr"> 
        </div>
    </div>

    <br>
    <?php  echo Html::hiddenInput('name', $id, ['id' => 'process_hid_id']); ?>
    
    <?php  echo Html::hiddenInput('name', $lastStatus, ['id' => 'lastStatus']); ?>
    
    <?php  echo Html::hiddenInput('name', $model->isNewRecord?"Y":"N", ['id' => 'newRecord']); ?>

    <?php
    if($lastStatus != 9 && $lastStatus != 101 && $lastStatus != 102 && $lastStatus != 103 && $lastStatus != 104 && $followUpCheckSave == 'Y')
    {
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div id="ajaxLoad">
        <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
    </div>
    <?php
    }
    ?>

    <?php ActiveForm::end(); ?>
    <?php $this->registerJs(
      "$('#paymentMode').change(function () {
         var selected = $('#paymentMode').find('option:selected').val();
         if(selected == 2 || selected == 3 )
         {
            $('#cashCollectionDiv').show(); 
         }
         else
         {
            $('#cashCollectionDiv').hide();  
         }
         return false;
      });
      $('#axionpreinspection-status').change(function () {
         var selected = $('#axionpreinspection-status').find('option:selected').val();
         var lastStatus = $('#lastStatus').val();        
         //alert(selected);
         
         if(lastStatus == 12 && selected == 1 )
         {
            $('#rescheduleReasonDiv').show();
            $('#rescheduleDateTimeDiv').show();
            $('#cancellationReasonDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
         }
         else if(lastStatus == 1 && selected == 1)
         {
            $('#reschedule1ReasonDiv').show();
            $('#reschedule1DateTimeDiv').show();
            $('#cancellationReasonDiv').hide();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
         }
         else if(selected == 12 )
         {
            $('#cancellationReasonDiv').hide();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(selected == 9 )
         {
            $('#cancellationReasonDiv').show();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(selected == 8 )
         {
            $('#completedSurveyDateTimeDiv').show();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#cancellationReasonDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(lastStatus == 12 && selected == '0')
         {
            $('#cancellationReasonDiv').hide();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(lastStatus == 1 && selected == '0')
         {
            $('#cancellationReasonDiv').hide();
            $('#rescheduleReasonDiv').show();
            $('#rescheduleDateTimeDiv').show();
            $('#completedSurveyDateTimeDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(lastStatus == 9 && selected == '0')
         {
            $('#cancellationReasonDiv').show();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').hide();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         else if(lastStatus == 8 && selected == '0')
         {
            $('#cancellationReasonDiv').hide();
            $('#rescheduleReasonDiv').hide();
            $('#rescheduleDateTimeDiv').hide();
            $('#completedSurveyDateTimeDiv').show();
            $('#reschedule1ReasonDiv').hide();
            $('#reschedule1DateTimeDiv').hide();
         }
         
         return false;
      });
      "
            
    ); ?>

</div>

<?php
$script = <<< JS
        
$('#AxionPreinspection').on('beforeSubmit', function(e) 
{
        var lastStatus = $('#lastStatus').val();
        var newRecord = $('#newRecord').val();
        var status = $('#axionpreinspection-status').find('option:selected').val();
        var remarks = $('#axionpreinspection-remarks').val();
        var vehicleType = $('#axionpreinspection-vehicletype').val();
        var vehicleTypeRadio = $('#axionpreinspection-vehicletyperadio').val();
        var extraKM = $('#axionpreinspection-extrakm').val();
        var surveyLocation = $('#axionpreinspection-surveylocation').val();
        var surveyorName = $('#axionpreinspection-surveyorname').find('option:selected').val();
        var customerAppointDateTime = $('#axionpreinspection-customerappointdatetime').val();
        var rescheduleReason = $('#axionpreinspection-reschedulereason').val();
        var rescheduleDateTime = $('#axionpreinspection-rescheduledatetime').val();
        var rescheduleReason1 = $('#axionpreinspection-reschedulereason1').val();
        var rescheduleDateTime1 = $('#axionpreinspection-rescheduledatetime1').val();
        var completedSurveyDateTime = $('#axionpreinspection-completedsurveydatetime').val();
        var cancellationReason = $('#axionpreinspection-cancellationreason').val();
        var followupReason = $('#axionpreinspection-followupreason').val();
        var followupRemainder = $('#axionpreinspection-followupremainder').val();
        var followupUpdatedBy = $('#axionpreinspection-followupupdatedby').val();
        var city = $('#cityId').val();
        var town = $('#townId').val();
        
        
        if(lastStatus == '0' && status == '0' && followupReason == 0 && newRecord == 'N' )
        {
           alert("Please update followup/status");
           return false;
        }
        
        if(lastStatus == '0' && status == '0' && followupReason != 0 && followupRemainder == '' )
        {
           alert("Please enter follow up remainder");
           return false;
        }
        
        if(lastStatus == '0' && status == '0' && followupReason != 0 && followupRemainder != '' && followupUpdatedBy == '' )
        {
           alert("Please enter follow up updated by");
           return false;
        }
        
        if((lastStatus == '0' && status == '0' && followupReason != 0 && followupRemainder != '' && followupUpdatedBy != '') || newRecord == 'Y' )
        {
           status = 100; //changing to change ro status so alerts conditions will disabled
        }
        
        if(lastStatus != '0' && status == '0')
        {
         alert("Please select Status");
         return false;
        }
        
        if(status != 100)
        {
            if(city == '')
            {
              alert("Please select City");
              return false;
            }
        
            if(town == '')
            {
              alert("Please select Town");
              return false;
            }
        
            if(vehicleType == '4-Wheeler' && vehicleTypeRadio == '')
            {
             alert("Please select vehicle type");
             return false;
            }

            if(extraKM == '')
            {
             alert("Please enter extra KM");
             return false;
            }

            if(surveyLocation == '')
            {
             alert("Please enter Survey Location");
             return false;
            }

            if(surveyorName == '')
            {
             alert("Please select Surveyor Name");
             return false;
            }

            if(status == 12 && customerAppointDateTime == '')
            {
             alert("Please enter Customer Appoint Datetime");
             return false;
            }

            if(lastStatus == 12 && status == 1 && (rescheduleReason == '' || rescheduleDateTime == ''))
            {
             alert("Please enter RescheduleReason and Datetime");
             return false;
            }

            if(lastStatus == 1 && status == 1 && (rescheduleReason1 == '' || rescheduleDateTime1 == ''))
            {
             alert("Please enter RescheduleReason and Datetime");
             return false;
            }

            if(status == 8 && completedSurveyDateTime == '')
            {
             alert("Please enter Completed Survey Datetime");
             return false;
            }

            if(status == 9 && cancellationReason == '')
            {
             alert("Please select Cancellation Reason");
             return false;
            } 
        }
        
       /*   
        var id = $('#process_hid_id').val();
        if(id != '')
        {
            var remarks= $('#remarks').val();
            if(remarks == '')
            {
               alert("Please enter remarks");
               return false;
            }
        }
        */
        
        if(extraKM > 100 )
        {
          alert("extra KM is more than 100");
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
                        window.location.href = "./";
                      }
                      else{
                        alert(data);
                        //document.getElementById("output").innerHTML = data;
                        $(document).find('#create-modal').modal('hide');
                        $(document).find('#update-modal').modal('hide');
                        $(form).trigger("reset");
                        $('#w0').yiiGridView('applyFilter');
                        $("#loading-image").hide();
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


