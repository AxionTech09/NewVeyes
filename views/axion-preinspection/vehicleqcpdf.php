<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\helpers\S3Helper;

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
$clientLogoUrl = \Yii::$app->params['clientLogoUrl'];
$clientAddress1 = \Yii::$app->params['clientAddress1'];
$clientAddress2 = \Yii::$app->params['clientAddress2'];
$clientPhone = \Yii::$app->params['clientPhone'];
$clientEmail = \Yii::$app->params['clientEmail'];

$s3BaseUrl = 'https://'.\Yii::$app->params['s3Bucket'].'.s3.'.\Yii::$app->params['s3Region'].'.amazonaws.com/';
?>

    
    
<div class="box1">
<div class="topbox" >
    <table>
        <tr>
            <td width ="30%"><?= Html::img(Yii::$app->basePath.'/'.$clientLogoUrl,["width"=>"100px","height"=>"85px"]) ?></td>
            <td width="20%"></td>
            <td>
                <h3><?= $clientName ?></h3>
                <h6><?= $clientAddress1 ?></h6>
                <?php if($clientAddress2 != '') { echo '<h6>'.$clientAddress2.'</h6>'; }?> 
                <h6><?= ($RoUser->mobile)? 'Phone : '.$RoUser->mobile : $clientPhone ?></b></h6>
                <h6><?= ($RoUser->email)? 'Email : '.$RoUser->email : $clientEmail ?></h6>
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
        <td style="border-bottom: 0" >CUSTOMER NAME: <?= $premodel->insuredName; ?> </td>
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
      <td style="width:35%;">VEHICLE NO: <?= $premodel->registrationNo; ?> </td>
      <td>CHASSIS NO: <?= $premodel->chassisNo; ?></td>
      <td>ENGINE NO: <?= $premodel->engineNo; ?></td>
  </tr>
  <tr>
      <td>MAKE: <?= $premodel->manufacturer; ?></td>
      <td>MODEL: <?= $premodel->model; ?></td>  
      <td>YEAR: <?= $premodel->manufacturingYear; ?></td>
      </tr>
  <tr>
      <td>COLOUR: <?= $model->colour; ?></td>
      <td>ODOMETER READING: <?= $model->odometerReading; ?></td>
  
      <td style="<?php if($model->rcVerified == 'No') echo 'color:red'; ?>">RC VERIFIED: <?= $model->rcVerified; ?></td>
      </tr>
  <tr>
      <td>FUEL TYPE: <?= $model->fuelType; ?></td>
      <td>STEREO MAKE: <?= $model->stereoMake; ?></td>
  
      <td>OTHER ELECTRICAL: <?= $model->otherElectrical; ?></td>
      </tr>
  <tr>
      
      <td style="<?php echo ($model->fuelTank == 'Safe'?'':'color:red'); ?>">FUEL TANK:<?= strtoupper($model->fuelTank); ?></td>

      <td style="<?php echo ($model->frontBumper == 'Safe'?'':'color:red'); ?>">FRONT BUMPER: <?= strtoupper($model->frontBumper); ?></td>
      <td style="<?php echo ($model->rearBumper == 'Safe'?'':'color:red'); ?>">REAR BUMPER: <?=strtoupper($model->rearBumper) ; ?></td>
        </tr>
    <tr>
      <td>BONNET:<span style="<?php echo ($model->bonnet == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->bonnet); ?></span></td>
      <td>HEAD LIGHT: <span style="<?php echo ($model->headLights == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->headLights); ?></span></td>
  
      <td>GRILL: <span style="<?php echo ($model->grill == 'Safe'?'':'color:red'); ?>"><?=strtoupper($model->grill); ?></span></td>
        </tr>
  <tr>
      <td>INDICATOR LIGHT:<span  style="<?php echo ($model->indicatorLights == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->indicatorLights); ?></span></td>

      <td>TAIL LAMP: <span style="<?php echo ($model->tailLamps == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->tailLamps); ?></span></td>
  
      <td>REAR VIEW MIRROR: <span style="<?php echo ($model->rearViewMirrors == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->rearViewMirrors); ?></span></td>
  </tr>

      <tr>
      <td>TYRE:<span style="<?php echo ($model->tyres == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->tyres); ?></span></td>

      <td>SPARE TYRE: <span style="<?php echo ($model->spareTyre == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->spareTyre); ?></span></td>

      <td>DASH BOARD: <span style="<?php echo ($model->dashBoard == 'Safe'?'':'color:red'); ?>"><?= strtoupper($model->dashBoard); ?></span></td>
                  </tr>

    <tr>
      <td>UNDER CARRIAGE:<span style="<?=(($model->underCarriage == 'Intact' || $model->underCarriage == 'Safe') ? "":'color:red')?>"><?= ($model->underCarriage=='Intact'?'SAFE':strtoupper($model->underCarriage))?></span></td>

      <td>SEAT: <span  style="<?php echo ($model->seats == 'Safe' ? "":'color:red'); ?>"><?= strtoupper($model->seats); ?></span></td>

      <td>LEFT WINDOW GLASS: <span  style="<?=($model->leftWindowGlass == 'Intact' ? "":'color:red')?>"><?= ($model->leftWindowGlass == 'Intact' ?'SAFE':strtoupper($model->leftWindowGlass))?></span></td>
                </tr>
  <tr>
      <td>FRONT WS GLASS LAMINATED:<span style="<?=($model->frontwsGlassLaminated == 'Intact' ? "":'color:red')?>"><?= strtoupper($model->frontwsGlassLaminated); ?></span></td>

      <td>RIGHT WINDOW GLASS: <?= strtoupper($model->rightWindowGlass); ?></td>
    
      <td >BACK GLASS: <span style="<?=($model->backGlass == 'Intact' ? "":'color:red')?>"><?= ($model->backGlass == 'Intact' ?'SAFE':strtoupper($model->leftWindowGlass))?></span></td>

  </tr>
  <tr>
    <td>ENGINE CONDITION:
      <?php 
        if($model->engineStatus=='1')
        {
          echo strtoupper($engine_status[$model->engineStatus]);
        }
        else
        {
          echo "<span style='color:red;'>".strtoupper($engine_status[$model->engineStatus])."</span>";
        }
        ?>
      </td>
    <td  style="width:30%;">REMARKS: <?= $premodel->remarks; ?></td>
    <td>INSPECTION STATUS: <?php if($premodel->status != '' && $premodel->status=='102') 
    {
      echo "<span style='color:red;'>".strtoupper($model->qcStatusvalue[$premodel->status])."<span>";
    }
    else
    {
      echo strtoupper($model->qcStatusvalue[$premodel->status]);
    }?></td>
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
    <?php if ($videoLink != '') { ?>
      <td colspan="3">VIDEO LINK: <a href="<?=$videoLink?>" target="_blank"><?=$videoLink?></a></td>
    <?php } ?>
  </tr>
  <tr>
    <?php if ($premodel->insurerName == 10) {
        $vehicleType = '';
        if ($model->vType == '4-WHEELER')
          $vehicleType = 'Private Car';
        else if ($model->vType == '2-WHEELER')
          $vehicleType = 'Two-wheeler';
        else if ($model->vType == 'COMMERCIAL' && $model->vCategory == 'Passenger Carrying Vehicle') 
          $vehicleType = 'Passenger Carrying Vehicle';
        else if ($model->vType == 'COMMERCIAL' && $model->vCategory == 'Goods Carrying Vehicle') 
          $vehicleType = 'Goods Carrying Vehicle';
        else if ($model->vType == 'COMMERCIAL' && $model->vCategory == 'Miscellaneous Vehicle') 
          $vehicleType = 'Miscellaneous Vehicle';
      ?>
      <td>VEHICLE TYPE: <?= strtoupper(str_replace('_', ' ', $vehicleType)); ?></td>
    <?php } else { ?>
      <td>VEHICLE TYPE: <?= str_replace('_', ' ', $model->vType); ?></td>
      <!-- <td>VEHICLE CATEGORY: <?= strtoupper($model->vCategory); ?></td> -->
    <?php } ?>

  </tr>

</table>
</div>

<?php if ($model->vType != '') { ?>
  <h5 class="midtitle"> <?= $model->vType;?>&nbsp;INSPECTION DETAILS </h5>
<?php } ?>
<?php
   if($model->vType == '2-WHEELER')
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
   if($model->vType == '4-WHEELER')
   {
 ?>

<div id="inspectionbox">
<table class="tftable">
      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltFrontFender == 'Safe' ? '':'color:red'); ?>">LT FRONT FENDER: <?= strtoupper($fwheelermodel->ltFrontFender); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltFrontDoor == 'Safe'?'':'color:red'); ?>">LT FRONT DOOR: <?= strtoupper($fwheelermodel->ltFrontDoor); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltRearDoor == 'Safe'?'':'color:red'); ?>">LT REAR DOOR: <?= strtoupper($fwheelermodel->ltRearDoor); ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltRunningBoard == 'Safe'?'':'color:red'); ?>">LT RUNNING BOARD: <?= strtoupper($fwheelermodel->ltRunningBoard); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarDoor == 'Safe'?'':'color:red'); ?>">LT PILLAR DOOR: <?= strtoupper($fwheelermodel->ltPillarDoor); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarCenter == 'Safe'?'':'color:red'); ?>">LT PILLAR CENTER: <?= strtoupper($fwheelermodel->ltPillarCenter); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->ltPillarRear == 'Safe'?'':'color:red'); ?>">LT PILLAR REAR: <?= strtoupper($fwheelermodel->ltPillarRear); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->ltQtrPanel == 'Safe'?'':'color:red'); ?>">LT QTR PANEL: <?= strtoupper($fwheelermodel->ltQtrPanel); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtQtrPanel == 'Safe'?'':'color:red'); ?>">RT QTR PANEL: <?= strtoupper($fwheelermodel->rtQtrPanel); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRearDoor == 'Safe'?'':'color:red'); ?>">RT REAR DOOR: <?= strtoupper($fwheelermodel->rtRearDoor); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontDoor == 'Safe'?'':'color:red'); ?>">RT FRONT DOOR: <?= strtoupper($fwheelermodel->rtFrontDoor); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontPillar == 'Safe'?'':'color:red'); ?>">RT FRONT PILLAR: <?= strtoupper($fwheelermodel->rtFrontPillar); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtCenterPillar == 'Safe' ?'':'color:red'); ?>">RT CENTER PILLAR: <?= strtoupper($fwheelermodel->rtCenterPillar); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRearPillar == 'Safe' ?'':'color:red') ; ?>">RT REAR PILLAR: <?= strtoupper($fwheelermodel->rtRearPillar); ?></td>
        <td style="width:35%;<?php echo ($fwheelermodel->rtRunningBoard == 'Safe' ?'':'color:red') ; ?>">RT RUNNING BOARD: <?= strtoupper($fwheelermodel->rtRunningBoard); ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rtFrontFender == 'Safe' ?'':'color:red') ; ?>">RT FRONT FENDER: <?= strtoupper($fwheelermodel->rtFrontFender); ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltRearTyre) ?>">LT REAR TYRE: <?= $fwheelermodel->ltRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltFrontTyre)?>">LT FRONT TYRE: <?= $fwheelermodel->ltFrontTyre; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->rtRearTyre) ?>">RT REAR TYRE: <?= $fwheelermodel->rtRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontTyre) ?>">RT FRONT TYRE: <?= $fwheelermodel->rtFrontTyre; ?></td>
        <td style="width:35%;<?php echo($fwheelermodel->dicky == 'Safe' ?'':'color:red') ?>">DICKY: <?= $fwheelermodel->dicky; ?></td>
               
      </tr>
      

</table>
</div>
<?php } ?>
<?php
   if($model->vType == 'COMMERCIAL')
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
              $s3FileExists =  S3Helper::fileExists($imgUrl);

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
        <span style="text-decoration: underline; font-weight: bolder; font-size:10px; ">Declaration of Owners:</span>  I/We hereby confirm that the vehicle has been inspected in my presence or my representative's presence. I/We
hereby confirm that the identification details and damages of vehicle as noted / photographs taken by the inspecting person are correct.
Nothing has been hidden/undisclosed. I/We agreed that Repair/Replacement of dented/crack parts & Repair Painting of dented/scratched
panels as per this inspection photographs shall be excluded in event of any claim lodged during the policy period. I hereby certify that I have
shown the same vehicle which I have to get insured and if later at the time of claim if it is found that vehicle shown and accidental are different
then no claim is payable to me. I hereby certify that I will not claim for damages existing in my vehicle whether same are mentioned in report or
not if same are seen in photograph taken by the inspector.
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
        $s3FileExists =  S3Helper::fileExists($conveyanceImgUrl);

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
    
    <?php
        foreach($phmodel as $obj)
        {
            if($obj->image != '' && $obj->type != 'chassisThumb' && $obj->type != 'vehicleVideo')
            {
              $imgUrl = $s3BaseUrl . $qcLoc . $obj->image;
              $s3FileExists =  S3Helper::fileExists($imgUrl);

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
</div>