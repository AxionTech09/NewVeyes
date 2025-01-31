<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionFourwheeler */
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

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td><td><h5 class="midtitle"> FOUR WHEELER INSPECTION REPORT </h5></td></tr></table>

<div id="firstbox">
    <table class="tftable"  >
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
        <td>VARIANT: </td>
    </tr>
    <tr>
        <td>YEAR: <?= $premodel->manufacturingYear; ?></td>
        <td>COLOUR: <?= $model->colour; ?></td>
        <td>ODOMETER READING: <?= $model->odometerReading; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rcVerified == 'No') echo 'color:red'; ?>">RC VERIFIED: <?= $model->rcVerified; ?></td>
        <td>FUEL TYPE: <?= $model->fuelType; ?></td>
        <td>STEREO MAKE: <?= $model->stereoMake; ?></td>
    </tr>
    <tr>
        <td>OTHER ELECTRICAL: <?= $model->otherElectrical; ?></td>
        <td></td>
        <td></td>
    </tr>
</table>
</div>

<h5 class="midtitle"> INSPECTION DETAILS </h5>

<div id="inspectionbox">
<table class="tftable">
    <tr>
        <td style="width:35%;<?php if($model->frontBumper != 'Safe') echo 'color:red'; ?>">FRONT BUMPER: <?= $model->frontBumper; ?></td>
        <td style="<?php if($model->grill != 'Safe') echo 'color:red'; ?>">GRILL: <?= $model->grill; ?></td>
        <td style="<?php if($model->headLamp != 'Safe') echo 'color:red'; ?>">HEAD LAMP: <?= $model->headLamp; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->indicatorLight != 'Safe') echo 'color:red'; ?>">INDICATOR LIGHT: <?= $model->indicatorLight; ?></td>
        <td style="<?php if($model->frontPanel != 'Safe') echo 'color:red'; ?>">FRONT PANEL: <?= $model->frontPanel; ?></td>
        <td style="<?php if($model->bonnet != 'Safe') echo 'color:red'; ?>">BONNET: <?= $model->bonnet; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->leftApron != 'Safe') echo 'color:red'; ?>">LEFT APRON: <?= $model->leftApron; ?></td>
        <td style="<?php if($model->rightApron != 'Safe') echo 'color:red'; ?>">RIGHT APRON: <?= $model->rightApron; ?></td>
        <td style="<?php if($model->dicky != 'Safe') echo 'color:red'; ?>">DICKY: <?= $model->dicky; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rearBumper != 'Safe') echo 'color:red'; ?>">REAR BUMPER: <?= $model->rearBumper; ?></td>
        <td style="<?php if($model->tallLamp != 'Safe') echo 'color:red'; ?>">TAIL LAMP: <?= $model->tallLamp; ?></td>
        <td style="<?php if($model->ltFrontFender != 'Safe') echo 'color:red'; ?>">LT FRONT FENDER: <?= $model->ltFrontFender; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->ltFrontDoor != 'Safe') echo 'color:red'; ?>">LT FRONT DOOR: <?= $model->ltFrontDoor; ?></td>
        <td style="<?php if($model->ltRearDoor != 'Safe') echo 'color:red'; ?>">LT REAR DOOR: <?= $model->ltRearDoor; ?></td>
        <td style="<?php if($model->ltRunningBoard != 'Safe') echo 'color:red'; ?>">LT RUNNING BOARD: <?= $model->ltRunningBoard; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->ltPillarDoor != 'Safe') echo 'color:red'; ?>">LT PILLAR DOOR (A): <?= $model->ltPillarDoor; ?></td>
        <td style="<?php if($model->ltPillarCentre != 'Safe') echo 'color:red'; ?>">LT PILLAR CENTRE (B): <?= $model->ltPillarCentre; ?></td>
        <td style="<?php if($model->ltPillarRear != 'Safe') echo 'color:red'; ?>">LT PILLAR REAR (C): <?= $model->ltPillarRear; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->ltQtrPanel != 'Safe') echo 'color:red'; ?>">LT QTR PANEL: <?= $model->ltQtrPanel; ?></td>
        <td style="<?php if($model->rtQtrPanel != 'Safe') echo 'color:red'; ?>">RT QTR PANEL: <?= $model->rtQtrPanel; ?></td>
        <td style="<?php if($model->rtRearDoor != 'Safe') echo 'color:red'; ?>">RT REAR DOOR: <?= $model->rtRearDoor; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rtFrontDoor != 'Safe') echo 'color:red'; ?>">RT FRONT DOOR: <?= $model->rtFrontDoor; ?></td>
        <td style="<?php if($model->rtFrontPillar != 'Safe') echo 'color:red'; ?>">RT FRONT PILLAR (A): <?= $model->rtFrontPillar; ?></td>
        <td style="<?php if($model->rtCenterPillar != 'Safe') echo 'color:red'; ?>">RT CENTER PILLAR (B): <?= $model->rtCenterPillar; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rtRearPillar != 'Safe') echo 'color:red'; ?>">RT REAR PILLAR (C): <?= $model->rtRearPillar; ?></td>
        <td style="<?php if($model->rtRunningBoard != 'Safe') echo 'color:red'; ?>">RT RUNNING BOARD: <?= $model->rtRunningBoard; ?></td>
        <td style="<?php if($model->rtFrontFender != 'Safe') echo 'color:red'; ?>">RT FRONT FENDER: <?= $model->rtFrontFender; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rearViewMirror != 'Safe') echo 'color:red'; ?>">REAR VIEW MIRROR: <?= $model->rearViewMirror; ?></td>
        <td style="<?php if($model->tyres != 'Safe') echo 'color:red'; ?>">TYRES: <?= $model->tyres; ?></td>
        <td style="<?php if($model->backGlass != 'Intact') echo 'color:red'; ?>">BACK GLASSES: <?= $model->backGlass; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->frontwsGlassLaminated != 'Intact') echo 'color:red'; ?>">FRONT WS GLASS LAMINATED: <?= $model->frontwsGlassLaminated; ?></td>
        <td>LT REAR TYRE: <?= $model->ltRearTyre; ?></td>
        <td>LT FRONT TYRE: <?= $model->ltFrontTyre; ?></td>
    </tr>
    <tr>
        <td>RT REAR TYRE: <?= $model->rtRearTyre; ?></td>
        <td>RT FRONT TYRE: <?= $model->rtFrontTyre; ?></td>
        <td style="<?php if($model->underCarriage != 'Safe') echo 'color:red'; ?>">UNDER CARRIAGE: <?= $model->underCarriage; ?></td>
    </tr>
</table>
</div>

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