<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionValuationCommercial */
/* @var $form ActiveForm */
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
            <td width ="20%"><?= Html::img(Yii::$app->basePath.'/'.$clientLogoUrl,["width"=>"100px","height"=>"85px"]) ?></td>
            <td width="30%"></td>
            <td>
                <h3><?= $clientName ?></h3>
                <h6><?= $clientAddress1 ?></h6>
                <?php if($clientAddress2 != '') { echo '<h6>'.$clientAddress2.'</h6>'; }?> 
                <h6><?= $clientPhone ?></b></h6>
                <h6><?= $clientEmail ?></h6>
            </td></tr></table>  
</div>

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td><td><h5 class="midtitle"> COMMERCIAL VALUATION REPORT </h5></td></tr></table>

<div id="firstbox">
    <table class="tftable"  >
    <tr >
        <td style="width:35%;" >REQUEST NUMBER: <?= $premodel->referenceNo; ?></td>
        <td>INSURANCE COMPANY/CLIENT: <?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?> </td>
    </tr>
    <tr>
        <td style="border-bottom: 0" >CUSTOMER NAME: <?= $premodel->customerName; ?> </td>
        <td  style="border-bottom: 0">CUSTOMER CONTACT NUMBER: <?= $premodel->customerMobile; ?> </td>
    </tr>
</table>
    <table class="tftable"  >
    <tr>
        <td style="width:35%;">REQUEST DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?> </td>
        <td style="width:37%;">INSPECTION DATE/TIME: <?= $premodel->completedSurveyDateTime?date( 'd/m/Y h:i A', strtotime( $premodel->completedSurveyDateTime )):''; ?></td>
        <td>INSPECTION PLACE: <?= $premodel->vehicleLocation; ?></td>
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
        <td>MAKE: <?= ($premodel->pricemake)?$premodel->pricemake->make:'';?></td>
        <td>MODEL: <?= ($premodel->pricemodel)?$premodel->pricemodel->model:'';?></td>
        <td>VARIANT: <?= ($premodel->pricevariant)?$premodel->pricevariant->variant:'';?> </td>
    </tr>
    <tr>
        <td>MANUFACTURING YEAR: <?= $premodel->manufacturingYear; ?></td>
        <td>ODOMETER READING: <?= $model->odometerReading; ?></td>
        <td style="<?php if($model->rcVerified == 'No') echo 'color:red'; ?>">RC VERIFIED: <?= $model->rcVerified; ?></td>
    </tr>
    <tr>
        <td>BODY TYPE: <?= $model->bodyType; ?></td>
        <td>FUEL TYPE: <?= $model->fuelType; ?></td>
        <td></td>
    </tr>
</table>
</div>

<h5 class="midtitle"> VALUATION DETAILS </h5>

<div id="inspectionbox">
<table class="tftable">
    <tr>
        

        <td>INTERIOR:<?php if($model->interior != '') echo $model->CommenValue[$model->interior]; ?></td>
        <td >FRONT CABIN:<?php if($model->frontCabin != '') echo $model->CommenValue[$model->frontCabin]; ?></td>
    
        <td>REAR :<?php if($model->rear != '') echo $model->CommenValue[$model->rear]; ?></td>
        <td>CABIN DOOR RIGHT :<?php if($model->cabinDoorRight != '') echo $model->CommenValue[$model->cabinDoorRight]; ?></td>
        </tr>
    <tr>
    <td>CABIN DOOR LEFT :<?php if($model->cabinDoorLeft != '') echo $model->CommenValue[$model->cabinDoorLeft]; ?></td>
        <td>PAINT: <?php if($model->paint != 'Safe') echo $model->paint; ?></td>
    <td>CUBIC CAPACITY: <?php if($model->cubicCapacity != 'Safe') echo $model->cubicCapacity; ?></td>
        <td>TRANSMISSION CONDITION: <?php if($model->transmissionCondition != '') echo $model->CommenValue[$model->transmissionCondition]; ?></td>
       
        </tr>
    <tr>
        <td>HEADLAMP / TAILLAMP: <?php if($model->headLampTailLamp != '') echo $model->CommenValue[$model->headLampTailLamp]; ?></td>
        <td>AC :<?php if($model->ac != 'Safe') echo $model->ac; ?></td>
    
        
        <td>LIFT AXILE: <?php if($model->liftAxile != 'Safe') echo $model->liftAxile; ?></td>
        <td>CHASSIS CONDITION:<?php if($model->chassisCondition != '') echo $model->CommenValue[$model->chassisCondition]; ?></td>
        </tr>
   
    <tr>
        <td>ABS: <?php if($model->abs != 'Safe') echo $model->abs; ?></td>
        <td>NO OF SEATS: <?php if($model->noOfSeats != 'Safe') echo $model->noOfSeats; ?></td>
    
    <td>NO OF TYRE: <?php if($model->noOfTyre != 'Safe') echo $model->noOfTyre; ?></td>
       <td>AXLE CONDITION: <?php if($model->axleCondition != '') echo $model->CommenValue[$model->axleCondition]; ?></td>
       </tr>
    <tr>
        
        <td>WIND SHIELD: <?php if($model->windShield != 'Safe') echo $model->windShield; ?></td>
        <td>LOAD FLOOR: <?php if($model->loadFloor != '') echo $model->CommenValue[$model->loadFloor]; ?></td>
    
        <td>TAIL GATE:<?php if($model->tailGate != '') echo $model->CommenValue[$model->tailGate]; ?></td>
        <td>TYRE CONDITION:<?php if($model->tyreCondition != '') echo $model->CommenValue[$model->tyreCondition]; ?></td>
        </tr>
    <tr>
        <td>HPA BANK: <?php if($model->hpaBank != 'Safe') echo $model->hpaBank; ?></td>
        <td>OVER ALL BODY:<?php if($model->overAllLoadBody != '') echo $model->CommenValue[$model->overAllLoadBody]; ?></td>
        <td>LEFT BODY CONDITION: <?php if($model->leftBodyCondition != '') echo $model->CommenValue[$model->leftBodyCondition]; ?></td>
        <td>RIGHT BODY CONDITION: <?php if($model->rightBodyCondition != '') echo $model->CommenValue[$model->rightBodyCondition]; ?></td>
    </tr>
    <tr>
        <td>CLUTH CONDITION: <?php if($model->cluthCondition != '') echo $model->CommenValue[$model->cluthCondition]; ?></td>
        <td>STEERING: <?php if($model->steering != 'Safe') echo $model->steering; ?></td>
        <td>BRAKES: <?php if($model->brakes != '') echo $model->CommenValue[$model->brakes]; ?></td>
        <td>TAX VALIDITY: <?php if($model->taxValidity != 'Safe') echo $model->taxValidity; ?></td>
    </tr>

    <tr>
        <td>FC VALIDITY: <?php if($model->fcValidity != 'Safe') echo $model->fcValidity; ?></td>
        <td>DIFFERENTIAL CONDITION:<?php if($model->differentialCondition != '') echo $model->CommenValue[$model->differentialCondition]; ?></td>
        <td>VEHICLE CONDITION: <?php if($model->vehicleCondition != 'Safe') echo $model->vehicleCondition; ?></td>
        <td>VEHICLE OWNERSHIP: <?php if($model->vehicleOwnership != 'Safe') echo $model->vehicleOwnership; ?></td>
    </tr>
    <tr>
        <td>DIESEL PUMP:<?php if($model->dieselPump != 'Safe') echo $model->dieselPump; ?></td>
        <td>HPA: <?php if($model->hpa != 'Safe') echo $model->hpa; ?></td>
        <td>PAINT CONDITION: <?php if($model->paintCondition != '') echo $model->CommenValue[$model->paintCondition]; ?></td>
        <td>SUSPENSION: <?php if($model->suspension != '') echo $model->CommenValue[$model->suspension]; ?></td>
    </tr>

    <tr>
        <td>SEAT CONDITION: <?php if($model->seatsCondition != '') echo $model->CommenValue[$model->seatsCondition]; ?></td>
        <td>BATTERY CONDITION: <?php if($model->batteryCondition != '') echo $model->CommenValue[$model->batteryCondition]; ?></td>
        <td>ENGINE CONDITION: <?php if($model->engineCondition != '') echo $model->CommenValue[$model->engineCondition]; ?></td>
        <td>VALUATION LOCATION:<?php if($model->vehicleParkingLocation != 'Safe') echo $model->vehicleParkingLocation; ?></td>
    </tr>
    <tr>
        <td>VEHICLE TONNAGE: <?php if($model->vehicleTonnage != 'Safe') echo $model->vehicleTonnage; ?></td>
        <td>RC OWNER NAME: <?php if($model->rcOwnerName != 'Safe') echo $model->rcOwnerName; ?></td>
        <td>ROAD PERMIT: <?php if($model->roadPermit != 'Safe') echo $model->roadPermit; ?></td>
        <td>INSURANCE TYPE: <?php if($model->insuranceType != 'Safe') echo $model->insuranceType; ?></td>
    </tr>
    <tr>
        <td>INSURANCE DATE:<?php if($model->insuranceDate != 'Safe') echo $model->insuranceDate; ?></td>
        <td>VALUATION PRICE:<?php if($model->valuationPrice != 'Safe') echo $model->valuationPrice; ?></td>
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
        <td style="width:35%; text-align: center; height: 180px;">
         <?php
         foreach($phmodel as $obj)
         {
            if($obj->image != '' && $obj->type == 'chassisThumb')
            {
             ?>
            <div>
                <h5 style="text-align: center">Chassis Photo</h5>
            <?= Html::img(Yii::$app->basePath.'/'.$vqcLoc.$obj->image,["width"=>"195px","height"=>"160px"]) ?>
            </div>
         
            <?php
            break;
            }
         }
        ?>  
        </td>
        <td style="color: blue;">MARKET VALUE: &nbsp;Rs.<?php if($premodel->fixedMarketValue != 'Safe') echo $premodel->fixedMarketValue; ?></td>
    </tr>
</table>
</div>
<div class="spacebox"></div>
<div class="declarationbox">
    <strong>    
        <span style="text-decoration: underline; font-weight: bolder; font-size:10px; ">Declaration:</span> As there is no standard price list for pre-owned / used vehicles, the vehicle valuation indicated in the report is our opinion on the
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