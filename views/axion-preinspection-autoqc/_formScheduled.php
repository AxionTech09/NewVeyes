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
// print_r($surveyorList);
// array_push($surveyorList,$defaultoption);
?>

<div class="preinspection-form mb-100">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(), 
                                    'enableAjaxValidation'=>true,
                                    'validationUrl' => ['axion-preinspection/validation','id' =>$id],
                                    ]); ?>
    
    
    <div id="company_details" class="panel panel-primary pb-15">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Company Details</h4>
        </div>

        <div class="panel-body">
        
            <?= $form->field($model, 'vehicleType')->hiddenInput(['value' => 'ALL-VEHICLE'])->label(false);?>  
    
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'referenceNo')->textInput(['id'=>'referenceNo','readonly' =>false])->label('Registration Number') ?>
            </div>
        
            <?php if($role != 'Commonuser' ) { ?>
        
                <div class="col-sm-4 col-md-3" style="display: none;">
                   <?php 
  
                      $defaultSelected = '';

    
                    foreach ($companyList as $id => $name) {
                      if ($id == 17) {
                        $defaultSelected = $id;
                        break;
                    }
                  }

                  if ($role == 'Branch Head' || $role == 'Branch Executive') {
                  echo $form->field($model, 'insurerName')->dropDownList($companyList, [
                  'id' => 'companyId',
                   'options' => [
                    $defaultSelected => ['Selected' => true]
                  ]
               ]);  
               } else {
                $id = (@$model->id) ? @$model->id : '0';
               echo $form->field($model, 'insurerName')->dropDownList($companyList, [
               'prompt' => 'Select',
               'id' => 'companyId',
                'options' => [
                $defaultSelected => ['Selected' => true]
             ],
             'onchange' => '
                $.post( "' . Yii::$app->urlManager->createUrl('user-data/divisionlist?id=') . '"+$(this).val(), function( data ) {             
                    $( "select#divisionId" ).html( data );
                    $( "select#branchId" ).html("<option value=\'\'>Select</option>");
                    $( "select#callerId" ).html("<option value=\'\'>Select</option>");
                    $( "#callerMobileNo" ).val("");
                    $( "#callerDetails" ).val("");

                    $.get("' . Yii::$app->urlManager->createUrl('axion-preinspection/vehicle-check') . '",{regno:$("#axionpreinspection-registrationno").val(), companyId:$("#companyId").val(), id: ' .  $id . '}, 
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
                            $("#paymentMode").removeAttr("readonly").off("change").val("");
                        }
                    });
                });
              '
              ]);
              } 
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
                    
                <div class="col-sm-4 col-md-3">
                    <?php if($role == 'Branch Head' || $role == 'Branch Executive')
                    {
                        echo $form->field($model, 'insurerBranch')->dropDownList($branchList,['readonly' =>true,'id'=>'branchId']);
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

                <div class="col-sm-4 col-md-3" style="display: none;">
                 <?php 
                  if ($model->isNewRecord) {
                    echo $form->field($model, 'intimationDate')->textInput([
                     'id' => 'intimationDate', 
                     'readonly' => true, 
                     'maxlength' => true, 
                     'value' => date('d-m-Y h:i A')
                   ]); 
                 } else {             
                 echo $form->field($model, 'intimationDate')->textInput([
                   'id' => 'intimationDate', 
                   'readonly' => true, 
                   'value' => $model->intimationDate ? date('d-m-Y h:i A', strtotime($model->intimationDate)) : ''
                  ]);
                 } 
                  ?>
                </div>


                <div class="col-sm-4 col-md-3 text-error" style="display: none;">

                    <?php 
                    if($role == 'Branch Head' || $role == 'Branch Executive')
                    {
                        echo $form->field($model, 'callerName')->dropDownList($callerList,['readonly' =>true,'id'=>'callerId']);
                    }
                    else {
                    echo $form->field($model, 'callerName')->dropDownList($callerList,['id'=>'callerId', 'prompt'=>'Select', 'onchange'=>'
                        $.get("'.Yii::$app->urlManager->createUrl('user-data/callerdetails').'",{callerId:$(this).val()}, 
                            function( data ) {
                            var arr = data.split("|&|");
                            $("#callerMobileNo" ).val( arr[0] );
                            $("#callerDetails" ).val( arr[1] );
                            });
                        ']);
                    } ?>
                </div>
                
                
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'callerMobileNo')->textInput(['id'=>'callerMobileNo','readonly' =>FALSE,'maxlength' => true])->label('Insured Mobile') ?>
                </div>
                    
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'callerDetails')->textInput(['id'=>'callerDetails','readonly' =>false,'maxlength' => true])->label('Inusred EMail') ?>
                </div>
                
                
                <?php if($callerModel) { ?>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?= $form->field($callerModel, 'callerName')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Name') ?>
                    </div>    

                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($callerModel, 'callerMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Mobile No') ?>
                    </div>
                    
                    <div class="col-sm-4 col-md-3">
                        <?= $form->field($callerModel, 'callerEmailId')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('PC Caller Email Id') ?>
                    </div>            
                <?php } 
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
            <?= Html::submitButton($model->isNewRecord ? FA::icon('plus-circle', ['class' => 'mr-3 mt-5 text-white']).' Create' : FA::icon('edit', ['class' => 'mr-3 mt-5 text-white']).' Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
//$url = YII::$app->request->baseUrl.'/axion-preinspection/save-schedule-request';
$url = \yii\helpers\Url::to(['axion-preinspection/save-schedule-request']);


$script = <<< JS

$(function () {
    $('#AxionPreinspection').on('beforeSubmit', function(e) 
    {
        alert('1234');

    }).on('submit', function(e){
        var referenceno = $('#referenceNo').val();
        var insurerBranch = $('#insurerBranch').val();
        //var insurerDivision = $('#insurerDivision').val();
        var insurerDivision ="1";
        //var callerMobileNo = $('#callerMobileNo').val();
        var callerMobileNo ="1";
        var callerDetails = $('#callerDetails').val();
        var intimationDate = $('#intimationDate').val();  
        //alert('1234');

        $.ajax({
        url:'$url',
        type: 'POST',
        data: {
            referenceNo: referenceno,
            insurerBranch: insurerBranch,
            insurerDivision: insurerDivision,
            callerMobileNo: callerMobileNo,
            callerEmailId: callerDetails,
            intimationDate : intimationDate
        },
        success: function(response) {
            // Handle the response from the server
            alert('Data saved successfully!');
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
            alert('An error occurred while saving the data.');
        }
      });              
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


