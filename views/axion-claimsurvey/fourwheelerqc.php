<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\AxionClaimsurveyFourwheeler */
/* @var $form ActiveForm */
/* @var $premodel app\models\AxionClaimsurvey */
/* @var $form yii\widgets\ActiveForm */
/* @var $assests app\models\AxionClaimsurveyAssessment */


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

$rcArray = $model->rcValue;
$statusArray = $model->qcStatusValue;
if($role == 'Surveyor')
{
  $statusList= [
      ['id' => '0', 'name' => '-Select-'],
      ['id' => '8', 'name' => 'Spot Survey'], 
    ]; 
  $statusArray = ArrayHelper::map($statusList, 'id', 'name');
}
else if($role == 'Superadmin' || $role == 'Admin')
{
    $statusArray = $statusArray +  ['9' => 'Cancelled']; 
}

$vehicleTypeRadioList= [
  ['id' => '', 'name' => 'SELECT'],
  ['id' => 'PVT', 'name' => 'PVT'],
  ['id' => 'TAXI', 'name' => 'TAXI'],
];
$vehicleTypeRadioArray = ArrayHelper::map($vehicleTypeRadioList, 'id', 'name');


$vTypeList= [
  ['id' => '4-WHEELER', 'name' => '4-WHEELER'],
  ['id' => '2-WHEELER', 'name' => '2-WHEELER'],
  ['id' => 'COMMERCIAL', 'name' => 'COMMERCIAL'],
];
$vTypeArray = ArrayHelper::map($vTypeList, 'id', 'name');

$inspectionTypeArray = $premodel->inspectionTypevalue;
$bodyTypeArray = $premodel->bodyTypevalue;
$taxArray = $premodel->taxValue;
$fuelTypeArray = $model->fuelTypevalue;
$fuelTankArray = $model->fuelTankvalue;
$glassTypeArray = $model->glassTypevalue;
$spareTyreArray = $model->spareTyrevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
$damageType5Array = $model->damageType5value;
$licenceTypeArray = $model->licenceTypevalue;
$assestsTypeArray = $model->assestsTypevalue;



//$model->insurerName = Yii::$app->user->identity->companyId;
//$model->insurerDivision = Yii::$app->user->identity->divisionId;
//$model->insurerBranch = Yii::$app->user->identity->branchId;
if($premodel->isNewRecord && ($role == 'Branch Head' || $role == 'Branch Executive'))
{
    $premodel->callerMobileNo = Yii::$app->user->identity->mobile;
    $premodel->callerDetails = Yii::$app->user->identity->email;
}

$companyList =ArrayHelper::map($company,'id','companyName');

$branchList = ArrayHelper::map($branch,'id','branchName');

$divisionList = ArrayHelper::map($division,'id','divisionName');

$callerList = ArrayHelper::map($caller,'id','firstName');

$makeList =ArrayHelper::map($cmodel,'id','make');

$modelList = ArrayHelper::map($vmodel,'id','model');

$variantList = ArrayHelper::map($exmodel,'id','variant');

?>


<div class="axion-preinspection-fourwheelerqc">

    <?php if(isset($_GET['response'])) { echo $_GET['response']; } ?>

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'options' => ['enctype' => 'multipart/form-data'],'enableAjaxValidation'=>true,'validationUrl' => ['axion-claimsurvey/validation','id' =>$premodel->id],]); ?>
    <table class="table" border="2">
    <th>
    <h2 style="text-align: center">CLAIM SURVEY</h2>
     <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Policy, Insurer and Vehicle Particulars</h4>
    <div id="company_details" class="preinspection-box">
    
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'referenceNo')->textInput(['readonly' => true,'maxlength' => true]) ?>
    </div>

     <div class="form-prerow-other">  
    <?= $form->field($premodel, 'intimationDate')->textInput(['readonly' => true,'maxlength' => true]) ?>
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

<?= $form->field($premodel, 'insurerDivision')->dropDownList($divisionList,['id'=>'divisionId']);

    ?>
    </div>
        
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'insurerBranch')->dropDownList($branchList,['id'=>'branchId']);
   
    ?>
    </div>   
    
    <div class="form-prerow-other">

    <?=  $form->field($premodel, 'callerName')->dropDownList($callerList,['id'=>'callerId']);
    
            ?>
    </div>    
        
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'insuredAddress') ?>
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
            <div class="form-prerow-other">
        <?php
     
            echo $form->field($premodel, 'permitType')
        ?>
    </div>
        <div class="form-prerow-other">
    <?= $form->field($premodel, 'policyNo')?>
    </div>
    
      <div class="form-prerow-other">
 
    <?php 

        echo $form->field($premodel, 'policyStartPeriod')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);
    
    ?> 
        
    </div>

    <div class="form-prerow-other">

    <?php 

        echo $form->field($premodel, 'policyEndPeriod')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);
  
    ?>
    </div>
    
    <div class="form-prerow-other">
    <?= $form->field($premodel, 'claimNumber') ?>
    </div>

        <div class="form-prerow-other">
    <?= $form->field($premodel, 'finance')?>
    </div>

    <div class="form-prerow-other">
     <?= $form->field($premodel, 'preAccidentCondition') ?>
    </div>    
    <div class="form-prerow-other">  
        <?= $form->field($premodel, 'passangerCarryCapacity') ?>
    </div>    
        <div class="form-prerow-other">
     <?php 

           echo $form->field($premodel, 'permitNoValidUpto')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]); 
     ?>   
    </div>  

        <div class="form-prerow-other" >     
    <?= $form->field($premodel, 'speedometerReading')->textInput() ?>
    </div> 
      <div class="form-prerow-other" >
     <?= $form->field($premodel, 'registeredLadenWeight') ?> 
    </div>

    
    <div class="form-prerow-other">  
    <?= $form->field($premodel, 'unladenWeight')?>
    </div>  
    
   
    <div class="form-prerow-other">
    <?php 
      
            echo $form->field($premodel, 'fitnessCertificateValidUpto')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,  'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                            ]
                        ]
                ]);
       
    ?>
    </div>    
    <div class="form-prerow-other">
        <?php

            echo $form->field($premodel, 'routeAreaOperation')->textInput(['maxlength' => true]);
        ?>
    </div>
        <div class="form-prerow-other">
        <?php

            echo $form->field($premodel, 'taxType')->dropDownList($taxArray);
        ?>
    </div>
    <div class="form-prerow-other">

         <?= $form->field($premodel, 'taxValidUpto')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?> 
 
    </div>
   
    <div class="form-prerow-other">    
    <?= $form->field($premodel, 'claimVehicle')->textInput(['readonly' => true]); ?>
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
    <?= $form->field($premodel, 'typeOfBody')->dropDownList($bodyTypeArray) ?>
    </div>

     <div class="form-prerow-other">
    <?= $form->field($premodel, 'registrationDate') ?>
    </div>    

    <div class="form-prerow-other">
    <?= $form->field($premodel, 'manufacturingYear') ?>
    </div>
    <?php if(strpos( Yii::$app->request->absoluteUrl, 'test') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) { ?>
     <div class="form-prerow-other">
    <?= $form->field($premodel, 'contactPersonMobileNo')->textInput(['readonly' =>true,'maxlength' => true])->label('Unique Lead Number') ?>
    </div>   
     <?php
    } ?>
    

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
    </th>
      </table>
    
    </div>
   
    
    <div class="clear"></div> 
    
    
    <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Driver's Particulars</h4>
     <div id="inspection_details" class="preinspection-box">
        
          
         <div class="form-prerow-other">     
            <?= $form->field($model, 'driverName') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'drivingLicenceNo') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'dateOfIssue')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'validUpto')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'issuingAuthority') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'typeOfLicence')->dropDownList($licenceTypeArray) ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'badgeNo') ?>
         </div>

     </div>
 </th></table>
     <div class="clear"></div> 
    

    <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Details Of Load Challan</h4>
     <div id="inspection_details" class="preinspection-box">
           <div class="form-prerow-other">     
            <?= $form->field($model, 'number') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'loadDate')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'loadWeight') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'loadFrom') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'loadTo') ?>
         </div>
     </div>
 </th></table>
     <div class="clear"></div> 
    

    <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Accident & Survey Particulars</h4>
     <div id="inspection_details" class="preinspection-box">

           <div class="form-prerow-other" style="width:205px;">     
            <?= $form->field($model, 'dateTimeAccident')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATETIME,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'placeOfAccident') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'placeOfSurvey') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'dateAllotmentOfSurvey')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other" style="width:205px;">     
            <?= $form->field($model, 'dateTimeOfSurvey')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATETIME,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
         <div class="clear"></div>
          <div class="form-prerow-other" style="width:81%;color: red;">     
            <?= $form->field($model, 'causeOfAccident')->textArea(['rows' => '6']); ?>
         </div>


              </div>
 </th></table>
     <div class="clear"></div> 
    

    <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Police Particulars</h4>
     <div id="inspection_details" class="preinspection-box">
           <div class="form-prerow-other"  style="width:305px;">     
            <?= $form->field($model, 'accidentReportedToPolice') ?>
         </div>

        <div class="form-prerow-other">     
            <?= $form->field($model, 'nameOfPoliceStation') ?>
         </div>
           <div class="form-prerow-other">     
            <?= $form->field($model, 'stationDiaryNo') ?>
         </div>
              </div>
 </th></table>
     <div class="clear"></div> 
    

    <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Third Party</h4>
     <div id="inspection_details" class="preinspection-box">
           <div class="form-prerow-other">     
            <?= $form->field($model, 'thirdPartyDetails') ?>
         </div>
           <div class="form-prerow-other"  style="width:305px;">     
            <?= $form->field($model, 'personAvailableAtTimeOfSurvey')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATETIME,  'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                    ]
                ]
        ]) ?>
         </div>
           <div class="form-prerow-other"  style="width:205px;">     
            <?= $form->field($model, 'vehicleRemovedForRepairs') ?>
         </div>


        <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 
      
     
     </div>
      
        </th>  </table>
     </div>



<div class="clear"></div> 


  <table class="table" border="2">
    <th>
<div class="preinspection-box" style="margin-bottom: 30px">

        <div class="row" align="center">
           <h2 class="preinspection-box-title">Assessment</h2> 
         </div>

    <div class="form-group ex3">
          
        <table id="myTable" class="table table-bordered" style="font-size: 13px;">
            <thead>
            <tr>
                <th>#</th>
                <th>Part Type</th>
                <th>PartCode</th>
                <th>PartName</th>
                <th>EstimateAmt</th>
                <th>Billed Amt</th>
                <th>Assessed Amt</th>
                <th>GST(%)</th>
                <th>GST Amt</th>
                <th>Total Amt</th>
                <th>Dep(%)</th>
                <th>Dep Amt</th>
                <th>Net Amt</th>
            </tr>
        </thead>
      <tbody>
             <tr>
                <td id="tablesize" width="1%">1</td>
                <td id="tdsize" width="8%"><?= $form->field($model, 'assestspart')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize" width="6%"><?= $form->field($metalicPart, 'metalicPartCode')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize" width="25%"><?= $form->field($metalicPart, 'partName')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize" width="3%"><?= $form->field($metalicPart, 'estimateAmt')->textInput(['maxlength' => true,'id' => 'est1']) ?></td>
               
                <td id="tdsize" width="5%"><?= $form->field($metalicPart, 'billedAmt')->textInput(['maxlength' => true,'id' => 'bill1']) ?></td>
               
                <td id="tdsize" width="5%"><?= $form->field($metalicPart, 'assessedAmt')->textInput(['maxlength' => true,'id' => 'value1']) ?></td>
               
               <td id="tdsize" width="2%"><?= $form->field($metalicPart, 'gstTax')->textInput(['maxlength' => true,'id' => 'value2']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($metalicPart, 'gstTaxAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($metalicPart, 'totalAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt']) ?></td>
               
                <td id="tdsize" width="2%"><?= $form->field($metalicPart, 'depri')->textInput(['maxlength' => true,'id' => 'dep']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($metalicPart, 'depriAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($metalicPart, 'netAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">2</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart2')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode1')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName1')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt1')->textInput(['maxlength' => true,'id' => 'est2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt1')->textInput(['maxlength' => true,'id' => 'bill2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt1')->textInput(['maxlength' => true,'id' => 'value3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax1')->textInput(['maxlength' => true,'id' => 'value4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum1']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt1']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri1')->textInput(['maxlength' => true,'id' => 'dep1']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt1']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt1']) ?></td>
            </tr>
           <tr>
                <td id="tablesize">3</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart3')->dropDownList($assestsTypeArray) ?></td>
                <td  id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode2')->textInput(['maxlength' => true]) ?></td>
                <td  id="tdsize"><?= $form->field($metalicPart, 'partName2')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt2')->textInput(['maxlength' => true,'id' => 'est3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt2')->textInput(['maxlength' => true,'id' => 'bill3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt2')->textInput(['maxlength' => true,'id' => 'value5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax2')->textInput(['maxlength' => true,'id' => 'value6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri2')->textInput(['maxlength' => true,'id' => 'dep2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt2']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt2']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">4</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart4')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode3')->textInput(['maxlength' => true]) ?></td>
                <td  id="tdsize"><?= $form->field($metalicPart, 'partName3')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt3')->textInput(['maxlength' => true,'id' => 'est4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt3')->textInput(['maxlength' => true,'id' => 'bill4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt3')->textInput(['maxlength' => true,'id' => 'value7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax3')->textInput(['maxlength' => true,'id' => 'value8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt3']) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'depri3')->textInput(['maxlength' => true,'id' => 'dep3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt3']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt3']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">5</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart5')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode4')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName4')->textInput(['maxlength' => true]) ?></td>
               
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt4')->textInput(['maxlength' => true,'id' => 'est5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt4')->textInput(['maxlength' => true,'id' => 'bill5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt4')->textInput(['maxlength' => true,'id' => 'value9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax4')->textInput(['maxlength' => true,'id' => 'value10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri4')->textInput(['maxlength' => true,'id' => 'dep4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt4']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt4']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">6</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart6')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize" ><?= $form->field($metalicPart, 'metalicPartCode5')->textInput(['maxlength' => true]) ?>
                    
                </td>
                <td  id="tdsize"><?= $form->field($metalicPart, 'partName5')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt5')->textInput(['maxlength' => true,'id' => 'est6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt5')->textInput(['maxlength' => true,'id' => 'bill6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt5')->textInput(['maxlength' => true,'id' => 'value11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax5')->textInput(['maxlength' => true,'id' => 'value12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri5')->textInput(['maxlength' => true,'id' => 'dep5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt5']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt5']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">7</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart7')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode6')->textInput(['maxlength' => true]) ?></td>

                <td id="tdsize"><?= $form->field($metalicPart, 'partName6')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt6')->textInput(['maxlength' => true,'id' => 'est7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt6')->textInput(['maxlength' => true,'id' => 'bill7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt6')->textInput(['maxlength' => true,'id' => 'value13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax6')->textInput(['maxlength' => true,'id' => 'value14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri6')->textInput(['maxlength' => true,'id' => 'dep6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt6']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt6']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">8</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart8')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode7')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName7')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt7')->textInput(['maxlength' => true,'id' => 'est8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt7')->textInput(['maxlength' => true,'id' => 'bill8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt7')->textInput(['maxlength' => true,'id' => 'value15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax7')->textInput(['maxlength' => true,'id' => 'value16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri7')->textInput(['maxlength' => true,'id' => 'dep7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt7']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt7']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">9</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart9')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode8')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName8')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt8')->textInput(['maxlength' => true,'id' => 'est9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt8')->textInput(['maxlength' => true,'id' => 'bill9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt8')->textInput(['maxlength' => true,'id' => 'value17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax8')->textInput(['maxlength' => true,'id' => 'value18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri8')->textInput(['maxlength' => true,'id' => 'dep8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt8']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt8']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">10</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart10')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode9')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName9')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt9')->textInput(['maxlength' => true,'id' => 'est10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt9')->textInput(['maxlength' => true,'id' => 'bill10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt9')->textInput(['maxlength' => true,'id' => 'value19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax9')->textInput(['maxlength' => true,'id' => 'value20']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri9')->textInput(['maxlength' => true,'id' => 'dep9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt9']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt9']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">11</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart11')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode10')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName10')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt10')->textInput(['maxlength' => true,'id' => 'est11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt10')->textInput(['maxlength' => true,'id' => 'bill11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt10')->textInput(['maxlength' => true,'id' => 'value21']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax10')->textInput(['maxlength' => true,'id' => 'value22']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt10')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt10')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri10')->textInput(['maxlength' => true,'id' => 'dep10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt10')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt10']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt10')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt10']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">12</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart12')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode11')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName11')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt11')->textInput(['maxlength' => true,'id' => 'est12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt11')->textInput(['maxlength' => true,'id' => 'bill12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt11')->textInput(['maxlength' => true,'id' => 'value23']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax11')->textInput(['maxlength' => true,'id' => 'value24']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt11')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt11')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri11')->textInput(['maxlength' => true,'id' => 'dep11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt11')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt11']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt11')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt11']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">13</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart13')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode12')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName12')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt12')->textInput(['maxlength' => true,'id' => 'est13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt12')->textInput(['maxlength' => true,'id' => 'bill13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt12')->textInput(['maxlength' => true,'id' => 'value25']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax12')->textInput(['maxlength' => true,'id' => 'value26']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt12')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt12')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri12')->textInput(['maxlength' => true,'id' => 'dep12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt12')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt12']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt12')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt12']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">14</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart14')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode13')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName13')->textInput(['maxlength' => true]) ?></td>
               
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt13')->textInput(['maxlength' => true,'id' => 'est14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt13')->textInput(['maxlength' => true,'id' => 'bill14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt13')->textInput(['maxlength' => true,'id' => 'value27']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax13')->textInput(['maxlength' => true,'id' => 'value28']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt13')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt13')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri13')->textInput(['maxlength' => true,'id' => 'dep13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt13')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt13']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt13')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt13']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">15</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart15')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode14')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName14')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt14')->textInput(['maxlength' => true,'id' => 'est15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt14')->textInput(['maxlength' => true,'id' => 'bill15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt14')->textInput(['maxlength' => true,'id' => 'value29']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax14')->textInput(['maxlength' => true,'id' => 'value30']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt14')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt14')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri14')->textInput(['maxlength' => true,'id' => 'dep14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt14')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt14']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt14')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt14']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">16</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart16')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode15')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName15')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt15')->textInput(['maxlength' => true,'id' => 'est16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt15')->textInput(['maxlength' => true,'id' => 'bill16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt15')->textInput(['maxlength' => true,'id' => 'value31']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax15')->textInput(['maxlength' => true,'id' => 'value32']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt15')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt15')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri15')->textInput(['maxlength' => true,'id' => 'dep15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt15')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt15']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt15')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt15']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">17</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart17')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode16')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName16')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt16')->textInput(['maxlength' => true,'id' => 'est17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt16')->textInput(['maxlength' => true,'id' => 'bill17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt16')->textInput(['maxlength' => true,'id' => 'value33']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax16')->textInput(['maxlength' => true,'id' => 'value34']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt16')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt16')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri16')->textInput(['maxlength' => true,'id' => 'dep16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt16')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt16']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt16')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt16']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">18</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart18')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode17')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName17')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt17')->textInput(['maxlength' => true,'id' => 'est18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt17')->textInput(['maxlength' => true,'id' => 'bill18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt17')->textInput(['maxlength' => true,'id' => 'value35']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax17')->textInput(['maxlength' => true,'id' => 'value36']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt17')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt17')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri17')->textInput(['maxlength' => true,'id' => 'dep17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt17')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt17']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt17')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt17']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">19</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart19')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode18')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName18')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt18')->textInput(['maxlength' => true,'id' => 'est19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt18')->textInput(['maxlength' => true,'id' => 'bill19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt18')->textInput(['maxlength' => true,'id' => 'value37']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax18')->textInput(['maxlength' => true,'id' => 'value38']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt18')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt18')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri18')->textInput(['maxlength' => true,'id' => 'dep18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt18')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt18']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt18')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt18']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">20</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart20')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'metalicPartCode19')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'partName19')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($metalicPart, 'estimateAmt19')->textInput(['maxlength' => true,'id' => 'est20']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'billedAmt19')->textInput(['maxlength' => true,'id' => 'bill20']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'assessedAmt19')->textInput(['maxlength' => true,'id' => 'value39']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTax19')->textInput(['maxlength' => true,'id' => 'value40']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'gstTaxAmt19')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'totalAmt19')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depri19')->textInput(['maxlength' => true,'id' => 'dep19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'depriAmt19')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt19']) ?></td>
                <td id="tdsize"><?= $form->field($metalicPart, 'netAmt19')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt19']) ?></td>
            </tr>
            <tr>
                <td id="tablesize" width="1%">21</td>
                <td id="tdsize" width="8%"><?= $form->field($model, 'assestspart21')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize" width="6%"><?= $form->field($labchPart, 'metalicPartCode')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize" width="30%"><?= $form->field($labchPart, 'partName')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize" width="5%"><?= $form->field($labchPart, 'estimateAmt')->textInput(['maxlength' => true,'id' => 'est21']) ?></td>
               
                <td id="tdsize" width="5%"><?= $form->field($labchPart, 'billedAmt')->textInput(['maxlength' => true,'id' => 'bill21']) ?></td>
               
                <td id="tdsize" width="5%"><?= $form->field($labchPart, 'assessedAmt')->textInput(['maxlength' => true,'id' => 'value41']) ?></td>
               
               <td id="tdsize" width="2%"><?= $form->field($labchPart, 'gstTax')->textInput(['maxlength' => true,'id' => 'value42']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($labchPart, 'gstTaxAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum20']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($labchPart, 'totalAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt20']) ?></td>
               
                <td id="tdsize" width="2%"><?= $form->field($labchPart, 'depri')->textInput(['maxlength' => true,'id' => 'dep20']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($labchPart, 'depriAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt20']) ?></td>
               
                <td id="tdsize" width="6%"><?= $form->field($labchPart, 'netAmt')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt20']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">22</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart22')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode1')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'partName1')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt1')->textInput(['maxlength' => true,'id' => 'est22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt1')->textInput(['maxlength' => true,'id' => 'bill22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt1')->textInput(['maxlength' => true,'id' => 'value43']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax1')->textInput(['maxlength' => true,'id' => 'value44']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum21']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt21']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri1')->textInput(['maxlength' => true,'id' => 'dep21']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt21']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt1')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt21']) ?></td>
            </tr>
           <tr>
                <td id="tablesize">23</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart23')->dropDownList($assestsTypeArray) ?></td>
                <td  id="tdsize"><?= $form->field($labchPart, 'metalicPartCode2')->textInput(['maxlength' => true]) ?></td>
                <td  id="tdsize"><?= $form->field($labchPart, 'partName2')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt2')->textInput(['maxlength' => true,'id' => 'est23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt2')->textInput(['maxlength' => true,'id' => 'bill23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt2')->textInput(['maxlength' => true,'id' => 'value45']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax2')->textInput(['maxlength' => true,'id' => 'value46']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri2')->textInput(['maxlength' => true,'id' => 'dep22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt22']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt2')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt22']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">24</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart24')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode3')->textInput(['maxlength' => true]) ?></td>
                <td  id="tdsize"><?= $form->field($labchPart, 'partName3')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt3')->textInput(['maxlength' => true,'id' => 'est24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt3')->textInput(['maxlength' => true,'id' => 'bill24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt3')->textInput(['maxlength' => true,'id' => 'value47']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax3')->textInput(['maxlength' => true,'id' => 'value48']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri3')->textInput(['maxlength' => true,'id' => 'dep23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt23']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt3')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt23']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">25</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart25')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode4')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'partName4')->textInput(['maxlength' => true]) ?></td>
               
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt4')->textInput(['maxlength' => true,'id' => 'est25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt4')->textInput(['maxlength' => true,'id' => 'bill25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt4')->textInput(['maxlength' => true,'id' => 'value49']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax4')->textInput(['maxlength' => true,'id' => 'value50']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri4')->textInput(['maxlength' => true,'id' => 'dep24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt24']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt4')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt24']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">26</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart26')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize" ><?= $form->field($labchPart, 'metalicPartCode5')->textInput(['maxlength' => true]) ?>
                    
                </td>
                <td  id="tdsize"><?= $form->field($labchPart, 'partName5')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt5')->textInput(['maxlength' => true,'id' => 'est26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt5')->textInput(['maxlength' => true,'id' => 'bill26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt5')->textInput(['maxlength' => true,'id' => 'value51']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax5')->textInput(['maxlength' => true,'id' => 'value52']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri5')->textInput(['maxlength' => true,'id' => 'dep25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt25']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt5')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt25']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">27</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart27')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode6')->textInput(['maxlength' => true]) ?></td>

                <td id="tdsize"><?= $form->field($labchPart, 'partName6')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt6')->textInput(['maxlength' => true,'id' => 'est27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt6')->textInput(['maxlength' => true,'id' => 'bill27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt6')->textInput(['maxlength' => true,'id' => 'value53']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax6')->textInput(['maxlength' => true,'id' => 'value54']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri6')->textInput(['maxlength' => true,'id' => 'dep26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt26']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt6')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt26']) ?></td>
            </tr>
             <tr>
                <td id="tablesize">28</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart28')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode7')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'partName7')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt7')->textInput(['maxlength' => true,'id' => 'est28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt7')->textInput(['maxlength' => true,'id' => 'bill28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt7')->textInput(['maxlength' => true,'id' => 'value55']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax7')->textInput(['maxlength' => true,'id' => 'value56']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri7')->textInput(['maxlength' => true,'id' => 'dep27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt27']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt7')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt27']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">29</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart29')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode8')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'partName8')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt8')->textInput(['maxlength' => true,'id' => 'est29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt8')->textInput(['maxlength' => true,'id' => 'bill29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt8')->textInput(['maxlength' => true,'id' => 'value57']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax8')->textInput(['maxlength' => true,'id' => 'value58']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri8')->textInput(['maxlength' => true,'id' => 'dep28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt28']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt8')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt28']) ?></td>
            </tr>
            <tr>
                <td id="tablesize">30</td>
                <td id="tdsize"><?= $form->field($model, 'assestspart30')->dropDownList($assestsTypeArray) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'metalicPartCode9')->textInput(['maxlength' => true]) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'partName9')->textInput(['maxlength' => true]) ?></td>
                
                <td id="tdsize"><?= $form->field($labchPart, 'estimateAmt9')->textInput(['maxlength' => true,'id' => 'est30']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'billedAmt9')->textInput(['maxlength' => true,'id' => 'bill30']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'assessedAmt9')->textInput(['maxlength' => true,'id' => 'value59']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTax9')->textInput(['maxlength' => true,'id' => 'value60']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'gstTaxAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'sum29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'totalAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstamt29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depri9')->textInput(['maxlength' => true,'id' => 'dep29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'depriAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depriamt29']) ?></td>
                <td id="tdsize"><?= $form->field($labchPart, 'netAmt9')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netamt29']) ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right">TOTAL</td>
                <td id="tdsize"><?= $form->field($model, 'estTotal')->textInput(['maxlength' => true,'id' => 'grandest']) ?></td>
                <td id="tdsize"><?= $form->field($model, 'billTotal')->textInput(['maxlength' => true,'id' => 'grandbill']) ?></td>
                <td id="tdsize"><?= $form->field($model, 'assestTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'total_sum_value']) ?></td>
                <td id="tdsize"></td>
                <td id="tdsize"><?= $form->field($model, 'gstcalTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstcalval']) ?></td>
                <td id="tdsize"><?= $form->field($model, 'gstTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'gstval']) ?></td>
                <td id="tdsize"></td>
                <td id="tdsize"><?= $form->field($model, 'depTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'depval']) ?></td>
                <td id="tdsize"><?= $form->field($model, 'netTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'netval','style' => 'background-color:#00FF00;']) ?></td>
            </tr>
            <tr>
                <td colspan="12" align="right">COMPULSORY EXCESS Rs.</td>
                <td id="tdsize"><?= $form->field($model, 'compEx')->textInput(['maxlength' => true,'id' => 'exval1']) ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">IMPOSED EXCESS Rs.</td>
                <td id="tdsize"><?= $form->field($model, 'imposEx')->textInput(['maxlength' => true,'id' => 'exval2']) ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">SALVAGE AMOUNT Rs.</td>
                <td id="tdsize"><?= $form->field($model, 'salvEx')->textInput(['maxlength' => true,'id' => 'exval3']) ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">NCB RECOVERY Rs.</td>
                <td id="tdsize"><?= $form->field($model, 'ncbEx')->textInput(['maxlength' => true,'id' => 'exval4']) ?></td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
                <td id="tdsize" ><?= $form->field($model, 'exTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'extotalval']) ?></td>
            </tr>
             <tr>
                <td colspan="6" align="right">INSURER'S APPROXIMATE LIABLITY</td>
                <td id="tdsize" colspan="2">Rs.<?= $form->field($model, 'insurerTotal')->textInput(['readonly' => true,'maxlength' => true,'id' => 'grandtotal','style' => 'background-color:yellow;']) ?></td>
                <td colspan="5"></td>
            </tr>
           
           
            <?php if (! $metalicPart->isNewRecord) { echo Html::activeHiddenInput($metalicPart, "preinspection_id");}?>
           </tfoot>
        </table>
    </div>
    </div>
 </th></table>


<div class="clear"></div>

<?php

$url = YII::$app->request->baseUrl.'/axion-claimsurvey/Fourwheelerqc';

$script = <<< JS
$(document).ready(function(){
        var i = 1;
        $('#add').click(function(){
          i++;
          $('#dynamic_field').append('<tr id="row'+i+'"><td width="2%"><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td><td><input type="text" name="assessment[{'+i+'}]" id="assessment" class="form-control name_list" /></td><td><input type="text" name="estimateAmount[{'+i+'}]" id="estimateAmount" class="form-control name_list" /></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
        });
        
        $('#submit').click(function(){
           $.ajax({
                 url:'$url',
                 method:'POST',
                 data:$('#add_name').serialize(),
                 success:function(data)
                 {
                    alert(data);
                    $('#add_name')[0].reset();

                 }
           });
        });
    });

JS;
$this->registerJS($script);
?>


<div class="clear"></div> 
      <table class="table" border="2">
    <th>
<div class="preinspection-box"><h2 class="preinspection-box-title" style="text-align: center;">Bill</h2> 
 <table class="table table-bordered">
        <div class="container">

          
     <tr>
             
               <tr>
                 <th style="width: 1px; text-align: center; color: black;" >SL.NO</th>
                 <th style="text-align: center; color: black;" >PARTICULARS</th>
                 <th style="text-align: center; color: black;" >AMOUNT</th>
             </tr><tr>
                <td>1</td>
                <td>
                <?= $form->field($bill, 'particular1')->textInput(['maxlength' => true]) ?>
                </td>
                <td style="width:305px;">
                <?= $form->field($bill, 'particularAmount1')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>2</td>
                  <td>
                <?= $form->field($bill, 'particular2')->textInput(['maxlength' => true]) ?>
                </td>
                 <td>
                <?= $form->field($bill, 'particularAmount2')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>3</td>
                <td>
                <?= $form->field($bill, 'particular3')->textInput(['maxlength' => true]) ?>
                </td>
                 <td>
                <?= $form->field($bill, 'particularAmount3')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>4</td>
                 <td>
                <?= $form->field($bill, 'particular4')->textInput(['maxlength' => true]) ?>
                </td>  
                 <td>
                <?= $form->field($bill, 'particularAmount4')->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
            
            <tr>
                <td>5</td>
                <td>
                <?= $form->field($bill, 'particular5')->textInput(['maxlength' => true]) ?>
                </td>
                <td style="width:305px;">
                <?= $form->field($bill, 'particularAmount5')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>6</td>
                  <td>
                <?= $form->field($bill, 'particular6')->textInput(['maxlength' => true]) ?>
                </td>
                 <td>
                <?= $form->field($bill, 'particularAmount6')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>7</td>
                <td>
                <?= $form->field($bill, 'particular7')->textInput(['maxlength' => true]) ?>
                </td>
                 <td>
                <?= $form->field($bill, 'particularAmount7')->textInput(['maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td>8</td>
                 <td>
                <?= $form->field($bill, 'particular8')->textInput(['maxlength' => true]) ?>
                </td>  
                 <td>
                <?= $form->field($bill, 'particularAmount8')->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
            
            <tr>
                <td></td>
                <td align="right">Total.....................</td>
                <td>
                <?= $form->field($bill, 'total')->textInput(['readonly' => true,'maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td></td>
                <td>SGST@9%</td>
                <td>
                <?= $form->field($bill, 'sgst')->textInput(['readonly' => true,'maxlength' => true]) ?>
                </td>
            </tr><tr>
                <td></td>
                <td>CGST@9%</td>
                <td>
                <?= $form->field($bill, 'cgst')->textInput(['type' => 'number','readonly' => true,'maxlength' => true]) ?>
                </td>
            </tr><tr>
            <td></td>
            <td align="right">Rounded off to........................</td>
                <td>
                <?= $form->field($bill, 'roundedOffTo')->textInput(['readonly' => true,'maxlength' => true]) ?>
                </td>
            </tr>
                
    <?php if (! $bill->isNewRecord) { echo Html::activeHiddenInput($bill, "preinspection_id");}?>               
            </tr>
    
 </div>
 </th></table></div>
 </th></table>

     <div class="clear"></div> 

    <table class="table" border="2">
    <th>
    <?php if($premodel->surveyorName == 0 ) { ?>

    <h4 class="preinspection-box-title">Video Session</h4>
    <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px; text-align: center">

    <?php if($customerSession) { 
        ?>
            <?= Html::a('Video Session', ['video-requests/startsession', 'sessionid' => $customerSession->securitykey], ['class' => 'btn btn-primary']) ?>
           <?php 
        } else{ 
            if($role != '')
            {
            ?>
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Create Customer Video Session', ['class' => 'btn btn-primary', 'value'=>'create_session', 'name'=>'create_session']) ?>
        </div>
        <?php } 
            
            }   ?>
     </div>
    <?php  }   ?>
    </th>
            </table>
     <div class="clear"></div>
     
        <table class="table" border="2">
         <th>
     <h4 class="preinspection-box-title">Take Photos</h4>
     <div class="row">&nbsp;</div>
     <input type="hidden" name="" id="photoType">
     

        <?php
        

         foreach($phmodel as $obj)
          { 
            $csqcLoc = \Yii::$app->params['csqcLoc'];
            if($obj->image!= '')
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($csqcLoc.$obj->image);
            else
            $imgUrl = '';    
            ?>
             <div class="btn btn-primary cm-<?php echo $obj->type; ?>" style="width: 200px;">Upload <?php echo $obj->type; ?></div>
             <img src="<?php echo $imgUrl; ?>" id="<?php echo $obj->type; ?>" />   
             <?= Html::a('Remove', '#', ['class' => 'btn btn-primary remove-image', 'id'=>''.$obj->id.'']) ?>
             <div class="clear" style="margin: 10px;"></div> 
             <hr>

             <?php }  ?>
             </th>
            </table>
    
    <div class="clear"></div> 
     
     
     
  <?php //if($role == 'Superadmin' || $role == 'Admin' || $role == 'BO User') { ?>
        <table class="table" border="2">
         <th>
        <h4 class="preinspection-box-title">Image Upload</h4>

        

        <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">

        <?php  
        foreach($phmodel as $obj)
        {   
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($csqcLoc.$obj->image);
          
            echo '<div class="form-prerow-image">';echo $obj->type;
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */  
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-claimsurvey/image-uploadbrowse']),
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
                                'url'=> Url::to(['/axion-claimsurvey/remove-photobrowse']),
                                'key'=> $obj->id,
                            ],

                        ],         
                    ],
            ]);
            
           
            
            echo '</div>';
            echo '<div class="clear"></div>';

        }
       
        ?>

     </div>
    <div class="clear"></div> 

    <?php// } ?>
    
   
    
    
    </th></table>


     </th></table>
    <div class="clear"></div>
    <?php  echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>
    
    <?php  echo Html::hiddenInput('bLong','' , ['id' => 'bLong']); ?>    

    <div class="form-group" style="text-align: center;margin-top: 30px;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
           <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?>-->
        
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-claimsurvey/fourwheelerpdf?id='.$premodel->id], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
        ]);} ?>
        <?php if($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) { echo Html::a('Download Photos', ['/axion-claimsurvey/downloadphotos?id='.$premodel->id], [
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
        '".Yii::$app->request->baseUrl."/axion-claimsurvey/remove-photo', 
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
   
   $(function(){
            $('#value1, #value2').blur(function(){
               var value1 = parseFloat($('#value1').val()) || 0;
               var value2 = parseFloat($('#value2').val()) || 0;
               var sum = (value1 / 100) * value2;
               var gst = value1 + sum;
              // alert(gst);
               $('#sum').val(sum);
               if(gst!=''){
                $('#gstamt').val(gst);
               }
               
            });
                $('#dep').blur(function(){
                    var dep = $('#dep').val();
                    var tot_amount = $('#gstamt').val();
                    var final = (tot_amount / 100) * dep;
                    $('#depriamt').val(final);
                    var depri = $('#depriamt').val();
                    var net = parseFloat(tot_amount - depri);
                    $('#netamt').val(net);

                });
         
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

#twowheel{
    display:none;
}

#fourwheel{
    display: none;
}

div.ex3 {
  width: 100%;
  height: 510px;
  overflow: auto;
}

#tablesize{
    width: 1;
}

#tdsize{
     padding: 0;
    padding-left: 0; 
     padding-right: 0; 
      padding-top: 0;
       padding-bottom: 0;
       height: 0px; 
       border: 0px; 
       font-size: 0px;   
}


CSS;
 $this->registerCss($style);
 ?>

<?php

$this->registerJs("
    $(function(){
            $('#value3, #value4').blur(function(){
               var value3 = parseFloat($('#value3').val()) || 0;
               var value4 = parseFloat($('#value4').val()) || 0;
               var sum1 = (value3 / 100) * value4;
               var gst1 = value3 + sum1;
              // alert(gst);
               $('#sum1').val(sum1);
               if(gst1!=''){
                $('#gstamt1').val(gst1);
               }
            });
            $('#dep1').blur(function(){
                    var dep1 = $('#dep1').val();
                    var tot_amount1 = $('#gstamt1').val();
                    var final1 = (tot_amount1 / 100) * dep1;
                    $('#depriamt1').val(final1);
                    var depri1 = $('#depriamt1').val();
                    var net1 = parseFloat(tot_amount1 - depri1);
                    $('#netamt1').val(net1);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value5, #value6').blur(function(){
               var value5 = parseFloat($('#value5').val()) || 0;
               var value6 = parseFloat($('#value6').val()) || 0;
               var sum2 = (value5 / 100) * value6;
               var gst2 = value5 + sum2;
              // alert(gst);
               $('#sum2').val(sum2);
               if(gst2!=''){
                $('#gstamt2').val(gst2);
               }
            });
            $('#dep2').blur(function(){
                    var dep2 = $('#dep2').val();
                    var tot_amount2 = $('#gstamt2').val();
                    var final2 = (tot_amount2 / 100) * dep2;
                    $('#depriamt2').val(final2);
                    var depri2 = $('#depriamt2').val();
                    var net2 = parseFloat(tot_amount2 - depri2);
                    $('#netamt2').val(net2);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value7, #value8').blur(function(){
               var value7 = parseFloat($('#value7').val()) || 0;
               var value8 = parseFloat($('#value8').val()) || 0;
               var sum3 = (value7 / 100) * value8;
               var gst3 = value7 + sum3;
              // alert(gst);
               $('#sum3').val(sum3);
               if(gst3!=''){
                $('#gstamt3').val(gst3);
               }
            });
            $('#dep3').blur(function(){
                    var dep3 = $('#dep3').val();
                    var tot_amount3 = $('#gstamt3').val();
                    var final3 = (tot_amount3 / 100) * dep3;
                    $('#depriamt3').val(final3);
                    var depri3 = $('#depriamt3').val();
                    var net3 = parseFloat(tot_amount3 - depri3);
                    $('#netamt3').val(net3);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value9, #value10').blur(function(){
               var value9 = parseFloat($('#value9').val()) || 0;
               var value10 = parseFloat($('#value10').val()) || 0;
               var sum4 = (value9 / 100) * value10;
               var gst4 = value9 + sum4;
              // alert(gst);
               $('#sum4').val(sum4);
               if(gst4!=''){
                $('#gstamt4').val(gst4);
               }
            });
            $('#dep4').blur(function(){
                    var dep4 = $('#dep4').val();
                    var tot_amount4 = $('#gstamt4').val();
                    var final4 = (tot_amount4 / 100) * dep4;
                    $('#depriamt4').val(final4);
                    var depri4 = $('#depriamt4').val();
                    var net4 = parseFloat(tot_amount4 - depri4);
                    $('#netamt4').val(net4);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value11, #value12').blur(function(){
               var value11 = parseFloat($('#value11').val()) || 0;
               var value12 = parseFloat($('#value12').val()) || 0;
               var sum5 = (value11 / 100) * value12;
               var gst5 = value11 + sum5;
              // alert(gst);
               $('#sum5').val(sum5);
               if(gst5!=''){
                $('#gstamt5').val(gst5);
               }
            });
            $('#dep5').blur(function(){
                    var dep5 = $('#dep5').val();
                    var tot_amount5 = $('#gstamt5').val();
                    var final5 = (tot_amount5 / 100) * dep5;
                    $('#depriamt5').val(final5);
                    var depri5 = $('#depriamt5').val();
                    var net5 = parseFloat(tot_amount5 - depri5);
                    $('#netamt5').val(net5);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value13, #value14').blur(function(){
               var value13 = parseFloat($('#value13').val()) || 0;
               var value14 = parseFloat($('#value14').val()) || 0;
               var sum6 = (value13 / 100) * value14;
               var gst6 = value13 + sum6;
              // alert(gst);
               $('#sum6').val(sum6);
               if(gst6!=''){
                $('#gstamt6').val(gst6);
               }
            });
            $('#dep6').blur(function(){
                    var dep6 = $('#dep6').val();
                    var tot_amount6 = $('#gstamt6').val();
                    var final6 = (tot_amount6 / 100) * dep6;
                    $('#depriamt6').val(final6);
                    var depri6 = $('#depriamt6').val();
                    var net6 = parseFloat(tot_amount6 - depri6);
                    $('#netamt6').val(net6);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value15, #value16').blur(function(){
               var value15 = parseFloat($('#value15').val()) || 0;
               var value16 = parseFloat($('#value16').val()) || 0;
               var sum7 = (value15 / 100) * value16;
               var gst7 = value15 + sum7;
              // alert(gst);
               $('#sum7').val(sum7);
               if(gst7!=''){
                $('#gstamt7').val(gst7);
               }
            });
            $('#dep7').blur(function(){
                    var dep7 = $('#dep7').val();
                    var tot_amount7 = $('#gstamt7').val();
                    var final7 = (tot_amount7 / 100) * dep7;
                    $('#depriamt7').val(final7);
                    var depri7 = $('#depriamt7').val();
                    var net7 = parseFloat(tot_amount7 - depri7);
                    $('#netamt7').val(net7);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value17, #value18').blur(function(){
               var value17 = parseFloat($('#value17').val()) || 0;
               var value18 = parseFloat($('#value18').val()) || 0;
               var sum8 = (value17 / 100) * value18;
               var gst8 = value17 + sum8;
              // alert(gst);
               $('#sum8').val(sum8);
               if(gst8!=''){
                $('#gstamt8').val(gst8);
               }
            });
            $('#dep8').blur(function(){
                    var dep8 = $('#dep8').val();
                    var tot_amount8 = $('#gstamt8').val();
                    var final8 = (tot_amount8 / 100) * dep8;
                    $('#depriamt8').val(final8);
                    var depri8 = $('#depriamt8').val();
                    var net8 = parseFloat(tot_amount8 - depri8);
                    $('#netamt8').val(net8);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value19, #value20').blur(function(){
               var value19 = parseFloat($('#value19').val()) || 0;
               var value20 = parseFloat($('#value20').val()) || 0;
               var sum9 = (value19 / 100) * value20;
               var gst9 = value19 + sum9;
              // alert(gst);
               $('#sum9').val(sum9);
               if(gst9!=''){
                $('#gstamt9').val(gst9);
               }
            });
            $('#dep9').blur(function(){
                    var dep9 = $('#dep9').val();
                    var tot_amount9 = $('#gstamt9').val();
                    var final9 = (tot_amount9 / 100) * dep9;
                    $('#depriamt9').val(final9);
                    var depri9 = $('#depriamt9').val();
                    var net9 = parseFloat(tot_amount9 - depri9);
                    $('#netamt9').val(net9);

                });

            });
    ");

?>


<?php

$this->registerJs("
    $(function(){
            $('#value21, #value22').blur(function(){
               var value21 = parseFloat($('#value21').val()) || 0;
               var value22 = parseFloat($('#value22').val()) || 0;
               var sum10 = (value21 / 100) * value22;
               var gst10 = value21 + sum10;
              // alert(gst);
               $('#sum10').val(sum10);
               if(gst10!=''){
                $('#gstamt10').val(gst10);
               }
            });
            $('#dep10').blur(function(){
                    var dep10 = $('#dep10').val();
                    var tot_amount10 = $('#gstamt10').val();
                    var final10 = (tot_amount10 / 100) * dep10;
                    $('#depriamt10').val(final10);
                    var depri10 = $('#depriamt10').val();
                    var net10 = parseFloat(tot_amount10 - depri10);
                    $('#netamt10').val(net10);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value23, #value24').blur(function(){
               var value23 = parseFloat($('#value23').val()) || 0;
               var value24 = parseFloat($('#value24').val()) || 0;
               var sum11 = (value23 / 100) * value24;
               var gst11 = value23 + sum11;
              // alert(gst);
               $('#sum11').val(sum11);
               if(gst11!=''){
                $('#gstamt11').val(gst11);
               }
            });
            $('#dep11').blur(function(){
                    var dep11 = $('#dep11').val();
                    var tot_amount11 = $('#gstamt11').val();
                    var final11 = (tot_amount11 / 100) * dep11;
                    $('#depriamt11').val(final11);
                    var depri11 = $('#depriamt11').val();
                    var net11 = parseFloat(tot_amount11 - depri11);
                    $('#netamt11').val(net11);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value25, #value26').blur(function(){
               var value25 = parseFloat($('#value25').val()) || 0;
               var value26 = parseFloat($('#value26').val()) || 0;
               var sum12 = (value25 / 100) * value26;
               var gst12 = value25 + sum12;
              // alert(gst);
               $('#sum12').val(sum12);
               if(gst12!=''){
                $('#gstamt12').val(gst12);
               }
            });
            $('#dep12').blur(function(){
                    var dep12 = $('#dep12').val();
                    var tot_amount12 = $('#gstamt12').val();
                    var final12 = (tot_amount12 / 100) * dep12;
                    $('#depriamt12').val(final12);
                    var depri12 = $('#depriamt12').val();
                    var net12 = parseFloat(tot_amount12 - depri12);
                    $('#netamt12').val(net12);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value27, #value28').blur(function(){
               var value27 = parseFloat($('#value27').val()) || 0;
               var value28 = parseFloat($('#value28').val()) || 0;
               var sum13 = (value27 / 100) * value28;
               var gst13 = value27 + sum13;
              // alert(gst);
               $('#sum13').val(sum13);
               if(gst13!=''){
                $('#gstamt13').val(gst13);
               }
            });
            $('#dep13').blur(function(){
                    var dep13 = $('#dep13').val();
                    var tot_amount13 = $('#gstamt13').val();
                    var final13 = (tot_amount13 / 100) * dep13;
                    $('#depriamt13').val(final13);
                    var depri13 = $('#depriamt13').val();
                    var net13 = parseFloat(tot_amount13 - depri13);
                    $('#netamt13').val(net13);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value29, #value30').blur(function(){
               var value29 = parseFloat($('#value29').val()) || 0;
               var value30 = parseFloat($('#value30').val()) || 0;
               var sum14 = (value29 / 100) * value30;
               var gst14 = value29 + sum14;
              // alert(gst);
               $('#sum14').val(sum14);
               if(gst14!=''){
                $('#gstamt14').val(gst14);
               }
            });
            $('#dep14').blur(function(){
                    var dep14 = $('#dep14').val();
                    var tot_amount14 = $('#gstamt14').val();
                    var final14 = (tot_amount14 / 100) * dep14;
                    $('#depriamt14').val(final14);
                    var depri14 = $('#depriamt14').val();
                    var net14 = parseFloat(tot_amount14 - depri14);
                    $('#netamt14').val(net14);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value31, #value32').blur(function(){
               var value31 = parseFloat($('#value31').val()) || 0;
               var value32 = parseFloat($('#value32').val()) || 0;
               var sum15 = (value31 / 100) * value32;
               var gst15 = value31 + sum15;
              // alert(gst);
               $('#sum15').val(sum15);
               if(gst15!=''){
                $('#gstamt15').val(gst15);
               }
            });
            $('#dep15').blur(function(){
                    var dep15 = $('#dep15').val();
                    var tot_amount15 = $('#gstamt15').val();
                    var final15 = (tot_amount15 / 100) * dep15;
                    $('#depriamt15').val(final15);
                    var depri15 = $('#depriamt15').val();
                    var net15 = parseFloat(tot_amount15 - depri15);
                    $('#netamt15').val(net15);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value33, #value34').blur(function(){
               var value33 = parseFloat($('#value33').val()) || 0;
               var value34 = parseFloat($('#value34').val()) || 0;
               var sum16 = (value33 / 100) * value34;
               var gst16 = value33 + sum16;
              // alert(gst);
               $('#sum16').val(sum16);
               if(gst16!=''){
                $('#gstamt16').val(gst16);
               }
            });
            $('#dep16').blur(function(){
                    var dep16 = $('#dep16').val();
                    var tot_amount16 = $('#gstamt16').val();
                    var final16 = (tot_amount16 / 100) * dep16;
                    $('#depriamt16').val(final16);
                    var depri16 = $('#depriamt16').val();
                    var net16 = parseFloat(tot_amount16 - depri16);
                    $('#netamt16').val(net16);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value35, #value36').blur(function(){
               var value35 = parseFloat($('#value35').val()) || 0;
               var value36 = parseFloat($('#value36').val()) || 0;
               var sum17 = (value35 / 100) * value36;
               var gst17 = value35 + sum17;
              // alert(gst);
               $('#sum17').val(sum17);
               if(gst17!=''){
                $('#gstamt17').val(gst17);
               }
            });
            $('#dep17').blur(function(){
                    var dep17 = $('#dep17').val();
                    var tot_amount17 = $('#gstamt17').val();
                    var final17 = (tot_amount17 / 100) * dep17;
                    $('#depriamt17').val(final17);
                    var depri17 = $('#depriamt17').val();
                    var net17 = parseFloat(tot_amount17 - depri17);
                    $('#netamt17').val(net17);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value37, #value38').blur(function(){
               var value37 = parseFloat($('#value37').val()) || 0;
               var value38 = parseFloat($('#value38').val()) || 0;
               var sum18 = (value37 / 100) * value38;
               var gst18 = value37 + sum18;
              // alert(gst);
               $('#sum18').val(sum18);
               if(gst18!=''){
                $('#gstamt18').val(gst18);
               }
            });
            $('#dep18').blur(function(){
                    var dep18 = $('#dep18').val();
                    var tot_amount18 = $('#gstamt18').val();
                    var final18 = (tot_amount18 / 100) * dep18;
                    $('#depriamt18').val(final18);
                    var depri18 = $('#depriamt18').val();
                    var net18 = parseFloat(tot_amount18 - depri18);
                    $('#netamt18').val(net18);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value39, #value40').blur(function(){
               var value39 = parseFloat($('#value39').val()) || 0;
               var value40 = parseFloat($('#value40').val()) || 0;
               var sum19 = (value39 / 100) * value40;
               var gst19 = value39 + sum19;
              // alert(gst);
               $('#sum19').val(sum19);
               if(gst19!=''){
                $('#gstamt19').val(gst19);
               }
            });
            $('#dep19').blur(function(){
                    var dep19 = $('#dep19').val();
                    var tot_amount19 = $('#gstamt19').val();
                    var final19 = (tot_amount19 / 100) * dep19;
                    $('#depriamt19').val(final19);
                    var depri19 = $('#depriamt19').val();
                    var net19 = parseFloat(tot_amount19 - depri19);
                    $('#netamt19').val(net19);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value41, #value42').blur(function(){
               var value41 = parseFloat($('#value41').val()) || 0;
               var value42 = parseFloat($('#value42').val()) || 0;
               var sum20 = (value41 / 100) * value42;
               var gst20 = value41 + sum20;
              // alert(gst);
               $('#sum20').val(sum20);
               if(gst20!=''){
                $('#gstamt20').val(gst20);
               }
            });
            $('#dep20').blur(function(){
                    var dep20 = $('#dep20').val();
                    var tot_amount20 = $('#gstamt20').val();
                    var final20 = (tot_amount20 / 100) * dep20;
                    $('#depriamt20').val(final20);
                    var depri20 = $('#depriamt20').val();
                    var net20 = parseFloat(tot_amount20 - depri20);
                    $('#netamt20').val(net20);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value43, #value44').blur(function(){
               var value43 = parseFloat($('#value43').val()) || 0;
               var value44 = parseFloat($('#value44').val()) || 0;
               var sum21 = (value43 / 100) * value44;
               var gst21 = value43 + sum21;
              // alert(gst);
               $('#sum21').val(sum21);
               if(gst21!=''){
                $('#gstamt21').val(gst21);
               }
            });
            $('#dep21').blur(function(){
                    var dep21 = $('#dep21').val();
                    var tot_amount21 = $('#gstamt21').val();
                    var final21 = (tot_amount21 / 100) * dep21;
                    $('#depriamt21').val(final21);
                    var depri21 = $('#depriamt21').val();
                    var net21 = parseFloat(tot_amount21 - depri21);
                    $('#netamt21').val(net21);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){
            $('#value45, #value46').blur(function(){
               var value45 = parseFloat($('#value45').val()) || 0;
               var value46 = parseFloat($('#value46').val()) || 0;
               var sum22 = (value45 / 100) * value46;
               var gst22 = value45 + sum22;
              // alert(gst);
               $('#sum22').val(sum22);
               if(gst22!=''){
                $('#gstamt22').val(gst22);
               }
            });
            $('#dep22').blur(function(){
                    var dep22 = $('#dep22').val();
                    var tot_amount22 = $('#gstamt22').val();
                    var final22 = (tot_amount22 / 100) * dep22;
                    $('#depriamt22').val(final22);
                    var depri22 = $('#depriamt22').val();
                    var net22 = parseFloat(tot_amount22 - depri22);
                    $('#netamt22').val(net22);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value47, #value48').blur(function(){
               var value47 = parseFloat($('#value47').val()) || 0;
               var value48 = parseFloat($('#value48').val()) || 0;
               var sum23 = (value47 / 100) * value48;
               var gst23 = value47 + sum23;
              // alert(gst);
               $('#sum23').val(sum23);
               if(gst23!=''){
                $('#gstamt23').val(gst23);
               }
            });
            $('#dep23').blur(function(){
                    var dep23 = $('#dep23').val();
                    var tot_amount23 = $('#gstamt23').val();
                    var final23 = (tot_amount23 / 100) * dep23;
                    $('#depriamt23').val(final23);
                    var depri23 = $('#depriamt23').val();
                    var net23 = parseFloat(tot_amount23 - depri23);
                    $('#netamt23').val(net23);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value49, #value50').blur(function(){
               var value49 = parseFloat($('#value49').val()) || 0;
               var value50 = parseFloat($('#value50').val()) || 0;
               var sum24 = (value49 / 100) * value50;
               var gst24 = value49 + sum24;
              // alert(gst);
               $('#sum24').val(sum24);
               if(gst24!=''){
                $('#gstamt24').val(gst24);
               }
            });
            $('#dep24').blur(function(){
                    var dep24 = $('#dep24').val();
                    var tot_amount24 = $('#gstamt24').val();
                    var final24 = (tot_amount24 / 100) * dep24;
                    $('#depriamt24').val(final24);
                    var depri24 = $('#depriamt24').val();
                    var net24 = parseFloat(tot_amount24 - depri24);
                    $('#netamt24').val(net24);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value51, #value52').blur(function(){
               var value51 = parseFloat($('#value51').val()) || 0;
               var value52 = parseFloat($('#value52').val()) || 0;
               var sum25 = (value51 / 100) * value52;
               var gst25 = value51 + sum25;
              // alert(gst);
               $('#sum25').val(sum25);
               if(gst25!=''){
                $('#gstamt25').val(gst25);
               }
            });
            $('#dep25').blur(function(){
                    var dep25 = $('#dep25').val();
                    var tot_amount25 = $('#gstamt25').val();
                    var final25 = (tot_amount25 / 100) * dep25;
                    $('#depriamt25').val(final25);
                    var depri25 = $('#depriamt25').val();
                    var net25 = parseFloat(tot_amount25 - depri25);
                    $('#netamt25').val(net25);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value53, #value54').blur(function(){
               var value53 = parseFloat($('#value53').val()) || 0;
               var value54 = parseFloat($('#value54').val()) || 0;
               var sum26 = (value53 / 100) * value54;
               var gst26 = value53 + sum26;
              // alert(gst);
               $('#sum26').val(sum26);
               if(gst26!=''){
                $('#gstamt26').val(gst26);
               }
            });
            $('#dep26').blur(function(){
                    var dep26 = $('#dep26').val();
                    var tot_amount26 = $('#gstamt26').val();
                    var final26 = (tot_amount26 / 100) * dep26;
                    $('#depriamt26').val(final26);
                    var depri26 = $('#depriamt26').val();
                    var net26 = parseFloat(tot_amount26 - depri26);
                    $('#netamt26').val(net26);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value55, #value56').blur(function(){
               var value55 = parseFloat($('#value55').val()) || 0;
               var value56 = parseFloat($('#value56').val()) || 0;
               var sum27 = (value55 / 100) * value56;
               var gst27 = value55 + sum27;
              // alert(gst);
               $('#sum27').val(sum27);
               if(gst27!=''){
                $('#gstamt27').val(gst27);
               }
            });
            $('#dep27').blur(function(){
                    var dep27 = $('#dep27').val();
                    var tot_amount27 = $('#gstamt27').val();
                    var final27 = (tot_amount27 / 100) * dep27;
                    $('#depriamt27').val(final27);
                    var depri27 = $('#depriamt27').val();
                    var net27 = parseFloat(tot_amount27 - depri27);
                    $('#netamt27').val(net27);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value57, #value58').blur(function(){
               var value57 = parseFloat($('#value57').val()) || 0;
               var value58 = parseFloat($('#value58').val()) || 0;
               var sum28 = (value57 / 100) * value58;
               var gst28 = value57 + sum28;
              // alert(gst);
               $('#sum28').val(sum28);
               if(gst28!=''){
                $('#gstamt28').val(gst28);
               }
            });
            $('#dep28').blur(function(){
                    var dep28 = $('#dep28').val();
                    var tot_amount28 = $('#gstamt28').val();
                    var final28 = (tot_amount28 / 100) * dep28;
                    $('#depriamt28').val(final28);
                    var depri28 = $('#depriamt28').val();
                    var net28 = parseFloat(tot_amount28 - depri28);
                    $('#netamt28').val(net28);

                });

            });
    ");

?>
<?php

$this->registerJs("
    $(function(){
            $('#value59, #value60').blur(function(){
               var value59 = parseFloat($('#value59').val()) || 0;
               var value60 = parseFloat($('#value60').val()) || 0;
               var sum29 = (value59 / 100) * value60;
               var gst29 = value59 + sum29;
              // alert(gst);
               $('#sum29').val(sum29);
               if(gst29!=''){
                $('#gstamt29').val(gst29);
               }
            });
            $('#dep29').blur(function(){
                    var dep29 = $('#dep29').val();
                    var tot_amount29 = $('#gstamt29').val();
                    var final29 = (tot_amount29 / 100) * dep29;
                    $('#depriamt29').val(final29);
                    var depri29 = $('#depriamt29').val();
                    var net29 = parseFloat(tot_amount29 - depri29);
                   
                    $('#netamt29').val(net29);

                });

            });
    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#est1, #est2, #est3, #est4, #est5, #est6, #est7, #est8, #est9, #est10, #est11, #est12, #est13, #est14, #est15, #est16, #est17, #est18, #est19, #est20, #est21, #est22, #est23, #est24, #est25, #est26, #est27, #est28, #est29, #est30').blur(function(){

        var est1 = parseFloat($('#est1').val()) || 0;
        var est2 = parseFloat($('#est2').val()) || 0;
        var est3 = parseFloat($('#est3').val()) || 0;
        var est4 = parseFloat($('#est4').val()) || 0;
        var est5 = parseFloat($('#est5').val()) || 0;
        var est6 = parseFloat($('#est6').val()) || 0;
        var est7 = parseFloat($('#est7').val()) || 0;
        var est8 = parseFloat($('#est8').val()) || 0;
        var est9 = parseFloat($('#est9').val()) || 0;
        var est10 = parseFloat($('#est10').val()) || 0;
        var est11 = parseFloat($('#est11').val()) || 0;
        var est12 = parseFloat($('#est12').val()) || 0;
        var est13 = parseFloat($('#est13').val()) || 0;
        var est14 = parseFloat($('#est14').val()) || 0;
        var est15 = parseFloat($('#est15').val()) || 0;
        var est16 = parseFloat($('#est16').val()) || 0;
        var est17 = parseFloat($('#est17').val()) || 0;
        var est18 = parseFloat($('#est18').val()) || 0;
        var est19 = parseFloat($('#est19').val()) || 0;
        var est20 = parseFloat($('#est20').val()) || 0;
        var est21 = parseFloat($('#est21').val()) || 0;
        var est22 = parseFloat($('#est22').val()) || 0;
        var est23 = parseFloat($('#est23').val()) || 0;
        var est24 = parseFloat($('#est24').val()) || 0;
        var est25 = parseFloat($('#est25').val()) || 0;
        var est26 = parseFloat($('#est26').val()) || 0;
        var est27 = parseFloat($('#est27').val()) || 0;
        var est28 = parseFloat($('#est28').val()) || 0;
        var est29 = parseFloat($('#est29').val()) || 0;
        var est30 = parseFloat($('#est30').val()) || 0;
        
        
        var estvalue = parseFloat((est1) + est2 + est3 + est4 + est5 + est6 + est7 + est8 + est9 + est10 + est11 + est12 + est13 + est14 + est15 + est16 + est17 + est18 + est19 + est20 + est21 + est22 + est23 + est24 + est25 + est26 + est27 + est28 + est29 + est30);

       // alert(estvalue);
        if(estvalue!=''){
             $('#grandest').val(estvalue);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#bill1, #bill2, #bill3, #bill4, #bill5, #bill6, #bill7, #bill8, #bill9, #bill10, #bill11, #bill12, #bill13, #bill14, #bill15, #bill16, #bill17, #bill18, #bill19, #bill20, #bill21, #bill22, #bill23, #bill24, #bill25, #bill26, #bill27, #bill28, #bill29, #bill30').blur(function(){

        var bill1 = parseFloat($('#bill1').val()) || 0;
        var bill2 = parseFloat($('#bill2').val()) || 0;
        var bill3 = parseFloat($('#bill3').val()) || 0;
        var bill4 = parseFloat($('#bill4').val()) || 0;
        var bill5 = parseFloat($('#bill5').val()) || 0;
        var bill6 = parseFloat($('#bill6').val()) || 0;
        var bill7 = parseFloat($('#bill7').val()) || 0;
        var bill8 = parseFloat($('#bill8').val()) || 0;
        var bill9 = parseFloat($('#bill9').val()) || 0;
        var bill10 = parseFloat($('#bill10').val()) || 0;
        var bill11 = parseFloat($('#bill11').val()) || 0;
        var bill12 = parseFloat($('#bill12').val()) || 0;
        var bill13 = parseFloat($('#bill13').val()) || 0;
        var bill14 = parseFloat($('#bill14').val()) || 0;
        var bill15 = parseFloat($('#bill15').val()) || 0;
        var bill16 = parseFloat($('#bill16').val()) || 0;
        var bill17 = parseFloat($('#bill17').val()) || 0;
        var bill18 = parseFloat($('#bill18').val()) || 0;
        var bill19 = parseFloat($('#bill19').val()) || 0;
        var bill20 = parseFloat($('#bill20').val()) || 0;
        var bill21 = parseFloat($('#bill21').val()) || 0;
        var bill22 = parseFloat($('#bill22').val()) || 0;
        var bill23 = parseFloat($('#bill23').val()) || 0;
        var bill24 = parseFloat($('#bill24').val()) || 0;
        var bill25 = parseFloat($('#bill25').val()) || 0;
        var bill26 = parseFloat($('#bill26').val()) || 0;
        var bill27 = parseFloat($('#bill27').val()) || 0;
        var bill28 = parseFloat($('#bill28').val()) || 0;
        var bill29 = parseFloat($('#bill29').val()) || 0;
        var bill30 = parseFloat($('#bill30').val()) || 0;
        
        
        var billvalue = parseFloat((bill1) + bill2 + bill3 + bill4 + bill5 + bill6 + bill7 + bill8 + bill9 + bill10 + bill11 + bill12 + bill13 + bill14 + bill15 + bill16 + bill17 + bill18 + bill19 + bill20 + bill21 + bill22 + bill23 + bill24 + bill25 + bill26 + bill27 + bill28 + bill29 + bill30);

        
        if(billvalue!=''){
             $('#grandbill').val(billvalue);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#value1, #value3, #value5, #value7,#value9,#value11,#value13,#value15,#value17,#value19,#value21,#value23,#value25,#value27,#value29,#value31,#value33,#value35,#value37,#value39,#value41,#value43,#value45,#value47,#value49,#value51,#value53,#value55,#value57,#value59').blur(function(){

        var value1 = parseFloat($('#value1').val()) || 0;
        var value3 = parseFloat($('#value3').val()) || 0;
        var value5 = parseFloat($('#value5').val()) || 0;
        var value7 = parseFloat($('#value7').val()) || 0;
        var value9 = parseFloat($('#value9').val()) || 0;
        var value11 = parseFloat($('#value11').val()) || 0;
        var value13 = parseFloat($('#value13').val()) || 0;
        var value15 = parseFloat($('#value15').val()) || 0;
        var value17 = parseFloat($('#value17').val()) || 0;
        var value19 = parseFloat($('#value19').val()) || 0;
        var value21 = parseFloat($('#value21').val()) || 0;
        var value23 = parseFloat($('#value23').val()) || 0;
        var value25 = parseFloat($('#value25').val()) || 0;
        var value27 = parseFloat($('#value27').val()) || 0;
        var value29 = parseFloat($('#value29').val()) || 0;
        var value31 = parseFloat($('#value31').val()) || 0;
        var value33 = parseFloat($('#value33').val()) || 0;
        var value35 = parseFloat($('#value35').val()) || 0;
        var value37 = parseFloat($('#value37').val()) || 0;
        var value39 = parseFloat($('#value39').val()) || 0;
        var value41 = parseFloat($('#value41').val()) || 0;
        var value43 = parseFloat($('#value43').val()) || 0;
        var value45 = parseFloat($('#value45').val()) || 0;
        var value47 = parseFloat($('#value47').val()) || 0;
        var value49 = parseFloat($('#value49').val()) || 0;
        var value51 = parseFloat($('#value51').val()) || 0;
        var value53 = parseFloat($('#value53').val()) || 0;
        var value55 = parseFloat($('#value55').val()) || 0;
        var value57 = parseFloat($('#value57').val()) || 0;
        var value59 = parseFloat($('#value59').val()) || 0;
        
        var assestavg = parseFloat((value1) + value3 + value5 + value7 + value9 + value11 + value13 + value15 + value17 + value19 + value21 + value23 + value25 + value27 + value29 + value31 + value33 + value35 + value37 + value39 + value41 + value43 + value45 + value47 + value49 + value51 + value53 + value55 +  value57 + value59);
       
        if(assestavg!=''){
             $('#total_sum_value').val(assestavg);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#sum, #sum1, #sum2, #sum3, #sum4, #sum5, #sum6, #sum7, #sum8, #sum9, #sum10, #sum11, #sum12, #sum13, #sum14, #sum15, #sum16, #sum17, #sum18, #sum19, #sum20, #sum21, #sum22, #sum23, #sum24, #sum25, #sum26, #sum27, #sum28, #sum29').blur(function(){

        var sum = parseFloat($('#sum').val()) || 0;
        var sum1 = parseFloat($('#sum1').val()) || 0;
        var sum2 = parseFloat($('#sum2').val()) || 0;
        var sum3 = parseFloat($('#sum3').val()) || 0;
        var sum4 = parseFloat($('#sum4').val()) || 0;
        var sum5 = parseFloat($('#sum5').val()) || 0;
        var sum6 = parseFloat($('#sum6').val()) || 0;
        var sum7 = parseFloat($('#sum7').val()) || 0;
        var sum8 = parseFloat($('#sum8').val()) || 0;
        var sum9 = parseFloat($('#sum9').val()) || 0;
        var sum10 = parseFloat($('#sum10').val()) || 0;
        var sum11 = parseFloat($('#sum11').val()) || 0;
        var sum12 = parseFloat($('#sum12').val()) || 0;
        var sum13 = parseFloat($('#sum13').val()) || 0;
        var sum14 = parseFloat($('#sum14').val()) || 0;
        var sum15 = parseFloat($('#sum15').val()) || 0;
        var sum16 = parseFloat($('#sum16').val()) || 0;
        var sum17 = parseFloat($('#sum17').val()) || 0;
        var sum18 = parseFloat($('#sum18').val()) || 0;
        var sum19 = parseFloat($('#sum19').val()) || 0;
        var sum20 = parseFloat($('#sum20').val()) || 0;
        var sum21 = parseFloat($('#sum21').val()) || 0;
        var sum22 = parseFloat($('#sum22').val()) || 0;
        var sum23 = parseFloat($('#sum23').val()) || 0;
        var sum24 = parseFloat($('#sum24').val()) || 0;
        var sum25 = parseFloat($('#sum25').val()) || 0;
        var sum26 = parseFloat($('#sum26').val()) || 0;
        var sum27 = parseFloat($('#sum27').val()) || 0;
        var sum28 = parseFloat($('#sum28').val()) || 0;
        var sum29 = parseFloat($('#sum29').val()) || 0;
        
        
        var gstvalue = parseFloat((sum) + sum1 + sum2 + sum3 + sum4 + sum5 + sum6 + sum7 + sum8 + sum9 + sum10 + sum11 + sum12 + sum13 + sum14 + sum15 + sum16 + sum17 + sum18 + sum19 + sum20 + sum21 + sum22 + sum23 + sum24 + sum25 + sum26 + sum27 + sum28 + sum29 );

        
        if(gstvalue!=''){
             $('#gstcalval').val(gstvalue);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#gstamt, #gstamt1, #gstamt2, #gstamt3, #gstamt4, #gstamt5, #gstamt6, #gstamt7, #gstamt8, #gstamt9, #gstamt10, #gstamt11, #gstamt12, #gstamt13, #gstamt14, #gstamt15, #gstamt16, #gstamt17, #gstamt18, #gstamt19, #gstamt20, #gstamt21, #gstamt22, #gstamt23, #gstamt24, #gstamt25, #gstamt26, #gstamt27, #gstamt28, #gstamt29').blur(function(){

        var gstamt = parseFloat($('#gstamt').val()) || 0;
        var gstamt1 = parseFloat($('#gstamt1').val()) || 0;
        var gstamt2 = parseFloat($('#gstamt2').val()) || 0;
        var gstamt3 = parseFloat($('#gstamt3').val()) || 0;
        var gstamt4 = parseFloat($('#gstamt4').val()) || 0;
        var gstamt5 = parseFloat($('#gstamt5').val()) || 0;
        var gstamt6 = parseFloat($('#gstamt6').val()) || 0;
        var gstamt7 = parseFloat($('#gstamt7').val()) || 0;
        var gstamt8 = parseFloat($('#gstamt8').val()) || 0;
        var gstamt9 = parseFloat($('#gstamt9').val()) || 0;
        var gstamt10 = parseFloat($('#gstamt10').val()) || 0;
        var gstamt11 = parseFloat($('#gstamt11').val()) || 0;
        var gstamt12 = parseFloat($('#gstamt12').val()) || 0;
        var gstamt13 = parseFloat($('#gstamt13').val()) || 0;
        var gstamt14 = parseFloat($('#gstamt14').val()) || 0;
        var gstamt15 = parseFloat($('#gstamt15').val()) || 0;
        var gstamt16 = parseFloat($('#gstamt16').val()) || 0;
        var gstamt17 = parseFloat($('#gstamt17').val()) || 0;
        var gstamt18 = parseFloat($('#gstamt18').val()) || 0;
        var gstamt19 = parseFloat($('#gstamt19').val()) || 0;
        var gstamt20 = parseFloat($('#gstamt20').val()) || 0;
        var gstamt21 = parseFloat($('#gstamt21').val()) || 0;
        var gstamt22 = parseFloat($('#gstamt22').val()) || 0;
        var gstamt23 = parseFloat($('#gstamt23').val()) || 0;
        var gstamt24 = parseFloat($('#gstamt24').val()) || 0;
        var gstamt25 = parseFloat($('#gstamt25').val()) || 0;
        var gstamt26 = parseFloat($('#gstamt26').val()) || 0;
        var gstamt27 = parseFloat($('#gstamt27').val()) || 0;
        var gstamt28 = parseFloat($('#gstamt28').val()) || 0;
        var gstamt29 = parseFloat($('#gstamt29').val()) || 0;
        
        
        var gstamtvalue = parseFloat((gstamt) + gstamt1 + gstamt2 + gstamt3 + gstamt4 + gstamt5 + gstamt6 + gstamt7 + gstamt8 + gstamt9 + gstamt10 + gstamt11 + gstamt12 + gstamt13 + gstamt14 + gstamt15 + gstamt16 + gstamt17 + gstamt18 + gstamt19 + gstamt20 + gstamt21 + gstamt22 + gstamt23 + gstamt24 + gstamt25 + gstamt26 + gstamt27 + gstamt28 + gstamt29 );

       
        if(gstamtvalue!=''){
             $('#gstval').val(gstamtvalue);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#depriamt, #depriamt1, #depriamt2, #depriamt3, #depriamt4, #depriamt5, #depriamt6, #depriamt7, #depriamt8, #depriamt9, #depriamt10, #depriamt11, #depriamt12, #depriamt13, #depriamt14, #depriamt15, #depriamt16, #depriamt17, #depriamt18, #depriamt19, #depriamt20, #depriamt21, #depriamt22, #depriamt23, #depriamt24, #depriamt25, #depriamt26, #depriamt27, #depriamt28, #depriamt29').blur(function(){

        var depriamt = parseFloat($('#depriamt').val()) || 0;
        var depriamt1 = parseFloat($('#depriamt1').val()) || 0;
        var depriamt2 = parseFloat($('#depriamt2').val()) || 0;
        var depriamt3 = parseFloat($('#depriamt3').val()) || 0;
        var depriamt4 = parseFloat($('#depriamt4').val()) || 0;
        var depriamt5 = parseFloat($('#depriamt5').val()) || 0;
        var depriamt6 = parseFloat($('#depriamt6').val()) || 0;
        var depriamt7 = parseFloat($('#depriamt7').val()) || 0;
        var depriamt8 = parseFloat($('#depriamt8').val()) || 0;
        var depriamt9 = parseFloat($('#depriamt9').val()) || 0;
        var depriamt10 = parseFloat($('#depriamt10').val()) || 0;
        var depriamt11 = parseFloat($('#depriamt11').val()) || 0;
        var depriamt12 = parseFloat($('#depriamt12').val()) || 0;
        var depriamt13 = parseFloat($('#depriamt13').val()) || 0;
        var depriamt14 = parseFloat($('#depriamt14').val()) || 0;
        var depriamt15 = parseFloat($('#depriamt15').val()) || 0;
        var depriamt16 = parseFloat($('#depriamt16').val()) || 0;
        var depriamt17 = parseFloat($('#depriamt17').val()) || 0;
        var depriamt18 = parseFloat($('#depriamt18').val()) || 0;
        var depriamt19 = parseFloat($('#depriamt19').val()) || 0;
        var depriamt20 = parseFloat($('#depriamt20').val()) || 0;
        var depriamt21 = parseFloat($('#depriamt21').val()) || 0;
        var depriamt22 = parseFloat($('#depriamt22').val()) || 0;
        var depriamt23 = parseFloat($('#depriamt23').val()) || 0;
        var depriamt24 = parseFloat($('#depriamt24').val()) || 0;
        var depriamt25 = parseFloat($('#depriamt25').val()) || 0;
        var depriamt26 = parseFloat($('#depriamt26').val()) || 0;
        var depriamt27 = parseFloat($('#depriamt27').val()) || 0;
        var depriamt28 = parseFloat($('#depriamt28').val()) || 0;
        var depriamt29 = parseFloat($('#depriamt29').val()) || 0;

        
        var deprivalue = parseFloat((depriamt) + depriamt1 + depriamt2 + depriamt3 + depriamt4 + depriamt5 + depriamt6 + depriamt7 + depriamt8 + depriamt9 + depriamt10 + depriamt11 + depriamt12 + depriamt13 + depriamt14 + depriamt15 + depriamt16 + depriamt17 + depriamt18 + depriamt19 + depriamt20 + depriamt21 + depriamt22 + depriamt23 + depriamt24 + depriamt25 + depriamt26 + depriamt27 + depriamt28 + depriamt29 );

        
        if(deprivalue!=''){
             $('#depval').val(deprivalue);
            }
       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#netamt, #netamt1, #netamt2, #netamt3, #netamt4, #netamt5, #netamt6, #netamt7, #netamt8, #netamt9, #netamt10, #netamt11, #netamt12, #netamt13, #netamt14, #netamt15, #netamt16, #netamt17, #netamt18, #netamt19, #netamt20, #netamt21, #netamt22, #netamt23, #netamt24, #netamt25, #netamt26, #netamt27, #netamt28, #netamt29').blur(function(){

        var netamt = parseFloat($('#netamt').val()) || 0;
        var netamt1 = parseFloat($('#netamt1').val()) || 0;
        var netamt2 = parseFloat($('#netamt2').val()) || 0;
        var netamt3 = parseFloat($('#netamt3').val()) || 0;
        var netamt4 = parseFloat($('#netamt4').val()) || 0;
        var netamt5 = parseFloat($('#netamt5').val()) || 0;
        var netamt6 = parseFloat($('#netamt6').val()) || 0;
        var netamt7 = parseFloat($('#netamt7').val()) || 0;
        var netamt8 = parseFloat($('#netamt8').val()) || 0;
        var netamt9 = parseFloat($('#netamt9').val()) || 0;
        var netamt10 = parseFloat($('#netamt10').val()) || 0;
        var netamt11 = parseFloat($('#netamt11').val()) || 0;
        var netamt12 = parseFloat($('#netamt12').val()) || 0;
        var netamt13 = parseFloat($('#netamt13').val()) || 0;
        var netamt14 = parseFloat($('#netamt14').val()) || 0;
        var netamt15 = parseFloat($('#netamt15').val()) || 0;
        var netamt16 = parseFloat($('#netamt16').val()) || 0;
        var netamt17 = parseFloat($('#netamt17').val()) || 0;
        var netamt18 = parseFloat($('#netamt18').val()) || 0;
        var netamt19 = parseFloat($('#netamt19').val()) || 0;
        var netamt20 = parseFloat($('#netamt20').val()) || 0;
        var netamt21 = parseFloat($('#netamt21').val()) || 0;
        var netamt22 = parseFloat($('#netamt22').val()) || 0;
        var netamt23 = parseFloat($('#netamt23').val()) || 0;
        var netamt24 = parseFloat($('#netamt24').val()) || 0;
        var netamt25 = parseFloat($('#netamt25').val()) || 0;
        var netamt26 = parseFloat($('#netamt26').val()) || 0;
        var netamt27 = parseFloat($('#netamt27').val()) || 0;
        var netamt28 = parseFloat($('#netamt28').val()) || 0;
        var netamt29 = parseFloat($('#netamt29').val()) || 0;
        
        
        var netamtval = parseFloat((netamt) + netamt1 + netamt2 + netamt3 + netamt4 + netamt5 + netamt6 + netamt7 + netamt8 + netamt9 + netamt10 + netamt11 + netamt12 + netamt13 + netamt14 + netamt15 + netamt16 + netamt17 + netamt18 + netamt19 + netamt20 + netamt21 + netamt22 + netamt23 + netamt24 + netamt25 + netamt26 + netamt27 + netamt28 + netamt29 );

        if(netamtval!=''){
            
             $('#netval').val(netamtval);

            }

       
         });
      
    });

    ");

?>

<?php

$this->registerJs("
    $(function(){

     $('#netval, #exval1, #exval2, #exval3, #exval4').blur(function(){

        var netval = parseFloat($('#netval').val()) || 0;
        var exval1 = parseFloat($('#exval1').val()) || 0;
        var exval2 = parseFloat($('#exval2').val()) || 0;
        var exval3 = parseFloat($('#exval3').val()) || 0;
        var exval4 = parseFloat($('#exval4').val()) || 0;
        
        var grand1 = parseFloat((netval) - exval1);
        var grand2 = parseFloat((grand1) - exval2);
        var grand3 = parseFloat((grand2) - exval3);
        var grand4 = parseFloat((grand3) - exval4);
        
        
        if(grand4!=''){
             $('#extotalval').val(grand4);
            }
             $('#grandtotal').val(grand4);
              
         });
      
    });

    ");

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
        '$appUrl/axion-claimsurvey/assign-location', 
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

 $url = YII::$app->request->baseUrl.'/axion-claimsurvey/image-upload';

$script = <<< JS
$('.cm-Photo-01').on('click', function() {
  $('#photoType').val('Photo-01');
  loadPopup();
})

$('.cm-Photo-02').on('click', function() {
  $('#photoType').val('Photo-02');
  loadPopup();
})

$('.cm-Photo-03').on('click', function() {
  $('#photoType').val('Photo-03');
  loadPopup();
})

$('.cm-Photo-04').on('click', function() {
  $('#photoType').val('Photo-04');
  loadPopup();
})

$('.cm-Photo-05').on('click', function() {
  $('#photoType').val('Photo-05');
  loadPopup();
})

$('.cm-Photo-06').on('click', function() {
  $('#photoType').val('Photo-06');
  loadPopup();
})

$('.cm-Photo-07').on('click', function() {
  $('#photoType').val('Photo-07');
  loadPopup();
})

$('.cm-Photo-08').on('click', function() {
  $('#photoType').val('Photo-08');
  loadPopup();
})

$('.cm-Photo-09').on('click', function() {
  $('#photoType').val('Photo-09');
  loadPopup();
})

$('.cm-Photo-10').on('click', function() {
  $('#photoType').val('Photo-10');
  loadPopup();
})

$('.cm-Photo-11').on('click', function() {
  $('#photoType').val('Photo-11');
  loadPopup();
})


$('.cm-Photo-12').on('click', function() {
  $('#photoType').val('Photo-12');
  loadPopup();
})


$('.cm-Photo-13').on('click', function() {
  $('#photoType').val('Photo-13');
  loadPopup();
})


$('.cm-Photo-14').on('click', function() {
  $('#photoType').val('Photo-14');
  loadPopup();
})


$('.cm-Photo-15').on('click', function() {
  $('#photoType').val('Photo-15');
  loadPopup();
})


$('.cm-Photo-16').on('click', function() {
  $('#photoType').val('Photo-16');
  loadPopup();
})


$('.cm-Photo-17').on('click', function() {
  $('#photoType').val('Photo-17');
  loadPopup();
})



$('.cm-Photo-18').on('click', function() {
  $('#photoType').val('Photo-18');
  loadPopup();
})


$('.cm-Photo-19').on('click', function() {
  $('#photoType').val('Photo-19');
  loadPopup();
})


$('.cm-Photo-20').on('click', function() {
  $('#photoType').val('Photo-20');
  loadPopup();
})


$('.cm-Photo-21').on('click', function() {
  $('#photoType').val('Photo-21');
  loadPopup();
})

$('.cm-Photo-22').on('click', function() {
  $('#photoType').val('Photo-22');
  loadPopup();
})

$('.cm-Photo-23').on('click', function() {
  $('#photoType').val('Photo-23');
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
                    //  console.log('Upload successfully');
                          //alert('Upload success');
                          location.reload();
                        }
                     });
                })
            }
        
        //  $(this).hide();
      //  window.addEventListener("load", cameraStart, false);

JS;
$this->registerJS($script);
?>

<?php
$script = <<< JS

$(document).ready(function() {
        $("select").change(function() {
            $(this).find("option:selected").each(function() {
                if ($(this).attr("value") == "4-WHEELER") {
                    $(".box").not(".ref_id4").hide();
                    $(".ref_id4").show();
                   
                }             

                else if ($(this).attr("value") == "2-WHEELER") {
                    $(".box").not(".ref_id2").hide();
                    $(".ref_id2").show();
                    
                }

                else if ($(this).attr("value") == "COMMERCIAL") {
                    $(".box").not(".ref_id1").hide();
                    $(".ref_id1").show();
                   
                }

                else {

                  //  $(".box").hide();
                }
            });
        }).change();
    });



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
                     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
               </div>";       
                     
        echo "<div class='modal-body'></div>";     
             
        echo "<div class='modal-footer'>
               <button id='cameratrigger'>Capture</button>
               <button id='cameraupload', style='display:none'>Upload</button>
              </div>";

        Modal::end(); 

?>


