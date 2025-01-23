<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// use app\helpers\S3Helper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionVehicle */
/* @var $form ActiveForm */


// echo "<pre>";
// print_r(Yii::$app->user->identity);
// exit;
if(isset($valuator))
{
    $valuatorData=ArrayHelper::map($valuator,'id','firstName');
}
else {
    $valuatorData= [''=>'Select'];
}

$statusArray = $model->qcStatusvalue;
$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$fuelTypeArray = $model->fuelTypevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
$enginecondition=[
        
        ['id'=>'1','name'=>'Engine Working/Started'],
        ['id'=>'2','name'=>'Engine Not Working/Started'],
        ['id'=>'3','name'=>'Battery Not Working']];

$engine_status=ArrayHelper::map($enginecondition, 'id', 'name');


$centreLockList= [
  ['id' => '', 'name' => '-Select-'],
  ['id' => 'YES', 'name' => 'YES'],
  ['id' => 'NO', 'name' => 'NO'],
];
$centreLockArray = ArrayHelper::map($centreLockList, 'id', 'name');

$clientName = \Yii::$app->params['clientName'];
$clientLogoUrl = \Yii::$app->params['clientNewLogoUrl'];
$clientAddress1 = \Yii::$app->params['clientNewAddress'];
$clientAddress2 = \Yii::$app->params['clientAddress2'];
$clientPhone = \Yii::$app->params['clientPhone'];
$clientEmail = \Yii::$app->params['clientEmail'];

$s3BaseUrl = 'https://'.\Yii::$app->params['s3Bucket'].'.s3.'.\Yii::$app->params['s3Region'].'.amazonaws.com/';
?>

    
    
<div class="box1">
<div class="topbox" >
    <table>
        <tr>
            <td width ="30%"><?= Html::img($clientLogoUrl,["width"=>"85px","height"=>"85px"]) ?></td>
            <td width="20%"></td>
            <td>
                <h3><?= $clientName ?></h3>
                <h6><?= $clientAddress1 ?></h6>
                <!-- <?php if($clientAddress2 != '') { echo '<h6>'.$clientAddress2.'</h6>'; }?> 
                <h6><?= ($RoUser->mobile)? 'Phone : '.$RoUser->mobile : $clientPhone ?></b></h6>
                <h6><?= ($RoUser->email)? 'Email : '.$RoUser->email : $clientEmail ?></h6> -->
            </td></tr></table>   
</div>

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig-wb') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td>
   <td><h5 class="midtitle" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VEHICLE INSPECTION REPORT </h5></td>
</tr></table>
 
<div id="firstbox">
    <table class="tftable" >
    <tr >
        <td style="width:35%;" >REQUEST NUMBER: <?= $premodel->referenceNo; ?></td>
        <td>INSURANCE COMPANY/CLIENT: <?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?> </td>
    </tr>
    <tr>
        <td style="border-bottom: 0" >ULN NUMBER: <?= $premodel->contactPersonMobileNo; ?> </td>
        <td style="border-bottom: 0" >Vehicle No: <?= $premodel->registrationNo; ?> </td>
        <!-- <td  style="border-bottom: 0">CUSTOMER CONTACT NUMBER: <?= $premodel->insuredMobile; ?> </td> -->
    </tr>
</table>
    <table class="tftable"  >
    <tr>
        <td style="width:35%;">REQUEST DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?> </td>
        <td style="width:37%;">INSPECTION DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
        <td>INSPECTION PLACE: <?= $premodel->surveyLocation2; ?></td>
    </tr>
    <tr>
        <td>INITIATOR NAME: <?php echo ($premodel->callerFirstName)?$premodel->callerFirstName->firstName:''; ?></td>
        <td>INITIATOR CONTACT NUMBER: <?php echo $premodel->callerMobileNo; ?></td>
        <td>INITIATOR EMAIL ID: <?php echo $premodel->callerDetails; ?></td>
    </tr>
</table>
</div>

<h5 class="midtitle"> VEHICLE DETAILS </h5>

<div id="vehiclebox">
<table class="tftable">
  <tr>
        
    <td width="50%">RC FRONT: <?= $text_extractfR; ?></td>

    <td>RC BACK: <?= $text_extractbk; ?></td>
  </tr>
  <tr>
    <td>
      INSPECTION STATUS: <?php if($premodel->status != '' && $premodel->status=='102') 
      {
        echo "<span style='color:red;'>".strtoupper($model->qcStatusvalue[$premodel->status])."<span>";
      }
      else
      {
        echo strtoupper($model->qcStatusvalue[$premodel->status]);
      }?>
    </td>
    <td>VEHICLE TYPE: <?= str_replace('_', ' ', $premodel->vType); ?></td>
  </tr>
  <tr>
    <?php foreach($phmodel as $obj) {
            if($obj->type == 'vehicleVideo') {
              if ($obj->image != '')
                // $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
                // $s3FileExists =  S3Helper::fileExists($imgUrl);
                // if ($s3FileExists['status'])
                // {
                //   $videoLink = $s3FileExists['data']['url'];
                // }
                // else
                // {
                  $videoLink = \Yii::$app->request->hostInfo.'/'.$qcLoc.$obj->image;
                // }
            }
          }
    ?>
    <td colsapn=2>VIDEO LINK: <a href="<?=$videoLink?>" target="_blank"><?=$videoLink?></a></td>
  </tr>
</table>
</div>

<?php if ($premodel->vType != '') { ?>
  <h5 class="midtitle"> <?= $premodel->vType;?>&nbsp;INSPECTION DETAILS </h5>
<?php } ?>
<?php
   if($premodel->vType == '2-WHEELER')
   {
 ?>
<div id="inspectionbox">
<table class="tftable">
      <tr>
        <td style="width:35%;<?php if($twowheelermodel->frontMudgaurd =='Safe'?'':'color:red'); ?>">FRONT MUDGAURD: <?= $twowheelermodel->frontMudgaurd; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->handleBar =='Safe'?'':'color:red'); ?>">HANDLER BAR: <?= $twowheelermodel->handleBar; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->leverClutchHeadBreak =='Safe'?'':'color:red'); ?>">LEVER CLUTCH HEAD BREAK: <?= $twowheelermodel->leverClutchHeadBreak; ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php if($twowheelermodel->forntHubDiselDrum =='Safe'?'':'color:red'); ?>">FRONT HUB DISEL DRUM: <?= $twowheelermodel->forntHubDiselDrum; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->frontWheelRim =='Safe'?'':'color:red'); ?>">FRONT WHEEL RIM: <?= $twowheelermodel->frontWheelRim; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->frontShockAbsorber =='Safe'?'':'color:red'); ?>">FRONT SHOCK ABSORBER: <?= $twowheelermodel->frontShockAbsorber; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->legGaurd =='Safe'?'':'color:red'); ?>">LEG GAURD: <?= $twowheelermodel->legGaurd; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->leftCoverShield =='Safe'?'':'color:red'); ?>">LEFT COVER SHIELD: <?= $twowheelermodel->leftCoverShield; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rightCoverShield =='Safe'?'':'color:red'); ?>">RIGHT COVER SHIELD: <?= $twowheelermodel->rightCoverShield; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->chassisFrame =='Safe'?'':'color:red'); ?>">CHASSIS FRAME: <?= $twowheelermodel->chassisFrame; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->crankCaseCylinder =='Safe'?'':'color:red'); ?>">CRANK CASE CYLINDER: <?= $twowheelermodel->crankCaseCylinder; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rearWheelRim =='Safe'?'':'color:red'); ?>">REAL WHEEL RIM: <?= $twowheelermodel->rearWheelRim; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($twowheelermodel->rearShockAbsorber == 'Safe'?'':'color:red'); ?>">REAR SHOCK ABSORBER: <?= strtoupper($twowheelermodel->rearShockAbsorber); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->rearDrumDisc == 'Safe'?'':'color:red'); ?>">REAR DRUM DISC: <?= strtoupper($twowheelermodel->rearDrumDisc); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->chainCover == 'Safe'?'':'color:red'); ?>">CHAIN COVER: <?= strtoupper($twowheelermodel->chainCover); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($twowheelermodel->fork == 'Safe'?'':'color:red'); ?>">FORK: <?= strtoupper($twowheelermodel->fork); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->kickPedal== 'Safe'?'':'color:red'); ?>">KICK PEDAL: <?= strtoupper($twowheelermodel->kickPedal); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->rearcowlLeftCenterRight== 'Safe'?'':'color:red'); ?>">REAR COW L/R/C: <?= strtoupper($twowheelermodel->rearcowlLeftCenterRight); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($twowheelermodel->legshieldLeft == 'Safe'?'':'color:red'); ?>">LEG SHIELD LEFT: <?= strtoupper($twowheelermodel->legshieldLeft); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->legshieldRight != 'Safe'?'':'color:red'); ?>">LEG SHIELD RIGHT: <?= strtoupper($twowheelermodel->legshieldRight); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->fairing == 'Safe' ? '':'color:red'); ?>">FAIRING: <?= strtoupper($twowheelermodel->fairing); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($twowheelermodel->silencer == 'Safe'?'':'color:red'); ?>">SILENCER: <?= strtoupper($twowheelermodel->silencer); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->rearMudguard == 'Safe'?'':'color:red'); ?>">REAR MUDGARD: <?= strtoupper($twowheelermodel->rearMudguard); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->sareeGuard == 'Safe'?'':'color:red'); ?>">SAREE GUARD: <?= strtoupper($twowheelermodel->sareeGuard); ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php echo ($twowheelermodel->wisor == 'Safe' ?'':'color:red'); ?>">WISOR: <?= strtoupper($twowheelermodel->wisor); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->helmetBox == 'Safe'?'':'color:red'); ?>">HELMET BOX: <?= strtoupper($twowheelermodel->helmetBox); ?></td>
        <td style="width:35%;<?php echo ($twowheelermodel->luggageCarrier == 'Safe'?'':'color:red'); ?>">LUGGAGE CARRIER: <?= strtoupper($twowheelermodel->luggageCarrier); ?></td>
               
      </tr>
</table>
</div>
<?php } ?>

<?php
   if($premodel->vType == '4-WHEELER')
   {
 ?>

<div id="inspectionbox">
<table class="tftable">
      <?php /* <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltFrontFender == 2 ? '':'color:red'); ?>">LT FRONT FENDER: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltFrontFender)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltFrontDoor == 2?'':'color:red'); ?>">LT FRONT DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltFrontDoor)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltRearDoor == 2?'':'color:red'); ?>">LT REAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltRearDoor)); ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltRunningBoard == 2?'':'color:red'); ?>">LT RUNNING BOARD: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltRunningBoard)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarDoor == 2?'':'color:red'); ?>">LT PILLAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltPillarDoor)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarCenter == 2?'':'color:red'); ?>">LT PILLAR CENTER: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltPillarCenter)); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarRear == 2?'':'color:red'); ?>">LT PILLAR REAR: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltPillarRear)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltQtrPanel == 2?'':'color:red'); ?>">LT QTR PANEL: <?= strtoupper($premodel->getDamageName($fwheelermodel->ltQtrPanel)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtQtrPanel == 2?'':'color:red'); ?>">RT QTR PANEL: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtQtrPanel)); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRearDoor == 2?'':'color:red'); ?>">RT REAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtRearDoor)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontDoor == 2?'':'color:red'); ?>">RT FRONT DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtFrontDoor)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontPillar == 2 ?'':'color:red'); ?>">RT FRONT PILLAR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtFrontPillar)); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtCenterPillar == 2 ?'':'color:red'); ?>">RT CENTER PILLAR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtCenterPillar)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRearPillar == 2 ?'':'color:red') ; ?>">RT REAR PILLAR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtRearPillar)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRunningBoard == 2 ?'':'color:red') ; ?>">RT RUNNING BOARD: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtRunningBoard)); ?></td>
               
      </tr>

      <?php /* <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontFender == 2 ?'':'color:red') ; ?>">RT FRONT FENDER: <?= strtoupper($premodel->getDamageName($fwheelermodel->rtFrontFender)); ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltRearTyre) ?>">LT REAR TYRE: <?= $fwheelermodel->ltRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltFrontTyre)?>">LT FRONT TYRE: <?= $fwheelermodel->ltFrontTyre; ?></td>
               
      </tr> */?>

      <?php /* <tr>
        <!-- <td style="width:35%;<?php if($fwheelermodel->rtRearTyre) ?>">RT REAR TYRE: <?= $fwheelermodel->rtRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontTyre) ?>">RT FRONT TYRE: <?= $fwheelermodel->rtFrontTyre; ?></td> -->
        <td style="width:35%;<?php echo($fwheelermodel->dicky == 2 ?'':'color:red') ?>">DICKY: <?= strtoupper($premodel->getDamageName($fwheelermodel->dicky)); ?></td>
               
      </tr> */ ?>
      
      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->bonnet == 2 ? '':'color:red'); ?>">BONNET: <?= strtoupper($premodel->getDamageName($fwheelermodel->bonnet)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->dashboard == 2?'':'color:red'); ?>">DASHBOARD: <?= strtoupper($premodel->getDamageName($fwheelermodel->dashboard)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->dicky_boot == 2?'':'color:red'); ?>">DICKY BOOT: <?= strtoupper($premodel->getDamageName($fwheelermodel->dicky_boot)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_bumper == 2 ? '':'color:red'); ?>">FRONT BUMPER: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_bumper)); ?></td>        
        <td style="width:35%;<?php echo ($fwheelermodel->rear_bumper == 2?'':'color:red'); ?>">REAR BUMPER: <?= strtoupper($premodel->getDamageName($fwheelermodel->rear_bumper)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_grill == 2?'':'color:red'); ?>">FRONT GRILL: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_grill)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_windshield == 2?'':'color:red'); ?>">FRONT WINDSHEILD: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_windshield)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_windshield == 2?'':'color:red'); ?>">REAR WINDSHEILD: <?= strtoupper($premodel->getDamageName($fwheelermodel->rear_windshield)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->head_light == 2 ? '':'color:red'); ?>">HEAD LIGHT: <?= strtoupper($premodel->getDamageName($fwheelermodel->head_light)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->tail_lamp == 2 ? '':'color:red'); ?>">TAIL LAMP: <?= strtoupper($premodel->getDamageName($fwheelermodel->tail_lamp)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->chassis_engraved == 2?'':'color:red'); ?>">CHASSIS ENGRAVED: <?= strtoupper($premodel->getDamageName($fwheelermodel->chassis_engraved)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->chassis_plate == 2?'':'color:red'); ?>">CHASSIS PLATE: <?= strtoupper($premodel->getDamageName($fwheelermodel->chassis_plate)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->driver_door == 2 ? '':'color:red'); ?>">DRIVER DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->driver_door)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_fender == 2?'':'color:red'); ?>">FRONT FENDER: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_fender)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_number_plate == 2?'':'color:red'); ?>">FRONT NUMBER PLATE: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_number_plate)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_door == 2 ? '':'color:red'); ?>">FRONT DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->front_door)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->quarter_panel == 2?'':'color:red'); ?>">QUARTER PANEL: <?= strtoupper($premodel->getDamageName($fwheelermodel->quarter_panel)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_number_plate == 2?'':'color:red'); ?>">REAR NUMBER PLATE: <?= strtoupper($premodel->getDamageName($fwheelermodel->rear_number_plate)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_door == 2 ? '':'color:red'); ?>">REAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rear_door)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_view_mirror == 2?'':'color:red'); ?>">REAR VIEW MIRROR: <?= strtoupper($premodel->getDamageName($fwheelermodel->rear_view_mirror)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->running_board == 2?'':'color:red'); ?>">RUNNING BOARD: <?= strtoupper($premodel->getDamageName($fwheelermodel->running_board)); ?></td>
      </tr>      

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->tyre == 2 ? '':'color:red'); ?>">TYRE: <?= strtoupper($premodel->getDamageName($fwheelermodel->tyre)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->under_chassis == 2?'':'color:red'); ?>">UNDER CHASSIS: <?= strtoupper($premodel->getDamageName($fwheelermodel->under_chassis)); ?></td>        
        <td style="width:35%;<?php echo ($fwheelermodel->odometter == 2?'':'color:red'); ?>">ODOMETTER: <?= strtoupper($premodel->getDamageName($fwheelermodel->odometter)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->driver_quarter_panel == 2 ? '':'color:red'); ?>">DRIVER QUARTER PANEL: <?= strtoupper($premodel->getDamageName($fwheelermodel->driver_quarter_panel)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->driver_front_fender == 2?'':'color:red'); ?>">DRIVER FRONT FENDER: <?= strtoupper($premodel->getDamageName($fwheelermodel->driver_front_fender)); ?></td>        
        <td style="width:35%;<?php echo ($fwheelermodel->driver_rear_door == 2?'':'color:red'); ?>">DRIVER REAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->driver_rear_door)); ?></td>
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->passenger_front_door == 2 ? '':'color:red'); ?>">PASSENGER FRONT DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->passenger_front_door)); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->passenger_rear_door == 2 ? '':'color:red'); ?>">PASSENGER REAR DOOR: <?= strtoupper($premodel->getDamageName($fwheelermodel->passenger_rear_door)); ?></td>
        
      </tr>
      
</table>
</div>
<?php } ?>
<?php
   if($premodel->vType == 'COMMERCIAL')
   {
 ?>

<div id="inspectionbox">
<table class="tftable">
      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->typeOfBody =='Safe'?'':'color:red'); ?>">BODY TYPE: <?= strtoupper($commercialwheelermodel->typeOfBody); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->frontSideBody =='Safe'?'':'color:red'); ?>">FRONT SIDE BODY: <?= strtoupper($commercialwheelermodel->frontSideBody); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->rearSideBody =='Safe'?'':'color:red'); ?>">REAR SIDE BODY: <?= strtoupper($commercialwheelermodel->rearSideBody); ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->rightSideBody =='Safe'?'':'color:red'); ?>">RIGHT SIDE BODY: <?= strtoupper($commercialwheelermodel->rightSideBody); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->leftSideBody =='Safe'?'':'color:red'); ?>">LEFT SIDE BODY: <?= strtoupper($commercialwheelermodel->leftSideBody); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->frontExcavator =='Safe'?'':'color:red'); ?>">FRONT EXCAVATOR: <?= strtoupper($commercialwheelermodel->frontExcavator); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->craneBucket =='Safe'?'':'color:red'); ?>">CRANE BUCKET: <?= strtoupper($commercialwheelermodel->craneBucket); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->craneHook =='Safe'?'':'color:red'); ?>">CRANE HOOK: <?= strtoupper($commercialwheelermodel->craneHook); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->ac =='Safe'?'':'color:red'); ?>">A/C: <?= strtoupper($commercialwheelermodel->ac); ?></td>
              
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->boom =='Safe'?'':'color:red'); ?>">BOOM: <?= strtoupper($commercialwheelermodel->boom); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->fans =='Safe'?'':'color:red'); ?>">FANS: <?= $commercialwheelermodel->fans; ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->hydrualicSystem =='Safe'?'':'color:red'); ?>">HYDRUALIC SYSTEM: <?= strtoupper($commercialwheelermodel->hydrualicSystem); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->chassisFrame =='Safe'?'':'color:red'); ?>">CHASSIS FRAME: <?= strtoupper($commercialwheelermodel->chassisFrame); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->doors =='Safe'?'':'color:red'); ?>">DOORS: <?= strtoupper($commercialwheelermodel->doors); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->excavatorCabinGlass =='Safe'?'':'color:red'); ?>">EXCAVATOR CABIN GLASS: <?= strtoupper($commercialwheelermodel->excavatorCabinGlass); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($commercialwheelermodel->craneCabinGlass =='Safe'?'':'color:red'); ?>">CRANE CABIN GLASS: <?= strtoupper($commercialwheelermodel->craneCabinGlass); ?></td>
        <td style="width:35%;<?php echo ($commercialwheelermodel->extraFittings =='Safe'?'':'color:red'); ?>">EXTRA FITTINGS: <?= strtoupper($commercialwheelermodel->extraFittings); ?></td>
        <td></td>      
      </tr>

</table>
</div>
<?php } ?>
<div class="spacebox"></div>
<div id="vehiclebox">
  <p style="text-align: center;"><b>Payment Details</b></p>
  <table class="tftable">
    <tr>
      <td>Amount Paid : <?php 
        $amountInPaisa = $paymodel->amount; 
        $amountInRupees = $amountInPaisa / 100;
        
        echo number_format($amountInRupees, 2);
      ?> </td>
      <td>Payment Order ID : <?= $premodel->oreder_id; ?> </td>
      <td>Payment Date : <?= $paymodel->created_on; ?> </td>
    </tr>
  </table>
</div>
<div class="spacebox"></div>
<div class="remarksbox" style="height:120px;width: 100%;display:block;overflow:hidden;">
  <p style="text-align: center;">Chassis Photo</p>



<?php
         foreach($phmodel as $obj)
         {
            if($obj->image != '' && $obj->type == 'chassisThumb')
            {
              //$img_height = ($model->vType != '')? '200px': '250px';
              $img_height = '150px';
              
              $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
              $s3FileExists =  "";//S3Helper::fileExists($imgUrl);

              if ($s3FileExists['status'])
              {
                $imgUrl = $s3FileExists['data']['url'];
              }
              else
              {
                $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc . $obj->image);
              }
              
              
             ?>
                <div class="col-xs-offset-2"> <!-- col-xs-offset-2 -->
                  <?= Html::img($imgUrl, ['style'=>['width' => '70%', 'height'=>$img_height]]) ?>
                </div>
              
         
         <?php
         break;
            }
         }
         ?>

<!-- <table class="tftable">
    <tr>
        
        <td  style="width:100%; text-align:center;height: 100%;">
           
        </td>
        
    </tr>
</table> -->
</div>

<div class="spacebox"></div>
<div class="declarationbox">
    <strong>    
        <span style="text-decoration: underline; font-weight: bolder; font-size:10px; ">Declaration of Owners:</span>   I hereby confirm and declare that above-mentioned identification details of My Vehicle NO.       as well as that of damage to the vehicle as noted by the inspecting official are correct. Nothing has been Hidden/ undisclosed. I further confirm & declare that the Motor Vehicle proposed for insurance after a break in coverage has not met with an accident giving rise to any claims that Third Party for injury or death causes to any person or damage to any property/Insured vehicle during the period following the expiry of an Insurance, till the moment it isproposed for insurance. I also agree that the damages mentioned in this report & as per photographs are excluded from the scope of this policy and shall be excluded/adjusted in the event of any claim being lodged
<div style="margin-top:10px;font-weight: bold; font-size:9px;">Declaration:- This is computer generated report and need not required any signature. </strong></div>    
</div>

<div class="spacebox"></div>

<div class="surveyorbox">
  <table class="tftable">
      <tr>
          <td style="width:50%;">SURVEYOR NAME: <?= $surveyor_name; ?></td>
          <td>REPORT DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
      </tr>
  </table>
</div>

<?php if ($premodel->conveyanceApprovalImg != '') { ?>
  <div class="spacebox"></div>

  <div class="imgdiv" style="width: 50%;">
      <h5 style="text-align: left; text-decoration: underline;">Conveyance approval Image</h5>
      <?php
        $conveyanceImgUrl = $s3BaseUrl . '/conveyance_images/'.$premodel->conveyanceApprovalImg;
        $s3FileExists =  "";//S3Helper::fileExists($conveyanceImgUrl);

        if ($s3FileExists['status'])
        {
          $conveyanceImgUrl = $s3FileExists['data']['url'];
        }
        else
        {
          $conveyanceImgUrl = Yii::$app->urlManager->createAbsoluteUrl('/conveyance_images/'.$premodel->conveyanceApprovalImg);
        }
      ?>
      <div class="img"><?= Html::img($conveyanceImgUrl,["width"=>"100%","height"=>"280px"]) ?> </div>
  </div>
  <div style="clear: both"></div> 
<?php } ?>

<div class="spacebox"></div>

<div id="imgbox">
    <h5 class="midtitle">QC Photos</h5>
    <?php
        foreach($phmodel as $obj)
        {
            if($obj->image != '' && $obj->type != 'chassisThumb' && $obj->type != 'vehicleVideo')
            {
              $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
              $s3FileExists =  "";//S3Helper::fileExists($imgUrl);

              if ($s3FileExists['status'])
              {
                $imgUrl = $s3FileExists['data']['url'];
              }
              else
              {
                $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc . $obj->image);
              }
                ?>
                   <div class="imgdiv">
                       <div class="img"><?= Html::img($imgUrl, ["width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>
<div class="spacebox"></div>
<div id="imgbox">
    <h5 class="midtitle">AI Processed Photos</h5>
    <?php
        foreach($aiphotomodel as $aiobj)
        {
            if($aiobj->image != '' && $aiobj->type != 'chassisThumb' && $aiobj->type != 'vehicleVideo')
            {
              $imgUrl = $s3BaseUrl . $qcLoc . $aiobj->image;
              $s3FileExists =  "";//S3Helper::fileExists($imgUrl);

              if ($s3FileExists['status'])
              {
                $imgUrl = $s3FileExists['data']['url'];
              }
              else
              {
                $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($aiobj->image);
              }
                ?>
                   <div class="imgdiv">
                       <div class="img"><?= Html::img($imgUrl, ["width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>
</div>