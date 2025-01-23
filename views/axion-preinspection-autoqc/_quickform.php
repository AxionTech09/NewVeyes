<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

date_default_timezone_set('Asia/Calcutta');

$divisionList = ArrayHelper::map($division,'id','divisionName');

$regionList = ArrayHelper::map($region,'id','regionName');



if(isset($valuator))
{
    $arr = [
            'add' => [
                'id' => '0',
                'firstName'=>'Self Inspection'
            ],
        ];
    $valuator = ArrayHelper::merge($arr, $valuator);
    $valuatorData=ArrayHelper::map($valuator,'id','firstName');
    
}
else {
    $valuatorData= [''=>'Select','0'=>'Self Inspection'];
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
      //['id' => '100', 'name' => 'Change RO'],  
    ];
}
else if($lastStatus == 9)
{
    $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '12', 'name' => 'Scheduled'],
      ['id' => '1', 'name' => 'Intimation Re-Schedule'],
      ['id' => '9', 'name' => 'Cancelled'],
      //['id' => '100', 'name' => 'Change RO'],  
    ];
}
 else {    
     $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '12', 'name' => 'Scheduled'],
      ['id' => '8', 'name' => 'Survey Done'],
      ['id' => '9', 'name' => 'Cancelled'],
      //['id' => '100', 'name' => 'Change RO'],   
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
if($role == 'Admin' || $role == 'Superadmin' || $role == 'BO User' || $role == 'Veyes UAT')
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
// Temp Hide 05-07-2023
$followUpCheckSave = "";
/*if($block == 'Y' && $sameId == 'N')
{
    echo "<div style='color:red;font-weight:bold;font-size:20px;margin-bottom:6px;'>Cannot save this reference no! Please complete the pending followup remainders.</div>";
    $followUpCheckSave = 'N';
}
else {
    $followUpCheckSave = 'Y';
}*/

$cityList =ArrayHelper::map($city,'id','city');
$stateList =ArrayHelper::map($state,'id','state');
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

if(isset($surveyor_list) && $surveyor_list != null){
    $surveyorList = ArrayHelper::map($surveyor_list,'id','firstName');
    $surveyorListArray =  $surveyorList + ['0' => 'Self Inspection','' => 'All'];
}else{
    $surveyorList = [
        '0' => 'Self Inspection',
        '' => 'All',
    ];
    $surveyorListArray = $surveyorList;
}

$vTypeList = [
    ['id' => '4-WHEELER', 'name' => '4-WHEELER'],
    ['id' => '2-WHEELER', 'name' => '2-WHEELER'],
  ];
$vTypeArray = ArrayHelper::map($vTypeList, 'id', 'name');
  


// array_push($surveyorList,$defaultoption);
?>

<div class="preinspection-form mb-100 mt-80">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(), 
                                    'enableAjaxValidation'=>true,
                                    'validationUrl' => ['axion-preinspection/validation','id' =>$id],
                                    ]); ?>
    
    
    <div id="company_details" class="panel panel-primary pb-15">

        <div class="panel-body">
        
            <?= $form->field($model, 'vehicleType')->hiddenInput(['value' => 'ALL-VEHICLE'])->label(false);?>  
            
            <div style="display:none">
                <?php
                $id = $model->id ?? '0';
                echo $form->field($model, 'insurerName')->dropDownList($companyList, [
                    'prompt' => 'Select',
                    'id' => 'ins_companyId',
                    'options' => [
                        20 => ['Selected' => true] // Set default value to 20
                    ],
                    'onchange' => '
                        $.post("' . Yii::$app->urlManager->createUrl('user-data/divisionlist?id=') . '"+$(this).val(), function(data) {
                            $("select#divisionId").html(data);
                            $("select#branchId, select#callerId").html("<option value=\'\'>Select</option>");
                            $("#callerMobileNo, #callerDetails").val("");

                            $.get("' . Yii::$app->urlManager->createUrl('axion-preinspection/vehicle-check') . '", {
                                regno: $("#axionpreinspection-registrationno").val(),
                                companyId: $("#ins_companyId").val(),
                                id: ' . $id . '
                            }, function(data) {
                                data = JSON.parse(data);
                                if (data.counts >= 1) {
                                    $("#registrationNoWarning, #cashCollectionDiv").show();
                                    $("#paymentMode option[value=2]").prop("selected", true).parent("select").attr("readonly", "readonly");
                                    $("#paymentMode").on("change", function() {
                                        $("#paymentMode option[value=2]").prop("selected", true);
                                    });
                                } else {
                                    $("#registrationNoWarning, #cashCollectionDiv").hide();
                                    $("#paymentMode").removeAttr("readonly").off("change").val("");
                                }
                            });
                        });
                    ',
                ]);
                ?>
            </div>
            
            
            <?php if($role != 'Commonuser' ) { ?>
                
                <!-- <?= $form->field($model, 'insurerName')->hiddenInput(['value' => 20])->label(false) ?> -->
                <div class="alert bg-limered text-white" id="registrationNoWarning" style="display:none;">
                    <strong>Warning!</strong> This Registration Number already exist for the current month.
                </div>

                <div class="col-sm-4 col-md-3 text-error">
                    <?php 
                        $id = (@$model->id) ? @$model->id: '0';
                    ?>
                    <?= $form->field($model, 'registrationNo')->textInput(['onblur'=>'
                        $.get("'.Yii::$app->urlManager->createUrl('axion-preinspection/vehicle-check').'",{regno:$(this).val(), companyId:$("#companyId").val(), id: ' .  $id . '}, 
                            function( data ) {
                                data = JSON.parse(data);

                                if(data.counts >= 1){
                                    $("#registrationNoWarning, #cashCollectionDiv").show();            
                                }
                                else{
                                    $("#registrationNoWarning, #cashCollectionDiv").hide();                
                                }

                                if (data.counts >= 1) {
                                    $("#paymentMode option[value=2]").prop("selected", true).parent("select").attr("readonly", "readonly");
                                    $("#paymentMode").on("change", function() {
                                        $("#paymentMode option[value=2]").prop("selected", true);
                                    });
                                }
                                else {
                                    if($("#newRecord" ).val() == "Y"){
                                        $("#paymentMode").removeAttr("readonly").off("change").val("");
                                    }else{
                                        $("#paymentMode").removeAttr("readonly").off("change");
                                    }
                                }
                            
                            //$("#callerMobileNo" ).val( arr[0] );
                        
                            });
                        ']);
                
                    ?>
                </div>
                <div class="col-sm-4 col-md-3 text-error">
                   <?= $form->field($model, 'vType')->dropDownList($vTypeArray, ['prompt' => 'Select', 'enableClientValidation' => true])->label('Vehicle Type*') ?>
                </div>

                <div class="col-sm-4 col-md-3">
                  <?= $form->field($model, 'regionName')
                 // ->label('Region Name') // Custom label
                  ->dropDownList(
                  ['' => 'Select'] + $regionList, 
                   [
                     'id' => 'regionId', 
                     'style' => 'width:300px'
                   ]
                  ) ->label('Insurer Region');
                   ?>
               </div>

                <div class="col-sm-4 col-md-3">

                    <?php 
                    if($role == 'Branch Head' || $role == 'Branch Executive')
                    {
                        echo $form->field($model, 'insurerDivision')->dropDownList($divisionList,['readonly' =>true,'id'=>'divisionId']);
                    }
                    else {
                        echo $form->field($model, 'insurerDivision')->dropDownList($divisionList,['prompt'=>'Select','id'=>'divisionId','onchange'=>'
                            $.get("'.Yii::$app->urlManager->createUrl('user-data/branchlist').'",{id:$(this).val(),cid:$("#ins_companyId").val()}, 
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
                    
                <div class="col-sm-4 col-md-3">
                    <?php if($role == 'Branch Head' || $role == 'Branch Executive')
                    {
                        echo $form->field($model, 'insurerBranch')->dropDownList($branchList,['readonly' =>true,'id'=>'RegionId']);
                    }
                    else {
                    
                    echo $form->field($model, 'insurerBranch')->dropDownList($branchList,['prompt'=>'Select','id'=>'branchId','onchange'=>'
                            $.get("'.Yii::$app->urlManager->createUrl('user-data/callerlist').'",{companyId:$("#companyId").val(),divisionId:$("#divisionId").val(),branchId:$(this).val()}, 
                                function( data ) {
                                $( "select#callerId" ).html( data );
                                $( "#callerMobileNo" ).val("");
                                $( "#callerDetails" ).val("");
                                });
                            ']);
                    } ?>
                </div> 
                
                
                <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($model, 'insuredMobile')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured Mobile*') ?>
                </div>
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'insuredAddress')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured EmailID*') ?>
                </div>
                    <?php 
                    
                        if($model->isNewRecord)
                        {
                            echo $form->field($model, 'intimationDate')->hiddenInput(['value' => date('d-m-Y h:i A')])->label(false);

                            
                        }
                        else
                        {             
                            echo $form->field($model, 'intimationDate')->hiddenInput(['readonly' =>true,'value' => $model->intimationDate?date('d-m-Y h:i A', strtotime($model->intimationDate)):'']);
                        } 
                        
                        /*
                            echo $form->field($model, 'intimationDate')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                            ]
                                        ]
                                ]); 
                        */
                    ?>    
                        

                
                          
                <?php
            }   ?>
        </div> <!-- Panel Body End Here -->
            
    </div> <!-- Panel End Here -->
    

    <br>
    <?= Html::hiddenInput('name', $id, ['id' => 'process_hid_id']); ?>
    
    <?= Html::hiddenInput('name', $lastStatus, ['id' => 'lastStatus']); ?>
    
    <?= Html::hiddenInput('name', $model->isNewRecord?"Y":"N", ['id' => 'newRecord']); ?>

    <?php
    if($lastStatus != 9 && $lastStatus != 101 && $lastStatus != 102 && $lastStatus != 103 && $lastStatus != 104) { // && $followUpCheckSave == 'Y' ?> 
        <div class="col-md-12 form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? 'Next' : FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if (!$model->isNewRecord) { ?>
                <a href="javascript:;" class="btn btn-danger" id="model-close" data-dismiss="modal"><?=FAR::icon('times-circle', ['class' => 'mr-3 mt-5 text-white'])?> Close</a> <?php // data-dismiss="modal" ?>
            <?php } ?>
        </div>
        <div id="ajaxLoad">
            <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
        </div>
    <?php } else { ?>
        <div class="col-md-12 form-group text-center">
            <a href="javascript:;" class="btn btn-danger" id="model-close" data-dismiss="modal"><?=FAR::icon('times-circle', ['class' => 'mr-3 mt-5 text-white'])?> Close</a> <?php // data-dismiss="modal" ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    <?php 
    $id = (@$model->id) ? @$model->id: '0';
    $this->registerJs(
        "
        $(function () {
        
            $(document).on('change', '#paymentMode', function () {
                var selected = $(this).find('option:selected').val();
                
                if(selected == 2 || selected == 3 )
                {
                    $('#cashCollectionDiv').show();
                }
                else
                {
                    $('#cashCollectionDiv:last').hide();  
                }
                return false;
            });

            if ($('#newRecord').val() == 'N') {
                console.log('load');
                $.get('".Yii::$app->request->baseUrl."/axion-preinspection/vehicle-check',
                {
                    regno:$('#axionpreinspection-registrationno').val(),
                    companyId:$('#companyId').val(),
                    id: ".$id."    
                },
                function( data ) {
                    data = JSON.parse(data);

                    if(data.counts >= 1){
                        $('#registrationNoWarning, #cashCollectionDiv').show();  
                        console.log('#registrationNoWarning & #cashCollectionDiv show');
                    }else if($('#paymentMode').val() == 2){
                        $('#cashCollectionDiv').show(); 
                        console.log('#cashCollectionDiv show');
                    }
                    else{
                        $('#registrationNoWarning, #cashCollectionDiv').hide();
                        console.log('#registrationNoWarning & #cashCollectionDiv hide');
                    }    

                    if (data.counts >= 1) {
                        $('#paymentMode option[value=2]').prop('selected', true).parent('select').attr('readonly', 'readonly');
                        $('#paymentMode').on('change', function() {
                            $('#paymentMode option[value=2]').prop('selected', true);
                        });
                        console.log('#paymentMode option[value=2] select');
                    }
                    else {
                        // $('#paymentMode').attr('readonly', 'readonly').off('change');
                        // $('#paymentMode').on('change', function() {
                        //     $('#paymentMode option[value=1]').prop('selected', true);
                        // });
                        // $('#paymentMode').removeAttr('readonly').off('change');
                        
                    }
                });
            }

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
        });
        "
            
    ); ?>

</div>

<?php
$script = <<< JS

$(function () {
    document.addEventListener("DOMContentLoaded", function() {
        var companyId = document.getElementById("ins_companyId");
        if (companyId) {
            companyId.value = 20;
            var event = new Event('change');
            companyId.dispatchEvent(event);
        }
    });
    $('#AxionPreinspection').on('beforeSubmit', function(e) 
    {

        var lastStatus = $('#lastStatus').val();
        var newRecord = $('#newRecord').val();
        var status = $('#axionpreinspection-status').find('option:selected').val();
        // var companyId=$('#companyId').find('option:selected').val();
        var remarks = $('#axionpreinspection-remarks').val();
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
        var ul_number=$("#axionpreinspection-contactpersonmobileno").val();

        // $('#paymentMode').removeAttr('disable');

        if(newRecord=='N' && extraKM =='' && status=='0')
        {
            alert("Please enter extra KM");
            return false;
        }



        
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
        alert("Please select Status Of Vehicle");
        return false;
        }
        
        
        if(status != 100 && status != 9)
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
        
            // if(vehicleType == '4-Wheeler' && vehicleTypeRadio == '')
            // {
            //  alert("Please select vehicle type");
            //  return false;
            // }

            // if(extraKM == '')
            // {
            //  alert("Please enter extra KM");
            //  return false;
            // }

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
                
                if(data != '')
                {
                    //alert("Request Created Successfully...");
                    //window.location.href = "./fresh";
                    var id = data;  
                    window.location.href = "./vehicleqc?id=" + id + "&page=completed";
                    // window.location.href = "./payment?id=" + id;
                    //window.location.href = "./pi-qc-screen?id=" + id + "&page=completed";
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
});
// $("#model-close, .close").click(function(e){
//     e.preventDefault();    
//     var status = $("#axionpreinspection-status").val();
//     var remarks = $("#axionpreinspection-remarks").val();
//     if(status != 0 || remarks != ''){
//         $('#update-modal').modal('hide');
//     }else{
//         alert('Please Update status or remarks');
//         return false;
//     }
// });
JS;
$this->registerJS($script);
?>


