<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use app\models\AxionCliamsueryDocUploads;
// use app\helpers\S3Helper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionVehicle */
/* @var $form ActiveForm */
$otherFileurl = YII::$app->request->baseUrl . '/axion-claimsurvey/other-file-append';
$otherFileurl1 = YII::$app->request->baseUrl . '/axion-claimsurvey/other-file-append-count';
$fileRemoveurl = YII::$app->request->baseUrl . '/axion-claimsurvey/other-file-remove';
$Rcupload = YII::$app->request->baseUrl . '/axion-preinspection/rc-upload';

if (isset($valuator)) {
  $arr = [
    'add' => [
      'id' => '0',
      'firstName' => 'Self Inspection'
    ],
  ];
  $valuator = ArrayHelper::merge($arr, $valuator);
  $valuatorData = ArrayHelper::map($valuator, 'id', 'firstName');
} else {
  $valuatorData = ['' => 'Select', '0' => 'Customer'];
}

$typeName = $phmodel[0]->typeName;
$locStatus = $phmodel[0]->locStatusValue;
$timeStatus = $phmodel[0]->timeStatusValue;

$rcArray = $model->rcValue;
$statusArray = $model->qcStatusValue;
$enginecondition = [

  ['id' => '1', 'name' => 'Engine Working/Started'],
  ['id' => '2', 'name' => 'Engine Not Working/Started'],
  ['id' => '3', 'name' => 'Battery Not Working']
];

$engine_status = ArrayHelper::map($enginecondition, 'id', 'name');


if ($role == 'Surveyor') {
  $statusList = [
    ['id' => '0', 'name' => '-Select-'],
    ['id' => '8', 'name' => 'Survey Done'],
  ];
  $statusArray = ArrayHelper::map($statusList, 'id', 'name');
} else if ($role == 'Superadmin' || $role == 'Admin') {

  $statusArray = $statusArray +  ['9' => 'Cancelled'];
}

$vehicleTypeRadioList = [
  ['id' => '', 'name' => 'SELECT'],
  ['id' => 'PVT', 'name' => 'PVT'],
  ['id' => 'TAXI', 'name' => 'TAXI'],
];
$vehicleTypeRadioArray = ArrayHelper::map($vehicleTypeRadioList, 'id', 'name');

$damageTypeArray = ArrayHelper::map($damageType, 'id', 'damage_name');

$vTypeList = [
  ['id' => '', 'name' => ''],
  ['id' => '4-WHEELER', 'name' => '4-WHEELER'],
  ['id' => '2-WHEELER', 'name' => '2-WHEELER'],
  ['id' => 'COMMERCIAL', 'name' => 'COMMERCIAL'],
];
$vTypeArray = ArrayHelper::map($vTypeList, 'id', 'name');

$conveyanceApprovalList = [
  ['id' => '', 'name' => 'SELECT'],
  ['id' => 'Yes', 'name' => 'Yes'],
  ['id' => 'No', 'name' => 'No'],
];
$conveyanceApprovalArray = ArrayHelper::map($conveyanceApprovalList, 'id', 'name');

$inspectionTypeArray = $premodel->inspectionTypevalue;
$paymentArray = $premodel->paymentValue;

$vehicleCategoryArray = $model->vehicleCategoryvalue;

if ($premodel->insurerName == 10)
  $fuelTypeArray = $model->rsFuelTypevalue;
else
  $fuelTypeArray = $model->fuelTypevalue;

$fuelTankArray = $model->fuelTankvalue;


$glassTypeArray = $model->glassTypevalue;
$underCarriageArray = $model->UnderCarriage;
$spareTyreArray = $model->spareTyrevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
$damageType5Array = $model->damageType5value;
$twowheelerArray = $twowheelermodel->twowheelervalue;

$commercialwheelerArray = $commercialwheelermodel->commercialwheelerValue;
$commercialwheeler1Array = $commercialwheelermodel->commercialwheeler1Value;
$fwheelerArray = $fwheelermodel->fwheelervalue;

$companyList = ArrayHelper::map($company, 'id', 'companyName');

$callerList = ArrayHelper::map($caller, 'id', 'firstName');


$qcLoc = \Yii::$app->params['qcLoc'];
$s3BaseUrl = \Yii::$app->params['s3Bucket'].'.s3.'.\Yii::$app->params['s3Region'].'.amazonaws.com/';

?>


<div class="axion-preinspection-fourwheelerqc">

  <?php if (isset($_GET['response'])) {
    echo $_GET['response'];
  } ?>

  <?php $form = ActiveForm::begin(['id' => $model->formName(), 'options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'validationUrl' => ['axion-preinspection/validation', 'id' => $premodel->id],]); ?>
 
  <?php if ($role != 'Commonuser' && $role != "Customer") { ?>

    <h2 class="title text-center mt-80">VEHICLE INSPECTION</h2>

    <div class="col-md-6 left-side-panel" style="display: none;">
      <div class="panel panel-primary" style="display: none;" >

        <div class="clearfix">
          <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#company_details">Customer, Client and Vehicle Details</h4>
          <?= FA::icon('minus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#company_details']); ?>
        </div>

        <div id="company_details" class="preinspection-box collapse in">
          <div class="panel-body">

            <div class="col-lg-6">
              <?= $form->field($premodel, 'referenceNo')->textInput(['readonly' => true, 'maxlength' => true]) ?>
            </div>


            <div class="col-lg-6">
              <?= $form->field($premodel, 'insuredName') ?>
            </div>

            <div class="col-lg-6">
              <?= $form->field($premodel, 'insuredMobile') ?>
            </div>

            <div class="col-lg-6">
              <?= $form->field($premodel, 'insurerName')->dropDownList($companyList, ['id' => 'companyId']); ?>
            </div>

           
              <!-- <div class="col-lg-6">
                <?= $form->field($premodel, 'paymentMode')->dropDownList($paymentArray,['id' => 'paymentMode']) ?>
              </div>
           -->

            <div class="col-lg-6">
              <?= $form->field($premodel, 'cashCollection') ?>
            </div>

            <div class="col-lg-6">
              <?= $form->field($premodel, 'insuredAddress') ?>
            </div>

           

          

            <div class="col-lg-6">
              <?= $form->field($premodel, 'inspectionType')->dropDownList($inspectionTypeArray) ?>
            </div>

            >

            <div class="col-lg-6">
              <?= $form->field($premodel, 'callerMobileNo')->textInput(['readonly' => true, 'maxlength' => true])->label('Caller Mobile No') ?>
            </div>

            <div class="col-lg-6">
              <?= $form->field($premodel, 'callerDetails')->textInput(['readonly' => true, 'maxlength' => true])->label('Caller Email Id') ?>
            </div>

            

           

            

            <div class="col-lg-6">
              <?= $form->field($premodel, 'engineNo') ?>
            </div>

            <div class="col-lg-6">
              <?= $form->field($premodel, 'chassisNo') ?>
            </div>

           
     

            <div class="col-lg-6">
              <?= $form->field($premodel, 'manufacturingYear') ?>
            </div>

          
            <div class="clear"></div>
          </div> <!-- End Panel Body -->
        </div>

      </div> <!-- End Panel -->




      <div class="panel panel-primary" style="display: none;">

        <div class="clearfix">
          <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#inspection_details">Vehicle General Details</h4>
          <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#inspection_details']); ?>
        </div>

        <div id="inspection_details" class="preinspection-box collapse">
          <div class="panel-body">
            <div class="col-lg-6">
              <?= $form->field($model, 'colour') ?>
            </div>
           
            
            <div class="col-lg-6">
              <?= $form->field($model, 'stereoMake')->textInput(); ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'otherElectrical')->textInput(); ?>
            </div>
            <!-- <div class="col-lg-6">
              <?= $form->field($model, 'fuelTank')->dropDownList($fuelTankArray) ?>
            </div> -->

         

            <!-- <div class="col-lg-6">
              <?= $form->field($model, 'frontBumper')->dropDownList($damageTypeArray) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'grill')->dropDownList($damageTypeArray) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'headLights')->dropDownList($damageTypeArray) ?>
            </div> -->
            <!-- <div class="col-lg-6">
              <?= $form->field($model, 'indicatorLights')->dropDownList($damageTypeArray) ?>
            </div> -->
            <!-- <div class="col-lg-6">
              <?= $form->field($model, 'bonnet')->dropDownList($damageTypeArray) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'rearBumper')->dropDownList($damageTypeArray) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'tailLamps')->dropDownList($damageTypeArray) ?>
            </div> -->
            <?php /* <div class="col-lg-6">
              <?= $form->field($model, 'rearViewMirrors')->dropDownList($damageType1Array) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'spareTyre')->dropDownList($spareTyreArray) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'tyres')->dropDownList($damageType1Array) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'dashBoard')->dropDownList($damageType1Array) ?>
            </div>
            <div class="col-lg-6">
              <?= $form->field($model, 'seats')->dropDownList($spareTyreArray) ?>
            </div> */ ?>
            <!-- <div class="col-lg-6" style="color:red;">
              <?= $form->field($model, 'rightWindowGlass')->dropDownList($damageTypeArray) ?>
            </div>
            <div class="col-lg-6" style="color:red;">
              <?= $form->field($model, 'leftWindowGlass')->dropDownList($damageTypeArray) ?>
            </div> -->

            <!-- <div class="col-lg-6" style="color:red;">
              <?= $form->field($model, 'frontwsGlassLaminated')->dropDownList($damageTypeArray) ?>
            </div>

            <div class="col-lg-6" style="color:red;">
              <?= $form->field($model, 'backGlass')->dropDownList($damageTypeArray) ?>
            </div> -->
            <?php /*
            <div class="col-lg-6">
              <?= $form->field($model, 'underCarriage')->dropDownList($underCarriageArray) ?>
            </div> */ ?>

        
            <?php /* <div class="col-lg-6" style="color:red;">
              <?= $form->field($premodel, 'status')->dropDownList($statusArray) ?>
            </div> */ ?>

           

            <?php echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?>
            <div class="clear"></div>
          </div> <!-- End Panel Body -->
        </div>
      </div> <!-- End Panel -->

      <div class="ref_id2 box">
        <div class="panel panel-primary" style="display: none;">

          <div class="clearfix">
            <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#2-wheeler_details">2-Wheeler</h4>
            <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#2-wheeler_details']); ?>
          </div>

          <div id="2-wheeler_details" class="preinspection-box collapse">
            <div class="panel-body">
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'frontMudgaurd')->dropDownList($twowheelerArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'handleBar')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'leverClutchHeadBreak')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'forntHubDiselDrum')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'frontWheelRim')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'frontShockAbsorber')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'legGaurd')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'leftCoverShield')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rightCoverShield')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'chassisFrame')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'crankCaseCylinder')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rearWheelRim')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rearShockAbsorber')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rearDrumDisc')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'chainCover')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'fork')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'kickPedal')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rearcowlLeftCenterRight')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'legshieldLeft')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'legshieldRight')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'fairing')->dropDownList($damageType1Array) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'silencer')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'rearMudguard')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'sareeGuard')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'wisor')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'helmetBox')->dropDownList($damageType1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($twowheelermodel, 'luggageCarrier')->dropDownList($damageType1Array) ?>
              </div>



              <?php echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?>
              <div class="clear"></div>
            </div> <!-- End Panel Body -->
          </div>
        </div>  <!-- End Panel -->
      </div>


      <div class="ref_id4 box">
        <div class="panel panel-primary" style="display: none;">

          <div class="clearfix">
            <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#4-wheeler_details">4-Wheeler</h4>
            <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#4-wheeler_details']); ?>
          </div>

          <div id="4-wheeler_details" class="preinspection-box collapse">
            <div class="panel-body">
              <!-- <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltFrontFender')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltFrontDoor')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltRearDoor')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltRunningBoard')->dropDownList($damageTypeArray) ?>
              </div> -->
              <!-- <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltPillarDoor')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltPillarCenter')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltPillarRear')->dropDownList($damageTypeArray) ?>
              </div> -->
              <!-- <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltQtrPanel')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtQtrPanel')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtRearDoor')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtFrontDoor')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtFrontPillar')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtCenterPillar')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtRearPillar')->dropDownList($damageTypeArray) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtRunningBoard')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtFrontFender')->dropDownList($damageTypeArray) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'dicky')->dropDownList($damageTypeArray) ?>
              </div> -->

              <!-- New AI modal fields -->
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'bonnet')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'dashboard')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'dicky_boot')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_bumper')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_grill')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_windshield')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rear_windshield')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'head_light')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'odometter')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rear_bumper')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'tail_lamp')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'chassis_engraved')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'chassis_plate')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'driver_door')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_fender')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_number_plate')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'front_door')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'quarter_panel')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rear_number_plate')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rear_door')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rear_view_mirror')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'running_board')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'tyre')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'under_chassis')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'driver_quarter_panel')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'driver_front_fender')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'driver_rear_door')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'passenger_front_door')->dropDownList($damageTypeArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'passenger_rear_door')->dropDownList($damageTypeArray) ?>
              </div>



              <!-- New AI modal fields End -->


              <?php /*
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltRearTyre') ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'ltFrontTyre') ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtRearTyre') ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($fwheelermodel, 'rtFrontTyre') ?>
              </div> */ ?>
              <?php echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?>
              <div class="clear"></div>
            </div> <!-- End Panel Body -->
          </div>

        </div> <!-- End Panel -->
      </div>


      <div class="ref_id1 box">
        <div class="panel panel-primary" style="display: none;">

          <div class="clearfix">
            <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#commercial_details">Commercial</h4>
            <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#commercial_details']); ?>
          </div>

          <div id="commercial_details" class="preinspection-box collapse">
            <div class="panel-body">
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'typeOfBody')->dropDownList($commercialwheelerArray) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'frontSideBody')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'rearSideBody')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'rightSideBody')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'leftSideBody')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'frontExcavator')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'craneBucket')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'craneHook')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'ac')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'boom')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'fans')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'hydrualicSystem')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'chassisFrame')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'doors')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'excavatorCabinGlass')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'craneCabinGlass')->dropDownList($commercialwheeler1Array) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($commercialwheelermodel, 'extraFittings') ?>
              </div>
              <?php echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?>
              <div class="clear"></div>
            </div> <!-- End Panel Body -->
          </div>

        </div> <!-- End Panel -->
      </div>



      <div class="panel panel-primary" style="display: none;">

          <div class="clearfix">
            <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#customer_details">Customer Information </h4>
            <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#customer_details']); ?>
          </div>

          <div id="customer_details" class="preinspection-box collapse">
            <div class="panel-body">
              <div class="col-lg-6">
                <?= $form->field($premodel, 'customerOccupation') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'residence') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'customerAge') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'numberOfCarsOwned') ?>
              </div>


              <div class="col-lg-6">
                <?= $form->field($premodel, 'vehicleParked') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'securityOfVehicle') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'relationship') ?>
              </div>


              <div class="col-lg-6">
                <?= $form->field($premodel, 'maintenance') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'vehicleTimeOfInspection') ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($premodel, 'updatedContact') ?>
              </div>
              <div class="clear"></div>
            </div> <!-- End Panel Body -->
          </div>

      </div> <!-- End Panel -->



      <?php if ($premodel->surveyorName == 0) { ?>

        <!-- <div class="panel panel-primary">

          <h4 class="preinspection-box-title panel-heading">Video Session</h4>
          <div id="inspection_session" class="preinspection-box" style="margin-bottom: 30px; text-align: center">
            <div class="panel-body">
              <?php if ($customerSession > 0) {
              ?>
                <?= Html::a('Video Session', ['axion-preinspection/video-session', 'id' => $premodel->id], ['class' => 'btn btn-primary']) ?>
                <?php
                } else {
                  if ($role != '' && $role != 'Customer') {
                ?>
                  <div class="form-group" style="text-align: center">
                    <?= Html::submitButton('Create Customer Video Session', ['class' => 'btn btn-primary', 'value' => 'create_session', 'name' => 'create_session']) ?>
                  </div>
              <?php }
                }   ?>
            </div> <!-- End Panel Body
          </div>


        </div> <!-- End Panel -->
      <?php  } ?>
    </div>  <!-- End Left Side Panel -->
    <?php
    } ?>



  <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-md-12 right-side-panel':'guest-right-side-panel'?>">
    
    <div class="panel panel-primary">
      <div class="clearfix collapse-side-heading">
        <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#inspection_capture_video">Record Video </h4>
        <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#inspection_capture_video']); ?>
      </div>
      <div id="inspection_capture_video" class="preinspection-box collapse">
          <a href="#" class="btn btn-success sample-video-visibility-btn" style="margin: auto;display: inherit;width: max-content;">Show Sample Video</a>
    
          <div class="sample-video-container <?=($role != 'Commonuser' && $role != "Customer")?'hide':''?>">
              <div class="sample-video-label text-warning" style="margin:10px auto; text-align:center;">Sample - Video</div>
              <div class="sample-video-frame">
                  <video controls muted style="display: block;margin: auto;max-width: 670px;width: 100%;" src="<?= Yii::$app->urlManager->createAbsoluteUrl('images/qc_sample_images/sample_video.mp4'); ?>" class="sample-img lightboxed" rel="group1" data-link="<?= Yii::$app->urlManager->createAbsoluteUrl('images/qc_sample_images/sample_video.mp4'); ?>" alt="<?= $obj->type ?>" data-caption="<?= $obj->type ?>"></video>
              </div>
          </div>
        <?php foreach ($phmodel as $obj) {
            if ($obj->type == 'vehicleVideo') {
              $qcLoc = \Yii::$app->params['qcLoc'];
              if ($obj->image != '')
              {
                $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
                $s3FileExists =  '';//S3Helper::fileExists($imgUrl);

                if ($s3FileExists['status'])
                {
                  $imgUrl = $s3FileExists['data']['url'];
                }
                else
                {
                  $imgUrl = Yii::$app->urlManager->createAbsoluteUrl([$qcLoc . $obj->image]);
                }
              }
              else
              {
                $imgUrl = '';
              }

          ?>
              <div class="row <?=($role != 'Commonuser' && $role != "Customer")?'':'col-md-offset-2'?> <?= (preg_match("/Others/i", $obj->type) ? 'Other-image-container' : '') ?>">
                <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> sample-img-parent-container">
                  <?php if (!preg_match("/Others/i", $obj->type)) { ?>
                    <div class="sample-image-container <?=($role != 'Commonuser' && $role != "Customer")?'hide':''?>">
                      <div class="sample-image-label text-warning">Sample - <?= $typeName[$obj->type]; ?></div>
                      <div class="sample-image-frame">
                      <video controls muted style="display: block;margin: auto;max-width: 670px;width: 100%;" src="<?= Yii::$app->urlManager->createAbsoluteUrl('images/qc_sample_images/sample_video.mp4'); ?>" class="sample-img lightboxed" rel="group1" data-link="<?= Yii::$app->urlManager->createAbsoluteUrl('images/qc_sample_images/sample_video.mp4'); ?>" alt="<?= $obj->type ?>" data-caption="<?= $obj->type ?>"></video>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> actual-img-parent-container">
                  <input type="hidden" id="h-<?= $obj->type; ?>" value="<?= $obj->image; ?>" data-id="<?= $obj->id ?>">

                  <div class="actual-image-container <?= ($obj->type == 'vehicleVideo') ? 'actual-video-container' : '' ?>">

                    <?php if (!preg_match("/Others/i", $obj->type)) { ?>
                      <div class="actual-image-label text-success">Actual - <?= $typeName[$obj->type]; ?></div>
                    <?php } else if (preg_match("/Others/i", $obj->type)) { ?>
                      <div class="actual-image-label"><?= $obj->type; ?></div>
                    <?php } ?>

                    <div class="actual-image-frame<?= ($imgUrl) ? '' : ' minheight-0'; ?>">
                      <!-- <?= Html::a('Preview Video', '' . $imgUrl . '', ['class' => 'btn btn-primary', 'target' => '_blank']) ?> -->
                      <?php if ($imgUrl != '') { ?>
                      <video src="<?= $imgUrl; ?>" id="<?= $obj->type; ?>" class="actual-img <?= ($imgUrl != '') ? 'lightboxed' : '' ?>" controls></video>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="text-center">
                    <div class="btn btn-primary cm-<?= $obj->type; ?> mt-10 <?=($imgUrl != '')?'hide':''?>" data-type="<?= $obj->type; ?>" style="width: 200px;"><?=FAS::icon('camera')?> Take Vehicle Video</div>
                    <?= Html::a(FA::icon('trash-alt').' Remove', '#', ['class' => 'btn btn-danger remove-image mt-10', 'id' => '' . $obj->id . '']) ?>
                  </div>
                  <div class="clear" style="margin: 10px;"></div>
                </div>
              </div>
              <div class="border-bottom"></div>

          <?php }
          }  ?>
          <div class="clear"></div>
       </div>
    </div>
    <div class="panel panel-primary">

      <div class="clearfix">
        <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#inspection_capture_photos">Take Photos </h4>
        <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#inspection_capture_photos']); ?>
      </div>
      <div id="inspection_capture_photos" class="preinspection-box collapse">
        <div class="panel-body">
          <div class="col-md-12 text-center">
            <h4 class="text-limered">Registration No : <?= $premodel->registrationNo ?></h4>
          </div>

          <?php if ($role != 'Commonuser' && $role != "Customer") { ?>
            <div class="col-sm-12 text-center mt-25">
              <a href="javascript:void(0)" class="btn btn-success sample-img-visibility-btn">Show Sample Images</a>
              <!-- <a href="<?=Yii::$app->urlManager->createAbsoluteUrl(['axion-preinspection/image-list?id='.$premodel->id])?>" class="btn btn-info" target="new">Advanced Zoom <?=FA::icon('search-plus')?></a> -->
            </div>
          <?php } ?>

          <input type="hidden" name="" id="photoType">

          <!-- For images -->
          <?php foreach ($phmodel as $obj) {
            if ($obj->type != 'vehicleVideo' && !preg_match("/BO-Others/i", $obj->type)) {

              if ($obj->image != '')
              {
                $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
                $s3FileExists =  '';//S3Helper::fileExists($imgUrl);

                if ($s3FileExists['status'])
                {
                  $imgUrl = $s3FileExists['data']['url'];
                }
                else
                {
                  // $imgUrl = Yii::$app->urlManager->createAbsoluteUrl(['/' . $qcLoc . $obj->image]);
                  $imgUrl = Yii::$app->urlManager->createAbsoluteUrl(['/' . $qcLoc . $obj->image]);
                }
              }
              else
              {
                $imgUrl = '';
              }

              $otherImages = 0;
              if (preg_match("/Others/i", $obj->type)) {
                $otherImages = str_replace("Others-", "", $obj->type);
              }

              $MagicZoomPlusActualOptions = "group: Actual; zoom-position:left; zoom-height:250px; zoom-width:300px; expand-size: fit-screen; expand-position: center; opacity-reverse:true; background-opacity: 90; show-title: top;";
              $MagicZoomPlusSampleOptions = "group: Sample; zoom-position:left; zoom-height:250px; zoom-width:300px; expand-size: fit-screen; expand-position: center; opacity-reverse:true; background-opacity: 90; show-title: top;";
              $NoImageOptions = "disable-zoom: true; disable-expand: true;";
          ?>
              <div class="row <?=($role != 'Commonuser' && $role != "Customer")?'':'col-md-offset-2'?> <?= (preg_match("/Others/i", $obj->type) ? 'Other-image-container' : '') ?>">
                <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> sample-img-parent-container">
                  <?php if (!preg_match("/Others/i", $obj->type)) { ?>
                    <div class="sample-image-container <?=($role != 'Commonuser' && $role != "Customer")?'hide':''?>">
                      <div class="sample-image-label text-warning">Sample - <?= $typeName[$obj->type]; ?></div>
                      <div class="sample-image-frame">
                        <!-- <img src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/images/qc_sample_images/' . $obj->type . '.png']); ?>" class="sample-img lightboxed" rel="group1" data-link="<?= Yii::$app->urlManager->createAbsoluteUrl(['/images/qc_sample_images/' . $obj->type . '.png']); ?>" alt="<?= $obj->type ?>" data-caption="<?= $obj->type ?>"> -->
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/images/qc_sample_images/' . $obj->type . '.png']); ?>" class="MagicZoomPlus sample-img" rel="<?=$MagicZoomPlusSampleOptions?>"  title="<?= 'Sample - '.$obj->type; ?>">
                          <img src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/images/qc_sample_images/' . $obj->type . '.png']); ?>" alt="<?= $obj->type ?>">
                        </a>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> actual-img-parent-container">
                  <input type="hidden" id="h-<?= $obj->type; ?>" value="<?= $obj->image; ?>" data-id="<?= $obj->id ?>">

                  <div class="actual-image-container <?= ($obj->type == 'vehicleVideo') ? 'actual-video-container' : '' ?>">

                    <?php if (!preg_match("/Others/i", $obj->type)) { ?>
                      <div class="actual-image-label text-success">Actual - <?= $typeName[$obj->type]; ?></div>
                    <?php } else if (preg_match("/Others/i", $obj->type)) { ?>
                      <div class="actual-image-label text-success"><?= $obj->type; ?></div>
                    <?php } ?>

                    <div class="actual-image-frame<?= ($imgUrl) ? '' : ' minheight-0'; ?>">
                      <?php if ($obj->type != 'vehicleVideo') { ?>
                        <!-- <img src="<?= $imgUrl; ?>" id="<?= $obj->type; ?>" class="actual-img <?= ($imgUrl != '') ? 'lightboxed' : '' ?>" rel="group2" data-link="<?= $imgUrl; ?>" <?= ($imgUrl != '') ? 'alt="' . $obj->type . '"' : ''; ?> data-caption="<?= $obj->type ?>"> -->
                        <a href="<?=$imgUrl;?>" class="MagicZoomPlus actual-img <?= ($imgUrl != '') ? 'lightboxed' : '' ?>" rel="<?=($imgUrl != '')?$MagicZoomPlusActualOptions:$NoImageOptions;?>" title="<?= 'Actual - '.$obj->type; ?>">
                          <img src="<?=($imgUrl)?$imgUrl:Yii::$app->urlManager->createAbsoluteUrl(['images/No_Image.jpg']);?>" id="<?= $obj->type; ?>" data-link="<?= $imgUrl; ?>" <?= ($imgUrl != '') ? 'alt="' . $obj->type . '"' : ''; ?>>
                        </a>
                      <?php } else if ($imgUrl != '' && $obj->type == 'vehicleVideo') { ?>
                        <!-- <?= Html::a('Preview Video', '' . $imgUrl . '', ['class' => 'btn btn-primary', 'target' => '_blank']) ?> -->
                        <video src="<?= $imgUrl; ?>" id="<?= $obj->type; ?>" class="actual-img <?= ($imgUrl != '') ? 'lightboxed' : '' ?>" controls></video>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="text-center">
                    <div class="btn btn-primary cm-<?= $obj->type; ?> mt-10 <?=($imgUrl != '')?'hide':''?>" data-type="<?= $obj->type; ?>" style="width: 200px; white-space: pre-wrap;"><?=FAS::icon('camera')?> Take <?= ($obj->type == 'rcCopy')?'rcImageFront':$obj->type; ?></div>
                    <?= Html::a(FA::icon('trash-alt').' Remove', '#', ['class' => 'btn btn-danger remove-image mt-10', 'id' => '' . $obj->id . '']) ?>
                    <?php if (($obj->type != 'vehicleVideo' && $imgUrl != '') && ($role == 'Superadmin' || $role == 'Admin' || $role == 'BO User')) { ?>
                      <?= Html::button(FA::icon('redo').' Rotate', ['type' => 'button', 'class' => 'btn btn-warning rotate-image mt-10', 'id' => $obj->id, 'data-href' => $imgUrl, 'data-type' => $obj->type]) ?>
                    <?php } ?>
                  </div>
                  <div class="clear" style="margin: 10px;"></div>
                </div>
              </div>
              <div class="border-bottom"></div>

          <?php }
          }  ?>

          <!--  Other Images -->
          <div class="row <?=($role != 'Commonuser' && $role != "Customer")?'':'col-md-offset-2'?> Other-image-container">
            <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> sample-img-parent-container">
            </div>
            <div class="<?=($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4'?> actual-img-parent-container">
              <input type="hidden" id="h-Others-<?= $otherImages + 1 ?>" value="" data-id="">
              <div class="actual-image-container">
                <div class="actual-image-label text-success">Others-<?= $otherImages + 1 ?></div>
                <div class="actual-image-frame minheight-0">
                  <!-- <img src="" id="Others-<?= $otherImages + 1 ?>" class="actual-img" rel="group2" data-link="<?= $imgUrl; ?>" data-caption="Others-<?= $otherImages + 1 ?>">-->                  
                  <a href="javascript:void(0);" class="MagicZoomPlus actual-img" rel="<?=$NoImageOptions;?>" title="Others-<?= $otherImages + 1 ?>">
                    <img src="<?=Yii::$app->urlManager->createAbsoluteUrl(['images/No_Image.jpg'])?>" id="Others-<?= $otherImages + 1 ?>">
                  </a>
                </div>
              </div>
              <div class="text-center">
                <div class="btn btn-primary cm-Others-<?= $otherImages + 1 ?> mt-10" data-type="Others-<?= $otherImages + 1 ?>" style="width: 200px;"><?=FAS::icon('camera')?> Take Others-<?= $otherImages + 1 ?></div>
                <?= Html::a(FA::icon('trash-alt').' Remove', '#', ['class' => 'btn btn-danger remove-image mt-10', 'id' => '']) ?>
              </div>
              <div class="clear" style="margin: 10px;"></div>
            </div>
          </div>
          <div class="border-bottom"></div>
          <!-- For Vehicle Video -->
          <div class="clear"></div>
        </div> <!-- End Panel Body -->
      </div> <!-- End #inspection_capture_photos -->

    </div> <!-- End Panel -->
    <div class="panel panel-primary">
        <div class="clearfix">
            <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#document_upload_photos">Upload Documents </h4>
            <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#document_upload_photos']); ?>
        </div>
        <div id="document_upload_photos" class="preinspection-box collapse" style="margin-bottom: 30px">
                
                <div class="panel-body pt-10">
                    <table id="upload-file-table-<?=$premodel->referenceNo;?>" width="300" class="table table-bordered upload-file-table">
                    <tr class="table-heading" style="z-index: 9;position: relative;">
                        <th class="text-center">#</th>
                        <th  class="text-center">File Name</th>
                        <!-- <th  class="text-center">Uploaded</th> -->
                        <th class="text-center">File Preview</th>
                    </tr>   
                    <?php
                        $rowCnt1 = 1;
                        $vaildationArray = [];
                        if($role != 'Garage Workshop' || $role != 'Customer'){
                            $imageArray = ['RC FRONT', 'RC BACK'];
                            $vaildationArray = [1,0,0,1,1,1,0,1,0,0,0,1,1,0,0,1,0];
                        }else{
                            $imageArray = ['Estimate', 'Estimate2', 'Estimate3','DL Front','DL Back','Policy','RC Front','RC Back','Permit','Fitness FC','Claims Form', 'Satisfaction Voucher', 'Pan Card','Adhaar Card','Cancelled Cheque Or Bank Details','Permit Authorization'];
                            $vaildationArray = [1,0,0,1,1,1,1,0,0,0,1,1,0,0,1,0];
                        }
                        for($ia=0;$ia < count($imageArray) ;$ia++){
                            $validate = $vaildationArray[$ia] == 1 ? 'required' : '';
                            $otherfile = AxionCliamsueryDocUploads::findOne(['referenceNo' => $premodel->referenceNo,'type' => $imageArray[$ia]]);
                            // echo $taskPrefix.''.str_replace(" ","_",$imageArray[($premodel->referenceNo- 1)][$ia]).'<br>';
                            // echo '~~'.$tasklist.'~~<br>';
                            $fileExtension = '';
                            $uploadBtnHide = "";
                            $removeBtnHide = "";
                            $otherfileId = 0;
                            if(count($otherfile) > 0){
                                $fileExtension = explode('.',$otherfile->file_name)[1];                        
                                $removeBtnHide = "";
                                $uploadBtnHide = " d-none";
                                $otherfileId = $otherfile->id;
                            }else{
                                $removeBtnHide = " d-none";
                                $uploadBtnHide = "";
                            } 
                            $otherfileID = $otherfile->id ?? 0;
                            // echo 'VJ - '.$otherfile->uploaded;
                            echo '<tr class="file_upload_sec '.$validate.'" id="file_upload_sec_'.$premodel->referenceNo.''.$rowCnt.'">';
                                echo '<td class="indexno"><input type="hidden" name="otherfile_ids[]" value="'.$otherfileID.'"><span>'.$rowCnt1.'</span></td>';
                                echo '<td>'.$form->field($docuploadmodel, 'other_label['.$premodel->referenceNo.''.$rowCnt.']')->textInput(['value' => null, 'type' => 'hidden', 'class' => 'visibility-hidden'])->label(false).'<input type="text" class="form-control" readonly value="'.$imageArray[$ia].'"></input>';
                                if($otherfile->text_extract != ''){
                                    echo '<div id="'.str_replace(" ","-",$imageArray[$ia]).'-Extract">';
                                    echo '<input type="hidden" class="inputid" value="'.$premodel->referenceNo.''.$rowCnt.'">';
                                    // echo'<label style="width:100%;" class="control-label mt-10 mb-10 text-left">'.$imageArray[$ia].' Extract</label>';
                                    // echo'<textarea class="form-control" rows="4" cols="50">'.$otherfile->text_extract.'</textarea>';
                                    echo '</div>';
                                }
                                echo '</td>';
                                // echo '<td class="label-disabled">'.$form->field($docuploadmodel, 'uploaded['.$premodel->referenceNo.''.$rowCnt.']')->checkbox(['checked' => $otherfile->uploaded === "Y"]).'</td>';
                                // echo '<td>'.$form->field($docuploadmodel, 'verified['.$premodel->referenceNo.''.$rowCnt.']')->checkbox(['checked' => $otherfile->verified === "Y"]).'</td>';
                                echo '<td class="file-upload"><div class="preview-file">';
                                if($fileExtension != '' && $fileExtension == 'pdf'){
                                echo '<iframe src="'.Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$otherfile->file_name.'"></iframe>';
                                }elseif($fileExtension != '' && $fileExtension != 'pdf'){
                                echo '<img src="'.Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$otherfile->file_name.'"/>';
                                }
                                echo '</div>'.$form->field($docuploadmodel, 'type['.$imageArray[$ia].']')->fileInput(['class' => 'upload_file visibility-hidden','accept' => 'application/pdf,image/*'])->label(false).''.Html::a(FA::icon('upload').' Upload','javascript:void(0);',['class' => 'btn btn-success upload-file'.$uploadBtnHide]).' '.FA::icon('trash-alt', ['class' => 'btn btn-danger remove-file'.$removeBtnHide, 'data-id' => $otherfileId, 'data-taskid' => $premodel->referenceNo,'data-type' => $otherfile->type]).'</td>';
                            echo '</tr>';
                            $rowCnt++;
                            $rowCnt1++;
                        }
                        // 
                        $otherfileOthers = AxionCliamsueryDocUploads::find()->where(['referenceNo' => $premodel->referenceNo,'type' => 'Other'])->orderBy('created_on ASC')->all();
                        foreach($otherfileOthers as $othrfile){
                        if(count($othrfile) > 0){
                            $fileExtension = explode('.',$othrfile->file_name)[1];                        
                            $removeBtnHide = "";
                            $uploadBtnHide = " d-none";
                            $otherfileId = $othrfile->id;
                        }else{
                            $removeBtnHide = " d-none";
                            $uploadBtnHide = "";
                        } 
                        echo '<tr class="other_file_upload_sec" id="other_file_upload_sec_'.$premodel->referenceNo.''.$rowCnt.'">';
                            echo '<td class="indexno"><input type="hidden" name="otherfile_ids[]" value="'.$otherfileId.'"><span>'.$rowCnt1.'</span></td>';
                            echo '<td>'.$form->field($docuploadmodel, 'other_label[OTH_Other_0'.$premodel->referenceNo.''.$rowCnt.']')->textInput(['value' => $othrfile->other_label])->label(false).'</td>';
                            // echo '<td class="label-disabled">'.$form->field($docuploadmodel, 'uploaded['.$premodel->referenceNo.''.$rowCnt.']')->checkbox(['checked' => $othrfile->uploaded === "Y"]).'</td>';
                            // echo '<td>'.$form->field($docuploadmodel, 'verified['.$premodel->referenceNo.''.$rowCnt.']')->checkbox(['checked' => $othrfile->verified === "Y"]).'</td>';
                            echo '<td class="file-upload"><div class="preview-file">';
                            if($fileExtension != '' && $fileExtension == 'pdf'){
                            echo '<iframe src="'.Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$othrfile->file_name.'"></iframe>';
                            }elseif($fileExtension != '' && $fileExtension != 'pdf'){
                            echo '<img src="'.Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$othrfile->file_name.'"/>';
                            }
                            echo '</div>'.$form->field($docuploadmodel, 'type[OTH_Other_0'.$premodel->referenceNo.''.$rowCnt.']')->fileInput(['class' => 'upload_file visibility-hidden','accept' => 'application/pdf,image/*'])->label(false).''.Html::a(FA::icon('upload').' Upload','javascript:void(0;',['class' => 'btn btn-success upload-file'.$uploadBtnHide]).''.Html::a(FA::icon('eye', ['class'=>'btn btn-primary view-file'.$removeBtnHide,'data-id' => $otherfileId, 'data-taskid' => $premodel->referenceNo]),'javascript:void(0;',[
                              'class' => 'activity-view-link',
                              'title' => Yii::t('yii', 'View'),
                              'data-toggle' => 'modal',
                              'data-target' => '#view-doc-modal',
                              'data-link' => Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$othrfile->file_name,
                              'data-pjax' => '0',
                            ]).' '.Html::a(FA::icon('download', ['class' => 'btn btn-warning download-file'.$removeBtnHide]), 'javascript:void(0;', [
                              'class' => 'activity-download-link',
                              'title' => Yii::t('yii', 'Download'),
                              'data-link' => Url::base(true).'/images/claimsurvey-doc-upload/'.$premodel->referenceNo.'-docs-upload/'.$othrfile->file_name,
                              'data-pjax' => '1',
                            ]).' '.FA::icon('trash-alt', ['class' => 'btn btn-danger remove-file'.$removeBtnHide, 'data-id' => $otherfileId, 'data-taskid' => $premodel->referenceNo,'data-type' => $otherfile->type]).'</td>';

                            

                        echo '</tr>';
                        $rowCnt++;
                        $rowCnt1++;
                        }
                    ?>
                    </table>
                    <?php
                        $otherfile = AxionCliamsueryDocUploads::findOne(['referenceNo' => $premodel->referenceNo,'type' => 'insured_payment_proof']);
                        $fileExtension = '';
                        $uploadBtnHide = "";
                        $removeBtnHide = "";
                        $otherfileId = 0;
                        if(count($otherfile) > 0){
                            $fileExtension = explode('.',$otherfile->file_name)[1];                        
                            $removeBtnHide = "";
                            $uploadBtnHide = " d-none";
                            $otherfileId = $otherfile->id;
                        }else{
                            $removeBtnHide = " d-none";
                            $uploadBtnHide = "";
                        } 
                        $otherfileID = $otherfile->id ?? 0;
                    ?>                    
                    
      
      
                    
                </div>
            </div>
      </div>
       
    </div> <!-- End Right Side Panel -->


  <?php if ($role == 'Superadmin' || $role == 'Admin' || $role == 'BO User' || $role == 'Veyes UAT') { ?>
    <div class="col-sm-12 mt-30">
      <div class="panel panel-primary" style="display: none;">

        <div class="clearfix">
          <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#inspection_photos">Upload Photos </h4>
          <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#inspection_photos']); ?>
        </div>

        <div id="inspection_photos" class="preinspection-box collapse" style="margin-bottom: 30px">
          <div class="panel-body">
            <?php
            $z = 1;
            foreach ($phmodel as $obj) {

              // BO-Others photo section is only allowed for BO-Users
              //if ( ($role == 'BO User' &&  preg_match("/^BO-Others-/i", $obj->type) ) || $role != 'BO User') {
              // Only Images

              $skip_images = ['cngLpgKit', 'dickyOpenImage', 'odometerWithRPMReading', 'closeupViewOfOdometerReading', 'frontWindshieldFromOutside', 'rcImageFront', 'preInsuranceCopy', 'dashBoardPhoto', 'dentsScratchImage1', 'dentsScratchImage2', 'dentsScratchImage3', 'vehicleVideo'];
              if (!in_array($obj->type, $skip_images) && !preg_match('/Others-/i', $obj->type)) {

                if (($obj->type == "chassisThumb")) {
                  $style = "style='color:red;'";
                  $typeName[$obj->type] = 'Chassis Thumb*';
                } elseif ($obj->type == "enginePhoto") {
                  $style = "style='color:red;'";
                  $typeName[$obj->type] = 'Engine Photo*';
                } elseif ($obj->type == "underChassis") {
                  $style = "style='color:red;'";
                  $typeName[$obj->type] = 'Under Chassis*';
                } elseif ($obj->type == "odometerReading") {
                  $style = "style='color:red;'";
                  $typeName[$obj->type] = 'Odometer Reading*';
                } elseif ($obj->type == "RC Image Front") {
                  $style = "style='color:red;'";
                  $typeName[$obj->type] = 'RC Image Front*';
                } else {
                  $style = "";
                }


                $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
                $s3FileExists =  '';//S3Helper::fileExists($imgUrl);

                if ($s3FileExists['status'])
                {
                  $imgUrl = $s3FileExists['data']['url'];
                }
                else
                {
                  $imgUrl = Yii::$app->urlManager->createAbsoluteUrl([$qcLoc . $obj->image]);
                }

                if ($z == 1)
                  echo '<div class="row">';

                echo '<div class="col-sm-4 col-lg-2 form-prerow-image"' . $style . '>';
                /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                                          'options' => ['accept' => 'image/*;capture=camera'],
                          ])->label($typeName[$obj->type]); */
                echo $form->field($obj, 'image[' . $obj->type . ']')->widget(FileInput::classname(), [
                  'class' => 'image-widget',
                  'options' => ['multiple' => false, 'accept' => 'image/*'],
                  'pluginOptions' => [
                    'uploadUrl' => Url::to(['/axion-preinspection/image-uploadbrowse']),
                    'uploadExtraData' => [
                      'id' => $obj->preinspection_id,
                      'type' => $obj->type,
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
                    'overwriteInitial' => true,
                    'initialPreviewAsData' => true,
                    'initialCaption' => $obj->image ? $obj->type : '',
                    'initialPreviewConfig' => [
                      [
                        'caption' => $obj->locStatus ? $locStatus[$obj->locStatus] . " <br>" . $timeStatus[$obj->timeStatus] : '',
                        'size' => '',
                        'url' => Url::to(['/axion-preinspection/remove-photobrowse']),
                        'key' => $obj->id,
                      ],

                    ],
                  ],
                  'pluginEvents' => [
                    'fileuploaded' => "function(event, data, previewId, index) {
                        let damageRespone = data.response.damageRespone;
                        // if(damageRespone.length > 0){
                          // alert(damageRespone.length);
                          $.each(damageRespone, function(key, value) {
                            // alert(key+'~~'+value);
                            $('#axionpreinspectionfwheeler-'+key).val(value);
                          });
                        // }
                    }",
                  ],
                ])->label($typeName[$obj->type]);
                if ($obj->type == 'vehicleVideo' && $obj->image != '') {
                  echo Html::a('Preview Video', '' . $imgUrl . '', ['class' => 'btn btn-primary', 'target' => '_blank']);
                }

                echo '</div>';
                if ($z == 6)
                  echo '</div>';

                $z++;
                if ($z == 7)
                  $z = 1;

              }

              //}

            }


            /**** Start Bulk Upload ***/

            // Checks whether row already closed or not
            if ($z != 1) {
              echo '</div>';
            }

            echo '<div class="row"><div class="col-sm-4 form-prerow-image">';

              echo $form->field($phmodel[0], 'image[Others]')->widget(FileInput::classname(), [
                'options' => ['multiple' => true, 'accept' => 'image/*'],
                'pluginOptions' => [
                  'uploadUrl' => Url::to(['/axion-preinspection/image-uploadbrowse']),
                  'uploadExtraData' => [
                    'id' => $phmodel[0]->preinspection_id,
                    'type' => 'Others',
                  ],
                  'allowedFileExtensions' => ["jpg", "jpeg"],
                  //'maxImageWidth' => 500,
                  //'maxImageHeight' => 500,
                  'resizePreference' => 'height',
                  'maxFileCount' => 10,
                  'resizeImage' => true,
                  'resizeIfSizeMoreThan' => 100,
                  'showRemove' => true,
                  'showUpload' => true,
                  'overwriteInitial' => true,
                  'initialPreviewAsData' => true,
                  'initialCaption' => $phmodel[0]->image ? 'Others' : '',
                  'initialPreviewConfig' => [
                    [
                      'caption' => $phmodel[0]->locStatus ? $locStatus[$phmodel[0]->locStatus] . " <br>" . $timeStatus[$phmodel[0]->timeStatus] : '',
                      'size' => '',
                      'url' => Url::to(['/axion-preinspection/remove-photobrowse']),
                      'key' => $phmodel[0]->id,
                    ],

                  ],
                ],
              ])->label('Others (Multiple Images)');
            echo '</div>';

            /**** End Bulk Upload ***/


            foreach ($phmodel as $obj) {
              // Video section only allowed for admin
              if ($obj->type == 'vehicleVideo') { //&& $role != 'BO User'

                $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
                $s3FileExists =  '';//S3Helper::fileExists($imgUrl);

                if ($s3FileExists['status'])
                {
                  $imgUrl = $s3FileExists['data']['url'];
                }
                else
                {
                  $imgUrl = Yii::$app->urlManager->createAbsoluteUrl([$qcLoc . $obj->image]);
                }

                echo '<div class="col-sm-4 col-lg-2 form-prerow-image">';
                /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                                        'options' => ['accept' => 'image/*;capture=camera'],
                        ])->label($typeName[$obj->type]); */
                echo $form->field($obj, 'image[' . $obj->type . ']')->widget(FileInput::classname(), [
                  'options' => ['multiple' => false, 'accept' => 'video/*'],
                  'pluginOptions' => [
                    'uploadUrl' => Url::to(['/axion-preinspection/image-uploadbrowse']),
                    'uploadExtraData' => [
                      'id' => $obj->preinspection_id,
                      'type' => $obj->type,
                    ],
                    'initialPreview' => [
                      $obj->image ? $imgUrl : null, // checks the models to display the preview
                    ],
                    'allowedFileExtensions' => ["mp4"],
                    //'maxImageWidth' => 500,
                    //'maxImageHeight' => 500,
                    'resizePreference' => 'height',
                    'maxFileCount' => 1,
                    'resizeImage' => true,
                    'resizeIfSizeMoreThan' => 100,
                    'showRemove' => false,
                    'showUpload' => false,
                    'overwriteInitial' => true,
                    'initialPreviewAsData' => true,
                    'initialCaption' => $obj->image ? $obj->type : '',
                    'initialPreviewConfig' => [
                      [
                        'caption' => $obj->locStatus ? $locStatus[$obj->locStatus] . " <br>" . $timeStatus[$obj->timeStatus] : '',
                        'size' => '',
                        'url' => Url::to(['/axion-preinspection/remove-photobrowse']),
                        'key' => $obj->id,
                      ],

                    ],
                  ],
                ])->label($typeName[$obj->type]);
                if ($obj->type == 'vehicleVideo' && $obj->image != '') {
                  echo Html::a('Preview Video', '' . $imgUrl . '', ['class' => 'btn btn-primary', 'target' => '_blank']);
                }

                echo '</div></div>';

              }
            }

            ?>
            <div class="clear"></div>
          </div> <!-- End Panel Body -->
        </div> <!-- End #inspection_photos -->

      </div> <!-- End Panel -->
    </div>

    <div class="col-sm-12 mt-30">
      <div class="panel panel-primary" style="display: none;">
          <div class="clearfix collapse-side-heading">
              <h4 class="preinspection-box-title pull-left panel-heading" data-toggle="collapse" data-target="#ai_photos">AI Processed Photos and Documents</h4>
              <?= FA::icon('plus-circle', ['class' => 'pull-right text-warning qc-collapse-icon', 'data-toggle' => 'collapse', 'data-target' => '#ai_photos']); ?>
          </div>

          <div id="ai_photos" class="preinspection-box collapse">
              <div class="panel-body">
                  <?php
                      foreach($aiphotomodel as $aiobj)
                      {
                          if($aiobj->image != '')
                              $aiimgUrl = Yii::$app->urlManager->createAbsoluteUrl($aiobj->image);
                          else
                              $aiimgUrl = ''; ?>

                          <div class="col-md-3">
                              <div class="">
                                  <img style="width:100%;" src="<?=($aiimgUrl)?$aiimgUrl:Yii::$app->urlManager->createAbsoluteUrl('images/No_Image.jpg'); ?>" id="<?php echo $aiobj->type; ?>" />
                              </div>
                              <div style="margin:10px auto;"> <?php echo $aiobj->type; ?> </div>
                          </div>

                      <?php }
                  ?>
              </div>
          </div>
      </div>
    </div>
  <?php } ?>


  <div class="clear"></div>
  <?php echo Html::hiddenInput('bLat', '', ['id' => 'bLat']); ?>

  <?php echo Html::hiddenInput('bLong', '', ['id' => 'bLong']); ?>

  <div class="form-group" style="text-align: center;margin-top: 30px;">
    <?= Html::submitButton('Next', ['class' => 'btn btn-primary', 'id' => 'savebtn']) ?>
    <!-- <?= Html::a('Submit and Generate Report', '#', ['class' => 'btn btn-primary']) ?> -->

    <?php if ($role != 'Customer' && $role != '') { ?>
      <?php if ($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {
        echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Submit and Generate Report', ['/axion-preinspection/vehicleqcpdf?id=' . $premodel->id], [
          'class' => 'btn btn-danger',
          'target' => '_blank',
          'data-toggle' => 'tooltip',
          'title' => 'Will open the generated PDF file in a new window'
        ]);
      } ?>
      <?php if ($premodel->status == 101 || $premodel->status == 102 || $premodel->status == 104) {
        echo Html::a('Download Photos', ['/axion-preinspection/downloadphotos?id=' . $premodel->id], [
          'class' => 'btn btn-primary',
          'data-toggle' => 'tooltip',
          'title' => 'Download Photos'
        ]);
      } ?>
    <?php } ?>
    
      <?= Html::a('Close', 'javascript:window.close();', ['class' => 'btn btn-primary']) ?>
   
    <?php if ($role == 'Customer') { ?>
      <?= Html::a('Close', Url::to(['/site/logout']), ['data-method' => 'post', 'class' => 'btn btn-primary']) ?>
    <?php } ?>
  </div>
  <?php ActiveForm::end(); ?>

</div><!-- axion-preinspection-fourwheelerqc -->


<?php $this->registerJs(
  "$('.remove-image').on('click', function(){
    if (!confirm('Are you sure to delete?')) {
      return false;
    }
    var id = $(this).attr('id');
    //alert('#photo-'+id);
    //return false;
    $.post(
        '" . Yii::$app->request->baseUrl . "/axion-preinspection/remove-photo',
        {
            id : id,
        },
        function (data) {
          $('#'+data).attr('src', '" . Yii::$app->urlManager->createAbsoluteUrl (['/images/No_Image.jpg']). "').removeAttr('alt').parent('.actual-image-frame');
          $('#'+data).parent('a').attr({'href': 'javascript:void(0)', 'rel': 'disable-zoom: true; disable-expand: true;'}).removeClass('lightboxed');

          if ($('#'+data).prop('tagName').toLowerCase() == 'video') {
            $('#'+data).remove();
          }
          $('#h-' + data).val('');
          $('.cm-' + data).removeClass('hide');
        }
      );
       return false;
});"
);


$style = <<< CSS

/* File Upload Table */
.upload-file-table input{
max-width: 175px!important;
width: 100%;
}
.upload-file-table .file-upload .form-group, .upload-file-table .file-upload input{
width:0px!important;
height: 0;
padding: 0;
margin: 0;
}
.upload-file-table tr, .upload-file-table td{
vertical-align:middle!important;
text-align: center;
}
.preview-file img, .preview-file iframe {
max-width: 300px;
height: auto;
object-fit: contain;
margin-bottom: 10px;
width: 100%;
}
@media(min-width:575px){
.upload-file-table input, .preview-file img, .preview-file iframe {
    width: 100%;
}
}
.field-axioncliamsuerydocuploads-type-insured_payment_proof {
  height: 0px;
  margin: 0;
  padding: 0;
}
.insured_payment_details .form-group{
    margin:0px;
}
.insured_payment_details_sec{
    margin-bottom:20px;
}
#view-doc-modal .modal-dialog {
  width: 75vw;
}
.error-msg{
  color:red;
  font-size:12px;
  font-weight:600;
}
#axionclaimsurvey-insured_payment_amount{
  max-width: 170px;
}
.text-left{
    text-align:left;
}
.insure_radio_btn_sec label, .insure_radio_btn_sec .help-block{
    margin-bottom:0px;
}
@media(max-width:767px){
    .insure_radio_btn_sec label {
        display: grid;
        grid-template-columns: 15px auto;
        justify-content: start;
        gap:10px;
    }
}
@media(min-width:768px){
    .insure_radio_btn_sec .grid-col-2{
        display:grid;
        grid-template-columns:repeat(2,140px);
    }
}
#parivahan_details ul {
  column-count: 2;
  padding: 0;
  list-style: none;
}
.parivahan-check label{
    color: #ff7e0c!important;
}
.parivahan-check input{
    color: #ff7e0c!important;
    border-color: #ff7e0c!important;
}
@media(min-width:768px){
    .parivahan-extract-lists {
        column-count: 2;
    }
}
.extract-list-item {
  display: grid;
  grid-template-columns: 50% 50%;
  align-items: center;
  gap: 0;
}
.extract-list-item span {
  padding: 10px;
  border-bottom: 1px solid;
  height: 100%;
  font-size: 14px;
  font-weight: 600;
}
.extract-list-item .item-label {
  background: #45c5ec;
  display: inline-block;
  width: 100%;
  text-transform:capitalize;
}
/* label-disabled */
.label-disabled {
  cursor: not-allowed;
}
.label-disabled label{
    pointer-events: none;
}
/*  */
@media(max-width:480px){
    .table.upload-file-table th:not(.data-view-table .table th), .upload-file-table input, .upload-file-table label{
        font-size: 12px;
    }
    #document_upload_photos .panel-body{
        padding:3px!important;
    }
}
@media(max-width:380px){
    i.remove-file{
        margin-top:4px;
    }
}
.table.upload-file-table .form-group, .table.upload-file-table .help-block {
  margin: 0px!important;
}
.rotate-right , .rotate-left{
    text-decoration:none!important;
    width: 75px;
    display: inline-block;
}
.rotate-right span, .rotate-left span{
    display:block;
    width: auto;
    font-size: 12px;
}
.rotate-div{
    display:none;
}
.rotate-div.show{
    display:block;
}

//   body{
//   margin: 0;
//   padding: 0;
//   height: 100%;
//   width: 100%;
// }


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
    top: 40px;
    right: 20px;
    z-index: 2;
}
CSS;
$this->registerCss($style);
?>


<?php
$script = <<< JS
$('#AxionPreinspectionVehicle').on('beforeSubmit',function(e) {
    e.preventDefault();

    var companyId = $('#companyId').val();

    if ($('#axionpreinspectionvehicle-vcategory').val() == '' && companyId == 10)
    {
      alert('Please select vehicle category');
      return false;
    }

    var chassisThumb = $('#axionpreinspectionphotos-image-chassisthumb').val();
    var hchassisThumb=$('#h-chassisThumb').val();

    var odometer_reading=$('#axionpreinspectionphotos-image-odometerreading').val();
    var hodometerReading=$('#h-odometerReading').val();

    var rcCopy=$('#axionpreinspectionphotos-image-rccopy').val();
    var hrcCopy=$('#h-rcCopy').val();

    var enginephoto=$('#axionpreinspectionphotos-image-enginephoto').val();
    var henginePhoto=$('#h-enginePhoto').val();

    var underchassis=$('#axionpreinspectionphotos-image-underchassis').val();
    var hunderChassis=$('#h-underChassis').val();

    var vehicleVideo=$('#axionpreinspectionphotos-image-vehiclevideo').val();
    var hvehicleVideo=$('#h-vehicleVideo').val();

    var hConveyanceApprovalImg = $('#h-conveyanceApprovalImg').val();
    var conveyanceApproval=$('#axionpreinspection-conveyanceapproval').val();
    var conveyanceApprovalImg=$('#axionpreinspection-conveyanceapprovalimg').attr('value') || $('#axionpreinspection-conveyanceapprovalimg').val();

    var role = '$role';

    /*if(hchassisThumb=='')
    {
      if (role == 'Customer') {
        alert('Upload ChassisThumb Photo');
        $('html, body').animate({scrollTop: $('#chassisThumb').offset().top - 300}, 1000);
        return false;
      }
      else if(chassisThumb=='') {
        alert('Upload ChassisThumb Photo');
        return false;
      }
    }

    if(hrcCopy=='')
    {
      if (role == 'Customer') {
        alert('Upload rcCopy Photo');
        $('html, body').animate({scrollTop: $('#rcCopy').offset().top - 300}, 1000);
        return false;
      }
      else if(rcCopy=='')
      {
        alert('Upload rcCopy Photo');
        return false;
      }
    }

    if(hodometerReading=='')
    {
      if (role == 'Customer') {
        alert('Upload Odometer Reading Photo');
        $('html, body').animate({scrollTop: $('#odometerReading').offset().top - 300}, 1000);
        return false;
      }
      else if(odometer_reading=='') {
        alert('Upload Odometer Reading Photo');
        return false;
      }
    }

    if(hunderChassis=='')
    {
      if (role == 'Customer') {
        alert('Upload UnderChassis Photo');
        $('html, body').animate({scrollTop: $('#underChassis').offset().top - 300}, 1000);
        return false;
      }
      else if(underchassis=='')
      {
        alert('Upload UnderChassis Photo');
        return false;
      }

      if (role == 'Customer') {
        alert('Upload Engine Photo');
        $('html, body').animate({scrollTop: $('#enginePhoto').offset().top - 300}, 1000);
        return false;
      }
      else if(enginephoto=='')
      {
        alert('Upload Engine Photo');
        return false;
      }
    }

    if(companyId == 5 && hvehicleVideo=='')
    {
      if (role == 'Customer') {
        alert('Upload Vehicle Video');
        $('html, body').animate({scrollTop: $('#vehicleVideo').offset().top - 300}, 1000);
        return false;
      }
      else if(vehicleVideo=='') {
        alert('Upload Vehicle Video');
        return false;
      }
    }

    if (role == 'Superadmin' || role == 'Admin' || role == 'BO User') {
      if (conveyanceApproval == 'Yes') {
        if (hConveyanceApprovalImg == '') {
          if (conveyanceApprovalImg == '' || conveyanceApprovalImg == undefined) {
            alert('Please Upload Conveyance Approval Image');
            $('html, body').animate({scrollTop: $('#axionpreinspection-conveyanceapproval').offset().top - 300}, 1000);
            return false;
          }
        }
      }
    }*/

    return true;
});

JS;
$this->registerJs($script);
?>

<?php
$url = YII::$app->request->baseUrl . '/axion-preinspection/image-rotate';
$script = <<< JS

  $('.rotate-image').click(function(e) {

    /*if (!confirm('Are you sure to rotate the image?')) {
      return false;
    }*/

    e.preventDefault();

    var rotateBtn = $(this);
    var imgUrl = $(this).data('href');
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    var type = $(this).data('type');

    $.ajax({
      url: '$url',
      type: 'POST',
      data: {
        imgUrl: imgUrl,
        id: id,
        type: type
      },
      beforeSend: function(){
        rotateBtn.html('<i class="fa fa-spinner fa-spin"></i> Rotating');
      },
      complete: function(){
        rotateBtn.html('<i class="fa fa-redo"></i> Rotate');
      },
      success: function (response){
        rotateBtn.data('href', response);
        rotateBtn.parent('div').siblings('.actual-image-container').find('.actual-image-frame img').attr('src', response);
      }
    });

  });

JS;
$this->registerJs($script);
?>

<?php
if (!Yii::$app->session->get('user.lat') || !Yii::$app->session->get('user.long')) {
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

$url = YII::$app->request->baseUrl . '/axion-preinspection/image-upload';
$urllist = YII::$app->request->baseUrl . '/axion-preinspection/pi-qc-screenlist';
$NoImageUrl = Yii::$app->urlManager->createAbsoluteUrl(['/images/No_Image.jpg']);

$rowOffset = ($role != 'Commonuser' && $role != "Customer")?'':'col-md-offset-2';
$colOffset = ($role != 'Commonuser' && $role != "Customer")?'col-xs-12':'col-xs-12 col-sm-6 col-md-4';

$script = <<< JS

//Take Photo button when clicked
$(document).on('click', '.cm-chassisThumb, .cm-frontViewNumberPlate, .cm-rearViewImage, .cm-frontBumper, .cm-rearBumper, .cm-frontLeftCorner45, .cm-frontRightCorner45, .cm-leftSideFullView, .cm-rightSideFullView, .cm-rightSideFullView, .cm-leftQtrPanel, .cm-rightQtrPanel, .cm-enginePhoto, .cm-chassisPlate, .cm-dickyOpenImage, .cm-underChassis, .cm-dashBoardPhoto, .cm-odometerReading, .cm-odometerWithRPMReading, .cm-closeupViewOfOdometerReading, .cm-frontWindshieldFromOutside, .cm-cngLpgKit, .cm-rcCopy, .cm-rcImageFront, .cm-rcImageBack, .cm-preInsuranceCopy, .cm-dentsScratchImage1, .cm-dentsScratchImage2, .cm-dentsScratchImage3, [class*="cm-Others-"]', function() {
  var clickedButton= $(this).data('type');
  $('#photoType').val(clickedButton);
  loadPopup();
});

// document.getElementById('inspection_capture_photos').addEventListener('click', function() {
//         document.getElementById('inspection_capture_photos').style.display = 'block';
//         this.style.display = 'none';
//     }
//   );


function loadPopup(){
  $('#modal-camera').modal('show');
  $("#modal-camera").on('hidden.bs.modal', function(){
    $('#cameraupload').hide();
  });

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
    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {
        track = stream.getTracks()[0];
        cameraView.srcObject = stream;
    })
    .catch(function(error) {
        console.error("Oops. Something is broken.", error);
    });
}

// Close all video and audio tracks when modal close
$("#modal-camera").on('hidden.bs.modal', function(){
  track.stop();
});


cameraTrigger.onclick = function() {

  cameraSensor.width = cameraView.videoWidth;
  cameraSensor.height = cameraView.videoHeight;
  cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
  cameraOutput.src = cameraSensor.toDataURL("image/jpeg");
  cameraOutput.classList.add("taken");
  $(cameraOutput).show();
};


$(document).ready(function(){
  $('#cameratrigger').click(function() {
    $('#cameraupload').show();
  });
});



cameraUpload.onclick = function(camerasensor) {
  return new Promise(function(resolve, reject) {
      cameraOutput.src = cameraSensor.toDataURL("image/jpeg", 1.0);
      var fullQuality = cameraOutput.src;
      //console.log(fullQuality);
      cameraOutput.classList.add("taken");
      var base64image = $('#cameraoutput').attr('src');

      $(cameraUpload).text('Uploading...').attr('disabled', 'disabled');
      //alert(base64image);return false;
      // AJAX request
      // var formValue = $(this).serialize();
      var urlParams = new URLSearchParams(window.location.search);
      var id = urlParams.get('id');
      var type = $('#photoType').val();
      var otherNumber = Number(type.replace(/Others-/i, ''));
      var photoId = ($('#h-' + type).data('id'))?$('#h-' + type).data('id'):$('#h-' + type).attr('data-id');

      $.ajax({
        // url: 'https://axionpcs.in/test/qcphotos/storeImage.php',
        url: '$url',
        type: 'post',
        data: {
            base64image: base64image,
            id:id,
            type:type,
            photoId: photoId
          },
        success: function(data){
          if (data.match(/insertedId/i)) {
            var resp = JSON.parse(data);
            if (resp.imgUrl != undefined && resp.imgUrl != '') {
              data = resp.imgUrl;
              var insertedId = resp.insertedId;
            }
          }

          var rel = "group: Actual; zoom-position:left; zoom-height:250px; zoom-width:300px; expand-size: fit-screen; expand-position: center; opacity-reverse:true; background-opacity: 90; show-title: top;";

          $('.modal').modal('hide');
          $("#"+type).attr({"src":data,"data-link":data}).parents('.actual-image-frame').removeClass('minheight-0');
          $('#'+type).parent('a').attr({'href': 'javascript:void(0)', 'rel': rel}).addClass('lightboxed');
          $('#h-' + type).val(id + '-' + type);

          // check whether the same Others photo section already exists or not
          if ($('#h-Others-'+ (otherNumber + 1)).length <= 0 && type.match(/Others-/i)) {

            $('.Other-image-container:last').find('.remove-image').attr('id', insertedId);
            $('#h-' + type).attr('data-id', insertedId);

            // Add new Others photo section
            var html = '<div class="row $rowOffset Other-image-container"><div class="$colOffset sample-img-parent-container"></div><div class="$colOffset actual-img-parent-container"><input type="hidden"  id="h-Others-'+ (otherNumber + 1) +'" value="" data-id=""><div class="actual-image-container"><div class="actual-image-label text-success">Others-'+ (otherNumber + 1) +'</div><div class="actual-image-frame minheight-0"><a href="javascript:void(0);" class="MagicZoomPlus actual-img" rel="zoom-position:left; zoom-height:250px; zoom-width:300px; group: panzoom; pan-zoom: true; expand-size: width=600px; expand-position: center; opacity-reverse:true; background-opacity: 15" title="Others-'+ (otherNumber + 1) +'"><img src="$NoImageUrl" id="Others-'+ (otherNumber + 1) +'"></a>   </div></div><div class="text-center"><div class="btn btn-primary cm-Others-'+ (otherNumber + 1) +'" data-type="Others-'+ (otherNumber + 1) +'" style="width: 200px;"><i class="fa fa-camera"></i> Take Others-'+ (otherNumber + 1) +'</div> <a href="#" class="btn btn-danger remove-image" id=""><i class="fa fa-trash-alt"></i> Remove</a> </div><div class="clear" style="margin: 10px;"></div> </div></div><div class="border-bottom"></div>';
            $(html).insertAfter('.Other-image-container:last + .border-bottom');
          }

          $('.cm-' + type).addClass('hide');

          $(cameraUpload).text('Upload').removeAttr('disabled');
        },
        error: function() {
          $(cameraUpload).text('Upload').removeAttr('disabled');
        }
      });
    });
}

JS;
$this->registerJS($script);
?>


<?php
$script = <<< JS
$(document).on('click', '.sample-video-visibility-btn', function() {
        if ($(this).hasClass('btn-success')) {
            $('.sample-video-container').removeClass('hide');
            $(this).text('Hide Sample Images').removeClass('btn-success').addClass('btn-danger');
        }
        else {
            $('.sample-video-container').addClass('hide');
            $(this).text('Show Sample Images').removeClass('btn-danger').addClass('btn-success'); 
        }
    });
$(document).ready(function() {

  $(".box").hide();
  $("#axionpreinspectionvehicle-vtype").change(function() {

      $(this).find("option:selected").each(function() {
          if ($(this).attr("value") == "4-WHEELER") {
              $(".box").not(".ref_id4").hide();
              $(".ref_id4").show();

          }

          else if ($(this).attr("value") == "2-WHEELER") {
              $(".box").not(".ref_id2").hide();
              $(".ref_id2").show();

          }

          else if ($(this).attr("value") == 'COMMERCIAL')
          {
            $('.panel-heading.commercial').text('Commercial');
            $(".box").not(".ref_id1").hide();
            $(".ref_id1").show();
          }
          else if ($(this).attr("value") == 'CONSTRUCTION_EQUIPEMENT')
          {
            $(".box").not(".ref_id1").hide();
            $(".ref_id1").show();
            $('.panel-heading.commercial').text('Construction Equipement');
          }

          else if ($(this).attr("value") == 'FORM_EQUIPEMENT')
          {
            $(".box").not(".ref_id1").hide();
            $(".ref_id1").show();
            $('.panel-heading.commercial').text('Form Equipement');
          }
          else if ($(this).attr("value") == '3-WHEELER')
          {
            $(".box").not(".ref_id1").hide();
            $(".ref_id1").show();
            $('.panel-heading.commercial').text('3-Wheeler');
          }


          else {

            //  $(".box").hide();
          }
      });
  }).change();

  $('#axionpreinspection-conveyanceapproval').change(function() {

    if ($(this).val() == 'Yes')
      $('.ConveyanceApprovalImgContainer').removeClass('hide');
    else
      $('.ConveyanceApprovalImgContainer').addClass('hide');

  }).change();


  $(document).on('click', '.field-axionpreinspection-conveyanceapprovalimg .kv-file-upload', function() {
    $('#h-conveyanceApprovalImg').val('Uploaded');
  });

  $(document).on('click', '.field-axionpreinspection-conveyanceapprovalimg .kv-file-remove', function() {
    $('#h-conveyanceApprovalImg').val('');
  });

});

JS;
$this->registerJS($script);
?>


<?php

Modal::begin([
  'header' => '<main id="camer">',

  'id' => 'modal-camera',
  'size' => 'modal-md',

]);

echo   "<div>
            <img alt='' src='//:0' style='display:none;' id='cameraoutput'>
          </div>";

echo "<div class='modal-dialog'>
                <canvas id='camerasensor'></canvas>
                <video id='cameraview' autoplay playsinline></video></main>
              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

          </div>";

echo "<div class='modal-body'></div>";
echo "<div class='modal-footer'>
          <button id='cameratrigger'>Capture</button>
          <button id='cameraupload' style='display:none;'>Upload</button>
        </div>";

Modal::end();

?>


<?php

$url = YII::$app->request->baseUrl . '/axion-preinspection/video-upload';

$script = <<< JS

$(function() {
  $('.cm-vehicleVideo').on('click', function() {
    var clickedButton= $(this).data('type');
    $('#photoType').val(clickedButton);
    loadVideoPopup();
  });


  function loadVideoPopup(){
    $('#modal-video').modal('show');
    $("#modal-video").on('hidden.bs.modal', function(){
      $('#videoupload, #videoStopBtn, .videoTimerContainer').hide();
    });

    videoStart();
  }


  // Check whether the video playing in full screen or not
  $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', '.actual-image-frame video.lightboxed', function() {
    if (document.webkitFullscreenElement !== null) {
      $('.actual-image-frame video.lightboxed').css({'object-fit': 'contain', 'background-color': 'unset'});
    }
    else {
      $('.actual-image-frame video.lightboxed').css({'object-fit': 'cover', 'background-color': '#e5fd08'});
    }
  });


  var constraints = { video: { facingMode: "environment" }, audio: true };

  // Define constants
  const videoView = document.querySelector("#videoview"),
  videoOutput = document.querySelector("#videooutput"),
  videoSensor = document.querySelector("#videosensor"),
  startBtn = document.querySelector("#videoStartBtn"),
  stopBtn = document.querySelector("#videoStopBtn"),
  videoUpload = document.querySelector("#videoupload"),
  videoTimer = document.querySelector("#videoTimer"),
  videoTimerContainer = document.querySelector(".videoTimerContainer");
  var blob, videoTimerStart;

  function videoStart() {
      navigator.mediaDevices.getUserMedia(constraints)
      .then(function(stream) {
          let tracks = stream.getTracks();
          videoView.srcObject = stream;
          let mediaRecorder = new MediaRecorder(stream);
          let videoChunks = [];

          startBtn.onclick = function() {
            mediaRecorder.start();
            console.log(mediaRecorder.state);
            $(startBtn).hide('slow', function() {
              $(stopBtn).show();
            });

            // Start Timer function
            $(videoTimerContainer).show();

            let seconds = 60;
            videoTimerStart = setInterval(() => {
              if (seconds <= 0) {
                $(stopBtn).trigger('click');
              }
              $(videoTimer).text('00:00:'+ (seconds < 10 ? '0' : '') + seconds);
              seconds -= 1;
            }, 1000);
          };

          stopBtn.onclick = function() {
            mediaRecorder.stop();
            console.log(mediaRecorder.state);
            $(stopBtn).hide('slow', function() {
              $(startBtn).show();
              $(videoUpload).show();
            });

            // Stop Timer function
            clearInterval(videoTimerStart);
            $(videoTimerContainer).hide();
            $(videoTimer).text('00:00:60');
          };

          mediaRecorder.ondataavailable = function(ev) {
            videoChunks.push(ev.data);
          }

          mediaRecorder.onstop = function(ev) {
            blob = new Blob(videoChunks, {'type': 'video/mp4'});
            videoChunks = [];
            let videoURL = window.URL.createObjectURL(blob);
            videoOutput.src = videoURL;
            videoOutput.classList.add("videotaken");
            $(videoOutput).show();
          }

          // Close all video and audio tracks when modal close
          $("#modal-video").on('hidden.bs.modal', function(){
            tracks.forEach(function (track) {
              track.stop();
            });
          });


          $(videoUpload).click(function(e) {
            e.stopImmediatePropagation();
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            var type = $('#photoType').val();

            $(this).text('Uploading...').attr('disabled', 'disabled');
            $(startBtn).hide();
            var data = new FormData();
            data.append('video', blob);
            data.append('id', id);
            data.append('type', type);

            //alert(type);

            $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              url: '$url',
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              //timeout: 600000,
              success: function (response) {
                if (response != 'Failed') {
                  $('.modal').modal('hide');
                  $('.actual-video-container').find('.actual-image-frame').removeClass('minheight-0');
                  var videoElem = '<video src="'+ response +'" id="'+ type +'" class="actual-img lightboxed" controls></video>';
                  if ($('.actual-video-container').find('.actual-image-frame').find('video').length > 0) {
                    $('.actual-video-container').find('.actual-image-frame').find('video').attr('src', response);
                  }
                  else {
                    $('.actual-video-container').find('.actual-image-frame').append(videoElem);
                  }
                  $(videoUpload).text('Upload').removeAttr('disabled');
                  $(startBtn).show();

                  $('.cm-' + type).addClass('hide');
                }
              },
              error: function (e) {
                  console.log("ERROR : ", e);
                  $(videoUpload).text('Upload').removeAttr('disabled');
                  $(startBtn).show();
              }
            });

          });
      })
      .catch(function(error) {
          console.error("Oops. Something is broken.", error);
      });
  }


  $('#startBtn').click(function() {
    $('#videoupload').show();
  });

});

$('#savebtn').click(function(event) {
    // Get the file inputs
    var rcFront = $('#axioncliamsuerydocuploads-type-rc-front').get(0).files.length;
    var rcBack = $('#axioncliamsuerydocuploads-type-rc-back').get(0).files.length;

    // Check if both fields have files uploaded
    if (rcFront === 0 || rcBack === 0) {
        // Prevent the form submission and show an alert
        alert('Please upload both the RC FRONT and RC BACK files.');
        event.preventDefault(); // Prevents the default action (like form submission)
    }
});

$('#savebtnlist').click(function(event) {      
  //alert('1111');
  Rcuploaddocument();
  //return false;
});

//Rcuploaddocument
function Rcuploaddocument() {
  //alert('1222');  
  let id = $premodel->id; 
  let Page = 'completed';
  //alert(id);
  //alert(Page);
  return false;

  $.ajax({
        url: '$Rcupload',
        type: 'POST',
        data: {
          id:id,
          Page:Page
        },
        success: function(response) { 
            //alert(response);          
            alert('Image Upload Sucessfully !!');
            window.location.href = './pi-qc-screen?id=' + id + '&page=' + Page;
            //return false;
        },
        error: function(xhr, status, error) {           
            alert('An error occurred while saving vehicle details');
        }
       
  });
  return false;
    
}


// Other File Upload
function uploadfileFun(){
    $(".upload_file").on("change", function(e){
        var getpanelIndex = $(this).parent().parent().parent().attr('id');
        var ext = $(this).val().split('.').pop().toLowerCase();
        var uploadedFile = URL.createObjectURL(e.target.files[0]);

        if(ext == 'pdf'){
            if($("#"+getpanelIndex+' .preview-file').find('iframe').length > 0){
                $("#"+getpanelIndex+' .preview-file iframe').attr('src', uploadedFile).addClass("show");
            }else{
                $("#"+getpanelIndex+' .preview-file').append('<iframe src="'+uploadedFile+'"></iframe>').addClass("show");
            }
        }else if($.inArray(ext, ['gif','png','jpg','jpeg']) !== -1) {
            if($("#"+getpanelIndex+' .preview-file').find('img').length > 0){
                $("#"+getpanelIndex+' .preview-file img')
                    .attr('src', uploadedFile)
                    .addClass("show");
            } else {
                $("#"+getpanelIndex+' .preview-file')
                    .append('<img src="'+uploadedFile+'" />')
                    .addClass("show");
            }
        }else{
            alert('Only images and PDF are allowed');
            return false;
        }

        $("#"+getpanelIndex+' .btn.remove-file').removeClass('d-none');
        $("#"+getpanelIndex+' .btn.upload-file').addClass('d-none');
    });

    $(".btn.remove-file").on("click", function(e){
        var getpanelIndex = $(this).parent().parent().attr('id');
        var otherfileId = $(this).attr('data-id');
        var taskID = $(this).attr('data-taskid');
        var docType = $(this).attr('data-type');

        if(docType != '' && $('#'+docType+'-Extract').length > 0){
            $('#'+docType+'-Extract').remove();
        }

        $('input[name="AxionClaimsurvey[pending_for][]"]').each(function(){
            if(docType == $(this).val()){
                $(this).prop('checked', false);
            }
        });

        if(confirm("Are you sure you want to delete this?")){
            if($(this).parent().parent().hasClass('other_file_upload_sec')){
                $(this).parent().parent().remove();
                var rowcnt = 1;
                $('#upload-file-table-'+taskID+' tbody tr').each(function(){
                    if(!$(this).hasClass('table-heading')){
                        $(this).find('.indexno span').text(rowcnt);
                        rowcnt++;
                    }
                });
            }else if($(this).parent().hasClass('insured_payment_details_sec')){
                getpanelIndex = $(this).parent().attr('id');
                $("#"+getpanelIndex+' .preview-file').html('');
                $("#"+getpanelIndex+' .btn.remove-file').addClass('d-none');
                $("#"+getpanelIndex+' .btn.upload-file').removeClass('d-none');
            }else{
                $("#"+getpanelIndex+' .preview-file').html('');
                $("#"+getpanelIndex+' .btn.remove-file').addClass('d-none');
                $("#"+getpanelIndex+' .btn.upload-file').removeClass('d-none');
            }

            if(otherfileId > 0){
                $.ajax({
                    url: '$fileRemoveurl',
                    type: 'POST',
                    data: { id: otherfileId },
                    success: function (response){
                        // Handle response if needed
                    }
                });
            }

            if($("#"+getpanelIndex+' .activity-download-link').length > 0 || $("#"+getpanelIndex+' .activity-view-link').length > 0){
                $("#"+getpanelIndex+' .activity-download-link').remove();
                $("#"+getpanelIndex+' .activity-view-link').remove();
            }
        } else {
            return false;
        }
    });

    // Function to show 2 rows when button is clicked
    $(".your-button-selector").on("click", function(){
        var rows = $(".your-row-class");
        rows.slice(0, 2).show(); // Show the first two rows
    });
}

$(document).ready(function() {
    function loadFilesOnPageLoad(url) {
        $('.otherUploadFiles').each(function(){
            var taskId = $(this).attr('data-taskid');
            var cnt = $('#upload-file-table-'+taskId+' tr').length; // count existing rows
            var otherfiles = $('#upload-file-table-'+taskId+' tbody');

            // alert(taskId);
            // alert(cnt);
            // alert(otherfiles);
            
            console.log(cnt);
            // alert(taskId);
            // alert(otherfiles);
            // Function to append a row
            if(cnt < 3){           
             function appendRow(rowCount) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        taskid: taskId,
                        rowcnt: rowCount,
                    },
                    success: function(response) {
                        otherfiles.append(response);

                        uploadfileFun();
                        $('.upload-file').click(function(){
                            var fileInputId = $(this).parent().parent().attr('id');
                            $('#'+fileInputId+' .upload_file').trigger('click');
                        });
                        $('.inputcheck input').click(function(e){
                            let inputName = $(this).attr('name');
                            if ($(this).prop('checked')) {
                                $('input[name="'+inputName+'"]').val(1);
                            } else {
                                $('input[name="'+inputName+'"]').val(0);
                            }
                        });
                    }
                });
              }
            }
             
            // Append two rows
             //appendRow(1, 1);
             //appendRow(2, 1);
            
                        
            // appendRow(cnt + 1, "RC FRONT");     
            // appendRow(cnt + 1, "RC BACK");      
        });
       
          uploadfileFun();
        
    }

    // Call the function on page load with the appropriate URL
    var otherFileUrl = '$otherFileurl';
   
    loadFilesOnPageLoad(otherFileUrl);
  
    
});



$('.upload-file').click(function(){
  
    // alert('tedt');

    uploadfileFun();
    var fileInputId = $(this).parent().parent().attr('id');
    // alert(fileInputId);
    $('#'+fileInputId+' .upload_file').trigger('click');
});
//


// Image widget

$(document).ready(function() {
    // Wait for the widget's response
    $('.image-widget').on('fileuploaded', function(event, data, previewId, index) {
        // The widget's response is captured in the 'data' parameter
        // You can now call your desired function using 'data' or perform any other actions
        handleResponse(data);
    });

    // Define the function that will be called after getting the response
    function handleResponse(responseData) {
        // Your logic here...
        // You can access the response data and perform actions accordingly.
        // For example, you can use responseData.response to access the server response.
        // You can also call another function or update the UI based on the response.
        console.log(responseData.response);
        // Call your desired function here
        yourFunctionName();
    }

    // Your other functions...
    function yourFunctionName() {
        alert('test');
        // Your logic here for the function to be called after the response
    }
});

//
function previewFile(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = input.nextElementSibling;
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
            uploadfileFun();
        }
JS;
$this->registerJS($script);
?>


<?php

Modal::begin([
  'header' => '<main id="vide">',

  'id' => 'modal-video',
  'size' => 'modal-md',

]);

echo   "<div>
            <video id='videooutput' controls style='display:none'></video>
          </div>";

echo "<div class='modal-dialog'>
                <canvas id='videosensor'></canvas>
                <video id='videoview' autoplay playsinline></video></main>
                <div class='videoTimerContainer' style='display:none'>
                  <span class='black-circle'></span>
                  <span id='videoTimer'></span>
                </div>
              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

          </div>";

echo "<div class='modal-body'></div>";
echo "<div class='modal-footer'>
          <button id='videoStartBtn'>Start</button>
          <button id='videoStopBtn' style='display:none'>Stop</button>
          <button id='videoupload' style='display:none'>Upload</button>
        </div>";

Modal::end();

?>