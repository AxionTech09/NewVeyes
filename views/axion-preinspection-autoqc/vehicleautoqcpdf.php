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
        <td style="border-bottom: 0" >Vehicle No: <?= $premodel->registrationNo; ?> </td>
    </tr>
    <tr>
        <!-- <td style="border-bottom: 0" >ULN NUMBER: <?= $premodel->contactPersonMobileNo; ?> </td> -->
        <!-- <td  style="border-bottom: 0">CUSTOMER CONTACT NUMBER: <?= $premodel->insuredMobile; ?> </td> -->
        <td style="width:35%;">REQUEST DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?> </td>
        <td style="width:37%;">INSPECTION DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
        <td>INSPECTION PLACE: <?= $premodel->surveyLocation2; ?></td>
    </tr>
</table>
    <table class="tftable"  >
    <tr>
        <td>INITIATOR NAME: <?php echo 'Customer'; ?></td>
        <td>INITIATOR CONTACT NUMBER: <?php echo $premodel->insuredMobile; ?></td>
        <td>INITIATOR EMAIL ID: <?php echo $premodel->insuredAddress; ?></td>
    </tr>
    <!-- <tr>
    </tr> -->
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
    <td colspan=2>VIDEO LINK: <a href="<?=$videoLink?>" target="_blank"><?=$videoLink?></a></td>
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
        <td style="width:35%;<?php echo ($fwheelermodel->bonnet == 2 || $fwheelermodel->bonnet === null ? '' : 'color:red'); ?>">
            BONNET: <?= isset($fwheelermodel->bonnet) ? strtoupper($premodel->getDamageName($fwheelermodel->bonnet)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->dashboard == 2 || $fwheelermodel->dashboard === null ? '' : 'color:red'); ?>">
            DASHBOARD: <?= isset($fwheelermodel->dashboard) ? strtoupper($premodel->getDamageName($fwheelermodel->dashboard)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->dicky_boot == 2 || $fwheelermodel->dicky_boot === null ? '' : 'color:red'); ?>">
            DICKY BOOT: <?= isset($fwheelermodel->dicky_boot) ? strtoupper($premodel->getDamageName($fwheelermodel->dicky_boot)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_bumper == 2 || $fwheelermodel->front_bumper === null ? '' : 'color:red'); ?>">
            FRONT BUMPER: <?= isset($fwheelermodel->front_bumper) ? strtoupper($premodel->getDamageName($fwheelermodel->front_bumper)) : 'SAFE'; ?>
        </td>        
        <td style="width:35%;<?php echo ($fwheelermodel->rear_bumper == 2 || $fwheelermodel->rear_bumper === null ? '' : 'color:red'); ?>">
            REAR BUMPER: <?= isset($fwheelermodel->rear_bumper) ? strtoupper($premodel->getDamageName($fwheelermodel->rear_bumper)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_grill == 2 || $fwheelermodel->front_grill === null ? '' : 'color:red'); ?>">
            FRONT GRILL: <?= isset($fwheelermodel->front_grill) ? strtoupper($premodel->getDamageName($fwheelermodel->front_grill)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_windshield == 2 || $fwheelermodel->front_windshield === null ? '' : 'color:red'); ?>">
            FRONT WINDSHEILD: <?= isset($fwheelermodel->front_windshield) ? strtoupper($premodel->getDamageName($fwheelermodel->front_windshield)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_windshield == 2 || $fwheelermodel->rear_windshield === null ? '' : 'color:red'); ?>">
            REAR WINDSHEILD: <?= isset($fwheelermodel->rear_windshield) ? strtoupper($premodel->getDamageName($fwheelermodel->rear_windshield)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->head_light == 2 || $fwheelermodel->head_light === null ? '' : 'color:red'); ?>">
            HEAD LIGHT: <?= isset($fwheelermodel->head_light) ? strtoupper($premodel->getDamageName($fwheelermodel->head_light)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->tail_lamp == 2 || $fwheelermodel->tail_lamp === null ? '' : 'color:red'); ?>">
            TAIL LAMP: <?= isset($fwheelermodel->tail_lamp) ? strtoupper($premodel->getDamageName($fwheelermodel->tail_lamp)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->chassis_engraved == 2 || $fwheelermodel->chassis_engraved === null ? '' : 'color:red'); ?>">
            CHASSIS ENGRAVED: <?= isset($fwheelermodel->chassis_engraved) ? strtoupper($premodel->getDamageName($fwheelermodel->chassis_engraved)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->chassis_plate == 2 || $fwheelermodel->chassis_plate === null ? '' : 'color:red'); ?>">
            CHASSIS PLATE: <?= isset($fwheelermodel->chassis_plate) ? strtoupper($premodel->getDamageName($fwheelermodel->chassis_plate)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->driver_door == 2 || $fwheelermodel->driver_door === null ? '' : 'color:red'); ?>">
            DRIVER DOOR: <?= isset($fwheelermodel->driver_door) ? strtoupper($premodel->getDamageName($fwheelermodel->driver_door)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_fender == 2 || $fwheelermodel->front_fender === null ? '' : 'color:red'); ?>">
            FRONT FENDER: <?= isset($fwheelermodel->front_fender) ? strtoupper($premodel->getDamageName($fwheelermodel->front_fender)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->front_number_plate == 2 || $fwheelermodel->front_number_plate === null ? '' : 'color:red'); ?>">
            FRONT NUMBER PLATE: <?= isset($fwheelermodel->front_number_plate) ? strtoupper($premodel->getDamageName($fwheelermodel->front_number_plate)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->front_door == 2 || $fwheelermodel->front_door === null ? '' : 'color:red'); ?>">
            FRONT DOOR: <?= isset($fwheelermodel->front_door) ? strtoupper($premodel->getDamageName($fwheelermodel->front_door)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->quarter_panel == 2 || $fwheelermodel->quarter_panel === null ? '' : 'color:red'); ?>">
            QUARTER PANEL: <?= isset($fwheelermodel->quarter_panel) ? strtoupper($premodel->getDamageName($fwheelermodel->quarter_panel)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_number_plate == 2 || $fwheelermodel->rear_number_plate === null ? '' : 'color:red'); ?>">
            REAR NUMBER PLATE: <?= isset($fwheelermodel->rear_number_plate) ? strtoupper($premodel->getDamageName($fwheelermodel->rear_number_plate)) : 'SAFE'; ?>
        </td>
    </tr>

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_door == 2 || $fwheelermodel->rear_door === null ? '' : 'color:red'); ?>">
            REAR DOOR: <?= isset($fwheelermodel->rear_door) ? strtoupper($premodel->getDamageName($fwheelermodel->rear_door)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->rear_view_mirror == 2 || $fwheelermodel->rear_view_mirror === null ? '' : 'color:red'); ?>">
            REAR VIEW MIRROR: <?= isset($fwheelermodel->rear_view_mirror) ? strtoupper($premodel->getDamageName($fwheelermodel->rear_view_mirror)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->running_board == 2 || $fwheelermodel->running_board === null ? '' : 'color:red'); ?>">
            RUNNING BOARD: <?= isset($fwheelermodel->running_board) ? strtoupper($premodel->getDamageName($fwheelermodel->running_board)) : 'SAFE'; ?>
        </td>
    </tr>      

    <tr>
        <td style="width:35%;<?php echo ($fwheelermodel->tyre == 2 || $fwheelermodel->tyre === null ? '' : 'color:red'); ?>">
            TYRE: <?= isset($fwheelermodel->tyre) ? strtoupper($premodel->getDamageName($fwheelermodel->tyre)) : 'SAFE'; ?>
        </td>
        <td style="width:35%;<?php echo ($fwheelermodel->passenger_front_fender == 2 || $fwheelermodel->passenger_front_fender === null ? '' : 'color:red'); ?>">
            PASSENGER FRONT FENDER: <?= isset($fwheelermodel->passenger_front_fender) ? strtoupper($premodel->getDamageName($fwheelermodel->passenger_front_fender)) : 'SAFE'; ?>
        </td>
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
        $amountInPaisa = $payModel->amount; 
        $amountInRupees = $amountInPaisa / 100;
        
        echo number_format($amountInRupees, 2);
      ?> </td>
      <td>Payment Order ID : <?= $premodel->oreder_id; ?> </td>
      <td>Payment Date : <?= $payModel->created_on; ?> </td>
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
        <span style="text-decoration: underline; font-weight: bolder; font-size:10px; ">Declaration of Owners:</span> I hereby confirm and declare that above-mentioned identification details of My Vehicle NO.       as well as that of damage to the vehicle as noted by the inspecting official are correct. Nothing has been Hidden/ undisclosed. I further confirm & declare that the Motor Vehicle proposed for insurance after a break in coverage has not met with an accident giving rise to any claims that Third Party for injury or death causes to any person or damage to any property/Insured vehicle during the period following the expiry of an Insurance, till the moment it isproposed for insurance. I also agree that the damages mentioned in this report & as per photographs are excluded from the scope of this policy and shall be excluded/adjusted in the event of any claim being lodged
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