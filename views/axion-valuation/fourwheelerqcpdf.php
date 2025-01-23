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

$PricingArray = $model->qcStatusvalue;
$inspectionTypeArray = $premodel->inspectionTypevalue;
$rcArray = $model->rcValue;
$paintArray = $model->paintValue;
$transmissionArray = $model->transmissionValue;
$tyreconditionArray = $model->tyreconditionValue;
$noOftyreArray = $model->noOftyreValue;
$windshieldArray = $model->WindshieldValue;
$bagsArray = $model->bagsValue;
$seatsArray = $model->seatsValue;
$insuranceArray = $model->insuranceValue;
$VTypeArray = $model->VTypeValue;
$vehicleParkingLocationArray = $model->vehicleParkingLocationValue;
$rcstatusArray = $model->rcstatusValue;
$fuelTypeArray = $model->fuelTypevalue;
$damageType1Array = $model->damageType1value;
$damageType2Array = $model->damageType2value;
$damageType3Array = $model->damageType3value;
$damageType4Array = $model->damageType4value;
// $makeList =ArrayHelper::map($make_name,'id','make_name');
// $premodel->make = $makeList;

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

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td><td><h5 class="midtitle"> FOUR WHEELER VALUATION REPORT </h5></td></tr></table>

<div id="firstbox">
    <table class="tftable"  >
    <tr>
    
        <td style="width:35%;" >CLIENT NAME:<?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?></td>
        <td>REFERENCE NO: <?= $premodel->referenceNo; ?> </td>
    </tr>
    <tr>
        <td style="border-bottom: 0" >CUSTOMER NAME: <?= $premodel->customerName; ?> </td>
        <td  style="border-bottom: 0">CUSTOMER CONTACT NUMBER: <?= $premodel->customerMobile; ?> </td>
    </tr>
</table>
    <table class="tftable"  >
    <tr>
        <td style="width:35%;">REQUEST DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?> </td>
        <td style="width:37%;">VALUATION DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
        <td>VEHICLE LOCATION: <?= $premodel->vehicleLocation; ?></td>
    </tr>
    <tr>
        <td>EXECUTIVE NAME: <?php $premodel->callerName; ?></td>
        <td>EXECUTIVE NUMBER: <?php echo $premodel->callerMobileNo; ?></td>
        <td>EXECUTIVE EMAIL ID: <?php echo $premodel->callerDetails; ?></td>
    </tr>
</table>
</div>

<h5 class="midtitle"> VEHICLE DETAILS </h5>

<div id="vehiclebox">
<table class="tftable">
    <tr>
        <td>REGISTRATION NO: <?= $premodel->registrationNo; ?> </td>
        <td>VEHICLE TYPE: <?= $premodel->vehicleType; ?></td>
        <td>MANUFACTURING YEAR: <?= $premodel->manufacturingYear; ?></td>
        <td>REGISTRATION YEAR: <?= $premodel->registrationYear; ?> </td>
        
    </tr>
    <tr>
        
        <td>MAKE: <?= ($premodel->pricemake)?$premodel->pricemake->make:'';?></td>
        <td>MODEL: <?= ($premodel->pricemodel)?$premodel->pricemodel->model:'';?></td>
        <td>VARIANT: <?= ($premodel->pricevariant)?$premodel->pricevariant->variant:'';?> </td>
    
        <td>CUBIC CAPACITY: <?= $model->cubicCapacity; ?></td>
        
    </tr>
    <tr>
      <td>CHASSIS NO: <?= $premodel->chassisNo; ?></td>
        <td>ENGINE NO: <?= $premodel->engineNo; ?></td>
       
        <td>ODOMETER READING: <?= $model->odometerReading; ?></td>
        <td>FUEL TYPE: <?= $model->fuelType; ?></td>
    </tr>
    <tr>
        <!-- <td style="<?php if($model->rcVerified == 'No') echo 'color:red'; ?>">RC VERIFIED: <?= $model->rcVerified; ?></td> -->
        
        <!-- <td>STEREO MAKE: <?= $model->transmissionCondition; ?></td> -->
    </tr>
    
</table>
</div>

<h5 class="midtitle"> VALUATION DETAILS </h5>

<div id="inspectionbox">
<table class="tftable">
    <tr>
        <td>FRONT BUMPER BONNET: <?php if($model->frontBumperBonnet != '') echo $model->ltrearValue[$model->frontBumperBonnet]; ?></td>
        <td>REAR BUMPER BONNET: <?php if($model->rearBumperBonnet != '') echo $model->ltrearValue[$model->rearBumperBonnet]; ?></td>
        
        <td>RH-FENDER DOORS: <?php if($model->rhFenderDoors != '') echo $model->ltrearValue[$model->rhFenderDoors]; ?></td>
        <td>LH-FENDER DOORS: <?php if($model->lhFenderDoors != '') echo $model->ltrearValue[$model->lhFenderDoors]; ?></td>
    </tr>
    <tr>
        <td>ENGINE CONDITION: <?php if($model->engineCondition != '') echo $model->ltrearValue[$model->engineCondition]; ?></td>
        <td>CHASSIS CONDITION: <?php if($model->chassisCondition != '') echo $model->ltrearValue[$model->chassisCondition]; ?></td>
        <td>BRAKES SYSTEMS: <?php if($model->brakes != '') echo $model->ltrearValue[$model->brakes]; ?></td>
        <td>SUSPENSION: <?php if($model->suspension != '') echo $model->ltrearValue[$model->suspension]; ?></td>
    </tr>
    <tr>
        <td>ABS: <?php if($model->absDrop != 'Safe') echo$model->absDrop; ?></td>
        <td>TRANSMISSION CONDITION: <?php if($model->transmissionCondition != '') echo $model->ltrearValue[$model->transmissionCondition]; ?></td>
        <td>AIR BAG: <?php if($model->airBags != 'Safe') echo $model->airBags; ?></td>
       <td> <?php if($model->seats != 'Safe'); ?>NO OF SEATS: <?= $model->seats; ?></td>
         
    </tr>
    <tr>
        <td>WINDSHIELD: <?php if($model->windShield != 'Safe') echo $model->windShield; ?></td>
        <td>INTERIER ACCESSORIES: <?php if($model->interierAccessories != '') echo $model->ltrearValue[$model->interierAccessories]; ?></td>
        
        <td>SEATS CONDITION: <?php if($model->seatsCondition != '') echo $model->ltrearValue[$model->seatsCondition]; ?></td>
        <td>VEHICLE CONDITION: <?php if($model->vehicleCondition != '') echo $model->ltrearValue[$model->vehicleCondition]; ?></td>

    </tr>
    <tr>
        <td>PAINT CONDITION: <?php if($model->paintCondition != '')echo $model->ltrearValue[$model->paintCondition]; ?></td>
        <td>COLOUR: <?php if($model->colour != 'Safe') echo $model->colour; ?></td>
        <td>BATTERY CONDITION: <?php if($model->batteryCondition != '') echo $model->ltrearValue[$model->batteryCondition]; ?></td>
        <td>PAINT: <?php if($model->paint != 'Safe') echo $model->paint; ?></td>
    </tr>
    <tr>
        <td>POWER WINDOWS: <?php if($model->powerWindows != 'Safe') echo $model->powerWindows; ?></td>
        <td>NO OF TYRE: <?php if($model->noOfTyre != 'Safe') 
        echo $model->noOfTyre; ?></td>
        
        <td>HPA STATUS: <?php if($model->hpaStatus != 'Safe') echo $model->hpaStatus; ?></td>
       
        <td>HPA BANK: <?php if($model->hpaBank != 'Safe') echo $model->hpaBank; ?></td>
        
    </tr>

    <tr>
        <td>ALLOY WHEELS: <?php if($model->alloyWheels != 'Safe') echo $model->alloyWheels; ?></td>
        <td>CRUISE CONTROL: <?php if($model->cruiseControl != 'Safe') echo $model->cruiseControl; ?></td>
        <td>AIR CONDITION: <?php if($model->airCondition != '') echo $model->ltrearValue[$model->airCondition]; ?></td>
       
        <td>TYRE CONDITION: <?php if($model->tyreCondition != 'Safe') echo $model->tyreconditionValue[$model->tyreCondition]; ?></td>
        
    </tr>
    <tr>
        
       
        <td>RC OWNER NAME: <?php if($model->rcOwnerName != 'Safe') echo $model->rcOwnerName; ?></td>
        <td>NO OF OWNERS: <?php if($model->noOfOwners != 'Safe') echo $model->noOfOwners; ?></td>
        <td>INSURANCE TYPE:<?php if($model->insuranceType != 'Safe') echo  $model->insuranceType; ?></td>
       <td>FC VALIDITY: <?php if($model->fcValidity != 'Safe') echo $model->fcValidity; ?></td>
        
    </tr>
    <tr>
        <td>INSURANCE DATE: <?php if($model->insuranceDate != 'Safe') echo $model->insuranceDate; ?></td>
        <td>VALUATION LOCATION: <?php if($model->vehicleParkingLocation != 'Safe') echo $model->vehicleParkingLocation; ?></td>
        <td>TAX VALIDITY: <?php if($model->taxValidity != 'Safe') echo $model->taxValidity; ?></td>
        <td>RC-VERIFIED: <?php if($model->rcVerified != 'Safe') echo $model->rcVerified; ?></td>
    </tr>
    <tr>
        <td>HEAD LAMP / TAIL LAMP: <?php if($model->headLampAndTailLamp != 'Safe') echo $model->headLampAndTailLamp; ?></td>
        <td>CHASSIS / VEHICLE FRAME: <?php if($model->chassisAndVehicleFrame != 'Safe') echo $model->chassisAndVehicleFrame; ?></td>
        <td>-</td>
        <td>-</td>
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
         <?= Html::img(Yii::$app->basePath.'/'.$vqcLoc.$obj->image,["width"=>"180px","height"=>"135px"]) ?>
         </div>
         
         <?php
         break;
            }
         }
         ?>  
        </td>
        <td style="color: blue;">MARKET VALUE: &nbsp;Rs.<?php if($premodel->fixedMarketValue != 'Safe') echo $premodel->fixedMarketValue;?>/&nbsp;-</td>
    </tr>
</table>
</div>
<div class="spacebox"></div>
<div class="declarationbox">
    <strong>    
        <span style="text-decoration: underline; font-weight: bolder; font-size:10px; ">Declaration :</span>  As there is no standard price list for pre-owned / used vehicles, the vehicle valuation indicated in the report is our opinion on the
market value of the vehicle at the time of our valuation, based on our standard valuation methodology and procedures. Actual realization may
differ from the valuation indicated in the report and valuation of the car is primarily based on the condition of the vehicle at the time of valuation.
<div style="margin-top:10px;font-weight: bold; font-size:9px;">Declaration:- This is computer generated report and need not required any signature. </strong></div>    
</div>
<div class="spacebox"></div>
<div class="surveyorbox">
<table class="tftable">
    <tr>
        <td style="width:50%;">VALUATOR NAME: <?= $surveyor_name; ?></td>
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
                       <div class="img"><?= Html::img(Yii::$app->basePath.'/'.$vqcLoc.$obj->image,["width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>
</div>