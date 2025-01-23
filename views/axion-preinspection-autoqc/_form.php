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
                <?= $form->field($model, 'referenceNo')->textInput(['readonly' =>true]) ?>
            </div>
        
            <?php if($role != 'Commonuser' ) { ?>
        
                <div class="col-sm-4 col-md-3">
            
                    <?php if($role == 'Branch Head' || $role == 'Branch Executive') {
                        echo $form->field($model, 'insurerName')->dropDownList($companyList,['id'=>'companyId']);
                    }
                    else {
                        $id = (@$model->id) ? @$model->id: '0';
                        echo $form->field($model, 'insurerName')->dropDownList($companyList,['prompt'=>'Select','id'=>'companyId','onchange'=>'
                                $.post( "'.Yii::$app->urlManager->createUrl('user-data/divisionlist?id=').'"+$(this).val(), function( data ) {             
                                    $( "select#divisionId" ).html( data );
                                    $( "select#branchId" ).html("<option value=\'\'>Select</option>");
                                    $( "select#callerId" ).html("<option value=\'\'>Select</option>");
                                    $( "#callerMobileNo" ).val("");
                                    $( "#callerDetails" ).val("");

                                    $.get("'.Yii::$app->urlManager->createUrl('axion-preinspection/vehicle-check').'",{regno:$("#axionpreinspection-registrationno").val(), companyId:$("#companyId").val(), id: ' .  $id . '}, 
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
                                    
                                    //$("#callerMobileNo" ).val( arr[0] );
                                
                                    });
                                });
                            
                        ']);
                    } ?> 
                    
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

                <div class="col-sm-4 col-md-3">
                
                    <?php 
                    
                        if($model->isNewRecord)
                        {
                            echo $form->field($model, 'intimationDate')->textInput(['readonly' =>true,'maxlength' => true,'value' => date( 'd-m-Y h:i A')]); 
                            
                        }
                        else
                        {             
                            echo $form->field($model, 'intimationDate')->textInput(['readonly' =>true,'value' => $model->intimationDate?date('d-m-Y h:i A', strtotime($model->intimationDate)):'']);
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
                        
                </div>    

                <div class="col-sm-4 col-md-3 text-error">

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
                    <?= $form->field($model, 'callerMobileNo')->textInput(['id'=>'callerMobileNo','readonly' =>true,'maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'callerDetails')->textInput(['id'=>'callerDetails','readonly' =>true,'maxlength' => true]) ?>
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
        
        
    <div id="customer_details" class="panel panel-primary pb-15 mt-40">

        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Customer Details</h4>
        </div>

        <div class="panel-body">

            <?php if($role != 'Commonuser' ) { ?>

                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'insuredName')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured Name*') ?>
                </div>
                
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'insuredMobile')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured Mobile*') ?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'insuredMobileAlt')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured Alternate Mobile') ?>
                </div>        
                
                <?php if($role != 'Surveyor') { ?>
                    <div class="col-sm-4 col-md-3 text-error">
                        <?php if(strpos( Yii::$app->request->absoluteUrl, 'veyes') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false ) { 
                            echo $form->field($model, 'contactPersonMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Unique Lead Number*');  
                        } else { 
                            echo $form->field($model, 'contactPersonMobileNo')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true])->label('Insured Email');
                        } ?>
                    </div>    
                <?php } ?>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'insuredAddress')->textInput(['readonly' =>$model->isNewRecord?false:true,'maxlength' => true]) ?>
                </div>
            <?php } ?>
        </div> <!-- Panel Body End Here -->

    </div> <!-- Panel End Here -->
    
    
    
    <div id="vehicle_details" class="panel panel-primary pb-15 mt-40">
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Vehicle Details</h4>
        </div>

        <div class="panel-body">
    
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

            
            <?php if($role == 'Admin' || $role == 'Superadmin' || $role == 'BO User') { 
					if($role != 'BO User') { ?>

						<div class="col-sm-4 col-md-3">
							<?= $form->field($model, 'engineNo')->textInput(['maxlength' => true]) ?>
						</div>

						<div class="col-sm-4 col-md-3">
							<?= $form->field($model, 'chassisNo')->textInput(['maxlength' => true]) ?>
						</div>   
						
					<?php } if($role == 'Admin' || $role == 'Superadmin' || $role == 'BO User') { ?>
                
						<div class="col-sm-4 col-md-3">
							<?php if ($model->isNewRecord) { ?>
								<?= $form->field($model, 'manufacturer')->textInput(['readonly' =>$model->isNewRecord?false:true, 'maxlength' => true])->label('Manufacturer*') ?>
							<?php } else { ?>
								<div class="form-group field-axionpreinspection-manufacturer">
									<?= Html::label('Manufacturer', 'axionPreinspection-manufacturer')?>
									<?= Html::input('text', 'AxionPreinspection[manufacturer]', $model->manufacturer, ['class' => 'form-control', 'id' => 'axionPreinspection-manufacturer', 'readonly' => true]) ?>
								</div>
							<?php } ?>
						</div>				
                
						<div class="col-sm-4 col-md-3">                
							<?php if ($model->isNewRecord) { ?>
								<?= $form->field($model, 'model')->textInput(['readonly' =>$model->isNewRecord?false:true, 'maxlength' => true])->label('Model*') ?>
							<?php } else { ?>
								<div class="form-group field-axionpreinspection-model">
									<?= Html::label('Model', 'axionPreinspection-model')?>
									<?= Html::input('text', 'AxionPreinspection[model]', $model->model, ['class' => 'form-control', 'id' => 'axionPreinspection-model', 'readonly' => true]) ?>
								</div>
							<?php } ?>
						</div>
					
					<?php } if($role != 'BO User') { ?>

						<div class="col-sm-4 col-md-3">
							<?= $form->field($model, 'manufacturingYear')->textInput(['readonly' =>$model->isNewRecord?false:true]) ?>
						</div>

						<div class="col-sm-4 col-md-3">
							<?= $form->field($model, 'intimationRemarks')->textInput(['readonly' =>($model->isNewRecord || $role == 'Superadmin' || $role == 'Admin')?false:true,'maxlength' => true]) ?>
						</div>

						<div class="col-sm-4 col-md-3">
							<?= $form->field($model, 'vehicleTypeRadio')->hiddenInput($vehicleTypeRadioArray)->label(false); ?>
						</div>
				<?php } 
				} ?>
    
        </div> <!-- Panel Body End Here -->
    </div> <!-- Panel End Here -->
    
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

    <!-- Only Superadmin, Admin, BO users allowed -->
    <?php if ($role != 'Surveyor' && $role != 'Branch Executive') { ?>
        
        
        <div id="inspection_details" class="panel panel-primary pb-15 mt-40" style="display: <?= $inspectionDisplay; ?>"> 
        
            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title" style="display: <?= $inspectionDisplay; ?>">Inspections Details</h4>
            </div>

            <div class="panel-body">

                <?php /*<div class="col-sm-4 col-md-3">     
                    <?= $form->field($model, 'cityId')->dropDownList($cityList,['prompt'=>'Select','id'=>'cityId','onchange'=>'
                        $.post( "'.Yii::$app->urlManager->createUrl('axion-preinspection/townlist?id=').'"+$(this).val(), function( data ) {
                            var output = data.split("|&|");
                            $( "select#townId" ).html( output[0] );
                            $( "select#axionpreinspection-surveyorname" ).html( output[1] );
                            $( "input#axionpreinspection-extrakm" ).val(\'\');
                        });
                    ']);?>
                </div>
                    
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'townId')->dropDownList($townList,['id'=>'townId','onchange'=>'
                        $.get("'.Yii::$app->urlManager->createUrl('axion-preinspection/kmsvalue').'",{id:$(this).val(),cid:$("#cityId").val()}, 
                            function( data ) {
                            $( "input#axionpreinspection-extrakm" ).val( data );
                        });
                    ']) ?>
                </div> 
                
                <div class="col-sm-4 col-md-3">     
                    <?= $form->field($model, 'stateId')->dropDownList($stateList,['prompt'=>'Select','id'=>'stateId','onchange'=>'
                        $.post( "'.Yii::$app->urlManager->createUrl('axion-preinspection/getsurveyors?id=').'"+$(this).val()+"&modalid='.$model->id.'", function( data ) {
                            var output = data;
                            $( "select#axionpreinspection-surveyorname" ).html( output );
                            $( "input#axionpreinspection-extrakm" ).val(\'\');
                        });
                    ']);?>
                </div>

                */ ?>

                <div class="col-sm-4 col-md-3 <?=$model->isNewRecord?'':'text-error'?>">
                    <?= $form->field($model, 'surveyLocation')->textInput(['maxlength' => true])->label('Survey From Location') ?>
                </div>
                <div class="col-sm-4 col-md-3 <?=$model->isNewRecord?'':'text-error'?>">
                    <?= $form->field($model, 'surveyLocation2')->textInput(['maxlength' => true])->label('Survey To Location') ?>
                </div>
                <div class="col-sm-4 col-md-3 <?=$model->isNewRecord?'':'text-error'?>">     
                    <?= $form->field($model, 'extraKM')->textInput() ?>
                </div>

                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'surveyorName')->dropDownList($surveyorListArray,['prompt'=>'Select','onchange'=>'
                        $.post( "'.Yii::$app->urlManager->createUrl('axion-preinspection/surveyorall?id=').'"+$(this).val(), function( data ) {
                        if(data != "noload")
                        {
                            $( "select#axionpreinspection-surveyorname" ).html( data );
                        }
                        });
                    ']);?>
                </div>
                    
                <div class="col-sm-4 col-md-3">  
                    <?= $form->field($model, 'surveyorAppointDateTime')->textInput(['readonly' => true,'maxlength' => true,'value' => $model->surveyorAppointDateTime?date( 'd/m/Y h:i A', strtotime( $model->surveyorAppointDateTime )):'']) ?>
                </div>   
                  
                <div class="col-sm-4 col-md-3 text-error">
                    <?= $form->field($model, 'inspectionType')->dropDownList($inspectionTypeArray)->label('Inspection Type*') ?> 
                </div>

                <div class="col-sm-4 col-md-3 text-error">  
                    <?= $form->field($model, 'paymentMode')->dropDownList($paymentArray,['id' => 'paymentMode']) ?>
                </div>  
                
                <div class="col-sm-4 col-md-3" style="display: <?php echo $cashCollectionDisplay; ?>;" id="cashCollectionDiv">
                    <?= $form->field($model, 'cashCollection')->textInput(['maxlength' => true]) ?>
                </div>
                
                <div class="col-sm-4 col-md-3 text-error">  
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
                
                <!-- <div class="col-sm-4 col-md-3">
                
                    <div class="form-group">
                        <label class="control-label" >Status SMS</label>
                            <?= Html::dropDownList('sendSms', null,['Y'=>'Y','N'=>'N'], [
                                'class' => 'form-control'
                            ]) ?>
                        <div class="help-block"></div>
                    </div>
                </div> -->
                
                <div class="col-sm-4 col-md-3">
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
                
                <div class="col-sm-4 col-md-3" style="display: <?php echo $rescheduleDisplay; ?>;" id="rescheduleReasonDiv">
                    <?php if(!$model->isNewRecord && $lastStatus == 1)
                    {
                        echo $form->field($model, 'rescheduleReason')->textInput(['readonly' =>true,'maxlength' => true]); 
                        
                    }
                    else
                    {
                        echo $form->field($model, 'rescheduleReason')->textInput(['maxlength' => true]);
                    }
                    ?>
                </div>
                
                <div class="col-sm-4 col-md-3" style="display: <?php echo $rescheduleDisplay; ?>;" id="rescheduleDateTimeDiv">
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
                
                <div class="col-sm-4 col-md-3" style="display: <?= $reschedule1Display; ?>;" id="reschedule1ReasonDiv">
                    <?= $form->field($model, 'rescheduleReason1')->textInput(['maxlength' => true]);?>
                </div>
                
                <div class="col-sm-4 col-md-3" style="display: <?= $reschedule1Display; ?>;" id="reschedule1DateTimeDiv">
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
                    
                <div class="col-sm-4 col-md-3" style="display: <?= $cancellationReasonDisplay; ?>;" id="cancellationReasonDiv">
                    <?php
                    if(!$model->isNewRecord && $lastStatus == 9)
                    {
                        echo $form->field($model, 'cancellationReason')->dropDownList($cancelReasonArray,['prompt'=>'Select','disabled' =>true,'maxlength' => true]);
                        
                    }
                    else
                    {
                        echo $form->field($model, 'cancellationReason')->dropDownList($cancelReasonArray,['prompt'=>'Select']);
                    }
                    ?>
                </div>
                
                <div class="col-sm-4 col-md-3" style="display: <?= $completedSurveyDateTimeDisplay; ?>;" id="completedSurveyDateTimeDiv">
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
                <?php if($lastStatus == 1) { ?>
                    
                    <div class="col-sm-4 col-md-3">     
                        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
                    </div>
                    
                <?php } 
                else { ?>
                    <div class="col-sm-4 col-md-3">     
                        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
                    </div>
                <?php } ?>
                        
            </div> <!-- Panel Body End Here -->
        </div> <!-- Panel End Here -->

    <?php } ?>

    <!-- Branch Executive Login -->
    <?php if ($role == 'Branch Executive') { ?>

        <div id="inspection_details" class="panel panel-primary pb-15 mt-40"> 

            <div class="panel-heading light-panel-heading pb-15">
                <h4 class="panel-title">Inspections Details</h4>
            </div>

            <div class="panel-body">
        
                <div class="col-sm-4 col-md-3 text-error">  
                    <?= $form->field($model, 'paymentMode')->dropDownList($paymentArray,['id' => 'paymentMode']) ?>
                </div>
                <div class="col-sm-4 col-md-3" style="display: <?php echo $cashCollectionDisplay; ?>;" id="cashCollectionDiv">
                    <?= $form->field($model, 'cashCollection')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= $form->field($model, 'inspectionType')->dropDownList($inspectionTypeArray) ?> 
                </div>
            </div> <!-- Panel Body End Here -->

        </div> <!-- Panel End Here -->
    <?php } ?>

    
    <div id="followup" class="panel panel-primary pb-15 mt-40" style="display: <?php echo $followupDisplay; ?>">
            
        <div class="panel-heading light-panel-heading pb-15">
            <h4 class="panel-title">Follow Up</h4>
        </div>

        <div class="panel-body">

            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'followupReason')->dropDownList($followupReasonArray); ?>
            </div>
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'followupRemainder')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATETIME,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                        ]
                    ]
                ]) ?>
            </div>
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'followupUpdatedDateTime')->textInput(['readonly' =>true,'maxlength' => true,'value' => $model->followupUpdatedDateTime?date( 'd/m/Y h:i A', strtotime( $model->followupUpdatedDateTime )):'']) ?>
            </div>
        
            <div class="col-sm-4 col-md-3">
                <?= $form->field($model, 'followupUpdatedBy')->textInput(['maxlength' => true]) ?>
            </div>
            
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
$script = <<< JS

$(function () {

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
                    if(data == 'noajax success')
                    {
                        
                        alert("Request  Created Successfully...");
                        
                        window.location.href = "./fresh";
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


