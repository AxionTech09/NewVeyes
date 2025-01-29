<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionVehicle */
/* @var $form ActiveForm */


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
                <h6><?= $clientPhone ?></b></h6>
                <h6><?= $clientEmail ?></h6>
            </td></tr></table>   
</div>

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td>
   <td><h5 class="midtitle" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VEHICLE INSPECTION REPORT </h5></td>
</tr></table>
 
<div id="firstbox">
    <table class="tftable" >
    <tr >
        <td style="width:35%;" >REQUEST NUMBER: <?= $premodel->referenceNo; ?></td>
        <td>INSURANCE COMPANY/CLIENT: <?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?> </td>
    </tr>
    <tr>
        <td style="border-bottom: 0" >CUSTOMER NAME: <?= $premodel->insuredName; ?> </td>
        <td  style="border-bottom: 0">CUSTOMER CONTACT NUMBER: <?= $premodel->insuredMobile; ?> </td>
    </tr>
</table>
    <table class="tftable"  >
    <tr>
        <td style="width:35%;">REQUEST DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?> </td>
        <td style="width:37%;">INSPECTION DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
        <td>INSPECTION PLACE: <?= $premodel->surveyLocation; ?></td>
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
       
        <td style="<?php if($model->fuelTank != 'Safe') echo 'color:red'; ?>">FUEL TANK:<?= $model->fuelTank; ?></td>
 
        <td style="<?php if($model->frontBumper != 'Safe') echo 'color:red'; ?>">FRONT BUMPER: <?= $model->frontBumper; ?></td>
        <td style="<?php if($model->rearBumper != 'Safe') echo 'color:red'; ?>">REAR BUMPER: <?= $model->rearBumper; ?></td>
          </tr>
     <tr>
        <td style="<?php if($model->bonnet != 'Safe') echo 'color:red'; ?>">BONNET:<?= $model->bonnet; ?></td>
        <td style="<?php if($model->headLights != 'Safe') echo 'color:red'; ?>">HEAD LIGHT: <?= $model->headLights; ?></td>
   
        <td style="<?php if($model->grill != 'Safe') echo 'color:red'; ?>">GRILL: <?= $model->grill; ?></td>
         </tr>
    <tr>
        <td style="<?php if($model->indicatorLights != 'Safe') echo 'color:red'; ?>">INDICATOR LIGHT:<?= $model->indicatorLights; ?></td>

        <td style="<?php if($model->tailLamps != 'Safe') echo 'color:red'; ?>">TAIL LAMP: <?= $model->tailLamps; ?></td>
    
        <td style="<?php if($model->rearViewMirrors != 'Safe') echo 'color:red'; ?>">REAR VIEW MIRROR: <?= $model->rearViewMirrors; ?></td>
                </tr>

        <tr>
        <td style="<?php if($model->tyres != 'Safe') echo 'color:red'; ?>">TYRE:<?= $model->tyres; ?></td>

        <td style="<?php if($model->spareTyre != 'Safe') echo 'color:red'; ?>">SPARE TYRE: <?= $model->spareTyre; ?></td>

        <td style="<?php if($model->dashBoard != 'Safe') echo 'color:red'; ?>">DASH BOARD: <?= $model->dashBoard; ?></td>
                    </tr>

     <tr>
        <td style="<?php if($model->underCarriage != 'Safe') echo 'color:red'; ?>">UNDER CARRIAGE:<?= $model->underCarriage; ?></td>
  
        <td style="<?php if($model->seats != 'Safe') echo 'color:red'; ?>">SEAT: <?= $model->seats; ?></td>

        <td style="<?php if($model->leftWindowGlass != 'Intact') echo 'color:red'; ?>">LEFT WINDOW GLASS: <?= $model->leftWindowGlass; ?></td>
                  </tr>
    <tr>
        <td style="<?php if($model->frontwsGlassLaminated != 'Intact') echo 'color:red'; ?>">FRONT WS GLASS LAMINATED:<?= $model->frontwsGlassLaminated; ?></td>
 
        <td style="<?php if($model->rightWindowGlass != 'Intact') echo 'color:red'; ?>">RIGHT WINDOW GLASS: <?= $model->rightWindowGlass; ?></td>
     
        <td style="<?php if($model->backGlass != 'Intact') echo 'color:red'; ?>">BACK GLASS: <?= $model->backGlass; ?></td>

    </tr>

</table>
</div>

<h5 class="midtitle"> <?= $model->vType;?>&nbsp;INSPECTION DETAILS </h5>
<?php
   if($model->vType == '2-WHEELER')
   {
 ?>
<div id="inspectionbox">
<table class="tftable">
      <tr>
        <td style="width:35%;<?php if($twowheelermodel->frontMudgaurd != 'Safe') echo 'color:red'; ?>">FRONT MUDGAURD: <?= $twowheelermodel->frontMudgaurd; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->handleBar != 'Safe') echo 'color:red'; ?>">HANDLER BAR: <?= $twowheelermodel->handleBar; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->leverClutchHeadBreak != 'Safe') echo 'color:red'; ?>">LEVER CLUTCH HEAD BREAK: <?= $twowheelermodel->leverClutchHeadBreak; ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php if($twowheelermodel->forntHubDiselDrum != 'Safe') echo 'color:red'; ?>">FRONT HUB DISEL DRUM: <?= $twowheelermodel->forntHubDiselDrum; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->frontWheelRim != 'Safe') echo 'color:red'; ?>">FRONT WHEEL RIM: <?= $twowheelermodel->frontWheelRim; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->frontShockAbsorber != 'Safe') echo 'color:red'; ?>">FRONT SHOCK ABSORBER: <?= $twowheelermodel->frontShockAbsorber; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->legGaurd != 'Safe') echo 'color:red'; ?>">LEG GAURD: <?= $twowheelermodel->legGaurd; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->leftCoverShield != 'Safe') echo 'color:red'; ?>">LEFT COVER SHIELD: <?= $twowheelermodel->leftCoverShield; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rightCoverShield != 'Safe') echo 'color:red'; ?>">RIGHT COVER SHIELD: <?= $twowheelermodel->rightCoverShield; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->chassisFrame != 'Safe') echo 'color:red'; ?>">CHASSIS FRAME: <?= $twowheelermodel->chassisFrame; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->crankCaseCylinder != 'Safe') echo 'color:red'; ?>">CRANK CASE CYLINDER: <?= $twowheelermodel->crankCaseCylinder; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rearWheelRim != 'Safe') echo 'color:red'; ?>">REAL WHEEL RIM: <?= $twowheelermodel->rearWheelRim; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->rearShockAbsorber != 'Safe') echo 'color:red'; ?>">REAR SHOCK ABSORBER: <?= $twowheelermodel->rearShockAbsorber; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rearDrumDisc != 'Safe') echo 'color:red'; ?>">REAR DRUM DISC: <?= $twowheelermodel->rearDrumDisc; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->chainCover != 'Safe') echo 'color:red'; ?>">CHAIN COVER: <?= $twowheelermodel->chainCover; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->fork != 'Safe') echo 'color:red'; ?>">FORK: <?= $twowheelermodel->fork; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->kickPedal != 'Safe') echo 'color:red'; ?>">KICK PEDAL: <?= $twowheelermodel->kickPedal; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rearcowlLeftCenterRight != 'Safe') echo 'color:red'; ?>">REAR COW L/R/C: <?= $twowheelermodel->rearcowlLeftCenterRight; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->legshieldLeft != 'Safe') echo 'color:red'; ?>">LEG SHIELD LEFT: <?= $twowheelermodel->legshieldLeft; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->legshieldRight != 'Safe') echo 'color:red'; ?>">LEG SHIELD RIGHT: <?= $twowheelermodel->legshieldRight; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->fairing != 'Safe') echo 'color:red'; ?>">FAIRING: <?= $twowheelermodel->fairing; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($twowheelermodel->silencer != 'Safe') echo 'color:red'; ?>">SILENCER: <?= $twowheelermodel->silencer; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->rearMudguard != 'Safe') echo 'color:red'; ?>">REAR MUDGARD: <?= $twowheelermodel->rearMudguard; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->sareeGuard != 'Safe') echo 'color:red'; ?>">SAREE GUARD: <?= $twowheelermodel->sareeGuard; ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php if($twowheelermodel->wisor != 'Safe') echo 'color:red'; ?>">WISOR: <?= $twowheelermodel->wisor; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->helmetBox != 'Safe') echo 'color:red'; ?>">HELMET BOX: <?= $twowheelermodel->helmetBox; ?></td>
        <td style="width:35%;<?php if($twowheelermodel->luggageCarrier != 'Safe') echo 'color:red'; ?>">LUGGAGE CARRIER: <?= $twowheelermodel->luggageCarrier; ?></td>
               
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
        <td style="width:35%;<?php if($fwheelermodel->ltFrontFender != 'Safe') echo 'color:red'; ?>">LT FRONT FENDER: <?= $fwheelermodel->ltFrontFender; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltFrontDoor != 'Safe') echo 'color:red'; ?>">LT FRONT DOOR: <?= $fwheelermodel->ltFrontDoor; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltRearDoor != 'Safe') echo 'color:red'; ?>">LT REAR DOOR: <?= $fwheelermodel->ltRearDoor; ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php if($fwheelermodel->ltRunningBoard != 'Safe') echo 'color:red'; ?>">LT RUNNING BOARD: <?= $fwheelermodel->ltRunningBoard; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltPillarDoor != 'Safe') echo 'color:red'; ?>">LT PILLAR DOOR: <?= $fwheelermodel->ltPillarDoor; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltPillarCenter != 'Safe') echo 'color:red'; ?>">LT PILLAR CENTER: <?= $fwheelermodel->ltPillarCenter; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->ltPillarRear != 'Safe') echo 'color:red'; ?>">LT PILLAR REAR: <?= $fwheelermodel->ltPillarRear; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltQtrPanel != 'Safe') echo 'color:red'; ?>">LT QTR PANEL: <?= $fwheelermodel->ltQtrPanel; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtQtrPanel != 'Safe') echo 'color:red'; ?>">RT QTR PANEL: <?= $fwheelermodel->rtQtrPanel; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->rtRearDoor != 'Safe') echo 'color:red'; ?>">RT REAR DOOR: <?= $fwheelermodel->rtRearDoor; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontDoor != 'Safe') echo 'color:red'; ?>">RT FRONT DOOR: <?= $fwheelermodel->rtFrontDoor; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontPillar != 'Safe') echo 'color:red'; ?>">RT FRONT PILLAR: <?= $fwheelermodel->rtFrontPillar; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->rtCenterPillar != 'Safe') echo 'color:red'; ?>">RT CENTER PILLAR: <?= $fwheelermodel->rtCenterPillar; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtRearPillar != 'Safe') echo 'color:red'; ?>">RT REAR PILLAR: <?= $fwheelermodel->rtRearPillar; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtRunningBoard != 'Safe') echo 'color:red'; ?>">RT RUNNING BOARD: <?= $fwheelermodel->rtRunningBoard; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontFender != 'Safe') echo 'color:red'; ?>">RT FRONT FENDER: <?= $fwheelermodel->rtFrontFender; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltRearTyre) ?>">LT REAR TYRE: <?= $fwheelermodel->ltRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->ltFrontTyre)?>">LT FRONT TYRE: <?= $fwheelermodel->ltFrontTyre; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($fwheelermodel->rtRearTyre) ?>">RT REAR TYRE: <?= $fwheelermodel->rtRearTyre; ?></td>
        <td style="width:35%;<?php if($fwheelermodel->rtFrontTyre) ?>">RT FRONT TYRE: <?= $fwheelermodel->rtFrontTyre; ?></td>
        <td></td>
               
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
        <td style="width:35%;<?php if($commercialwheelermodel->typeOfBody != 'Safe') echo 'color:red'; ?>">BODY TYPE: <?= $commercialwheelermodel->typeOfBody; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->frontSideBody != 'Safe') echo 'color:red'; ?>">FRONT SIDE BODY: <?= $commercialwheelermodel->frontSideBody; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->rightSideBody != 'Safe') echo 'color:red'; ?>">RIGHT SIDE BODY: <?= $commercialwheelermodel->rightSideBody; ?></td>
               
      </tr>
      <tr>
        <td style="width:35%;<?php if($commercialwheelermodel->leftSideBody != 'Safe') echo 'color:red'; ?>">LEFT SIDE BODY: <?= $commercialwheelermodel->leftSideBody; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->frontExcavator != 'Safe') echo 'color:red'; ?>">FRONT EXCAVATOR: <?= $commercialwheelermodel->frontExcavator; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->craneBucket != 'Safe') echo 'color:red'; ?>">CRANE BUCKET: <?= $commercialwheelermodel->craneBucket; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($commercialwheelermodel->craneHook != 'Safe') echo 'color:red'; ?>">CRANE HOOK: <?= $commercialwheelermodel->craneHook; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->ac != 'Safe') echo 'color:red'; ?>">A/C: <?= $commercialwheelermodel->ac; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->boom != 'Safe') echo 'color:red'; ?>">BOOM: <?= $commercialwheelermodel->boom; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($commercialwheelermodel->fans != 'Safe') echo 'color:red'; ?>">FANS: <?= $commercialwheelermodel->fans; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->hydrualicSystem != 'Safe') echo 'color:red'; ?>">HYDRUALIC SYSTEM: <?= $commercialwheelermodel->hydrualicSystem; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->chassisFrame != 'Safe') echo 'color:red'; ?>">CHASSIS FRAME: <?= $commercialwheelermodel->chassisFrame; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($commercialwheelermodel->doors != 'Safe') echo 'color:red'; ?>">DOORS: <?= $commercialwheelermodel->doors; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->excavatorCabinGlass != 'Safe') echo 'color:red'; ?>">EXCAVATOR CABIN GLASS: <?= $commercialwheelermodel->excavatorCabinGlass; ?></td>
        <td style="width:35%;<?php if($commercialwheelermodel->craneCabinGlass != 'Safe') echo 'color:red'; ?>">CRANE CABIN GLASS: <?= $commercialwheelermodel->craneCabinGlass; ?></td>
               
      </tr>

      <tr>
        <td style="width:35%;<?php if($commercialwheelermodel->extraFittings != 'Safe') echo 'color:red'; ?>">EXTRA FITTINGS: <?= $commercialwheelermodel->extraFittings; ?></td>
        <td></td>
        <td></td>       
      </tr>

</table>
</div>
<?php } ?>
<div class="spacebox"></div>
<div class="remarksbox">
<table class="tftable">
    <tr>
        <td style="width:30%;">REMARKS: <?= $premodel->remarks; ?></td>
        <td style="width:35%; text-align: center; height: 160px;">
         <?php
         foreach($phmodel as $obj)
         {
            if($obj->image != '' && $obj->type == 'chassisThumb')
            {
             ?>
         <div>
             <h5 style="text-align: center">Chassis Photo</h5>
         <?= Html::img(Yii::$app->basePath.'/'.$qcLoc.$obj->image,["width"=>"180px","height"=>"135px"]) ?>
         </div>
         
         <?php
         break;
            }
         }
         ?>  
        </td>
        <td>INSPECTION STATUS: <?php if($premodel->status != '') echo $model->qcStatusvalue[$premodel->status];  ?></td>
    </tr>
</table>
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

<div id="imgbox">
    
    <?php
        foreach($phmodel as $obj)
        {
            if($obj->image != '' && $obj->type != 'chassisThumb')
            {
                ?>
                   <div class="imgdiv">
                       <div class="img"><?= Html::img(Yii::$app->basePath.'/'.$qcLoc.$obj->image,["width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>
</div>