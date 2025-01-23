<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspectionCommercial */
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

 <table><tr><td style="width:47%;"><?php if((strpos( Yii::$app->request->absoluteUrl, 'taig') !== false || strpos( Yii::$app->request->absoluteUrl, 'saptechservices.in') !== false) && $premodel->contactPersonMobileNo !== '' && $premodel->contactPersonMobileNo !== '0'){echo "ULN:".$premodel->contactPersonMobileNo; } ?></td><td><h5 class="midtitle"> COMMERCIAL INSPECTION REPORT </h5></td></tr></table>

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
        <td>ODOMETER READING: <?= $model->odometerReading; ?></td>
        <td style="<?php if($model->rcVerified == 'No') echo 'color:red'; ?>">RC VERIFIED: <?= $model->rcVerified; ?></td>
    </tr>
    <tr>
        <td>TYPE OF BODY: <?= $model->typeOfBody; ?></td>
        <td>FUEL TYPE: <?= $model->fuelType; ?></td>
        <td></td>
    </tr>
</table>
</div>

<h5 class="midtitle"> INSPECTION DETAILS </h5>

<div id="inspectionbox">
<table class="tftable">
    <tr>
        <td style="width:35%;<?php if($model->cabin != 'Safe') echo 'color:red'; ?>">CABIN: <?= $model->cabin; ?></td>
        <td style="<?php if($model->dashBoard != 'Safe') echo 'color:red'; ?>">DASH BOARD: <?= $model->dashBoard; ?></td>
        <td style="<?php if($model->frontSideBody != 'Safe') echo 'color:red'; ?>">FRONT SIDE BODY: <?= $model->frontSideBody; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rearSideBody != 'Safe') echo 'color:red'; ?>">REAR SIDE BODY: <?= $model->rearSideBody; ?></td>
        <td style="<?php if($model->rightSideBody != 'Safe') echo 'color:red'; ?>">RIGHT SIDE BODY: <?= $model->rightSideBody; ?></td>
        <td style="<?php if($model->leftSideBody != 'Safe') echo 'color:red'; ?>">LEFT SIDE BODY: <?= $model->leftSideBody; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->frontExcavator != 'Safe') echo 'color:red'; ?>">FRONT EXCAVATOR: <?= $model->frontExcavator; ?></td>
        <td style="<?php if($model->bonnet != 'Safe') echo 'color:red'; ?>">BONNET: <?= $model->bonnet; ?></td>
        <td style="<?php if($model->craneBucket != 'Safe') echo 'color:red'; ?>">CRANE BUCKET: <?= $model->craneBucket; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->craneHook != 'Safe') echo 'color:red'; ?>">CRANE HOOK: <?= $model->craneHook; ?></td>
        <td style="<?php if($model->ac != 'Safe') echo 'color:red'; ?>">AC: <?= $model->ac; ?></td>
        <td style="<?php if($model->boom != 'Safe') echo 'color:red'; ?>">BOOM: <?= $model->boom; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->fans != 'Safe') echo 'color:red'; ?>">FANS: <?= $model->fans; ?></td>
        <td style="<?php if($model->hydrualicSystem != 'Safe') echo 'color:red'; ?>">HYDRUALIC SYSTEM: <?= $model->hydrualicSystem; ?></td>
        <td style="<?php if($model->chassisFrame != 'Safe') echo 'color:red'; ?>">CHASSIS FRAME: <?= $model->chassisFrame; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->fuelTank != 'Safe') echo 'color:red'; ?>">FUEL TANK: <?= $model->fuelTank; ?></td>
        <td style="<?php if($model->seats != 'Safe') echo 'color:red'; ?>">SEATS: <?= $model->seats; ?></td>
        <td style="<?php if($model->tyres != 'Safe') echo 'color:red'; ?>">TYRES: <?= $model->tyres; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->spareTyre != 'Safe') echo 'color:red'; ?>">SPARE TYRE: <?= $model->spareTyre; ?></td>
        <td style="<?php if($model->headLights != 'Safe') echo 'color:red'; ?>">HEAD LIGHTS: <?= $model->headLights; ?></td>
        <td style="<?php if($model->indicatorLights != 'Safe') echo 'color:red'; ?>">INDICATOR LIGHTS: <?= $model->indicatorLights; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->doors != 'Safe') echo 'color:red'; ?>">DOORS: <?= $model->doors; ?></td>
        <td style="<?php if($model->wsGlass != 'Safe') echo 'color:red'; ?>">W.S. Glass: <?= $model->wsGlass; ?></td>
        <td style="<?php if($model->leftWindowGlass != 'Safe') echo 'color:red'; ?>">LEFT WINDOW GLASS: <?= $model->leftWindowGlass; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->rightWindowGlass != 'Safe') echo 'color:red'; ?>">RIGHT WINDOW GLASS: <?= $model->rightWindowGlass; ?></td>
        <td style="<?php if($model->backGlass != 'Safe') echo 'color:red'; ?>">BACK GLASS: <?= $model->backGlass; ?></td>
        <td style="<?php if($model->excavatorCabinGlass != 'Safe') echo 'color:red'; ?>">EXCAVATOR CABIN GLASS: <?= $model->excavatorCabinGlass; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->craneCabinGlass != 'Safe') echo 'color:red'; ?>">CRANE CABIN GLASS: <?= $model->craneCabinGlass; ?></td>
        <td style="<?php if($model->rearViewMirrors != 'Safe') echo 'color:red'; ?>">REAR VIEW MIRRORS: <?= $model->rearViewMirrors; ?></td>
        <td style="<?php if($model->tailLamps != 'Safe') echo 'color:red'; ?>">TAIL LAMPS: <?= $model->tailLamps; ?></td>
    </tr>
    <tr>
        <td>EXTRA FITTINGS: <?= $model->extraFittings; ?></td>
        <td></td>
        <td></td>
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
            <?= Html::img(Yii::$app->basePath.'/'.$qcLoc.$obj->image,['showWatermarkText' => true,
               'showWatermarkImage' => true,"width"=>"195px","height"=>"160px"]) ?>
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
                       <div class="img"><?= Html::img(Yii::$app->basePath.'/'.$qcLoc.$obj->image,['showWatermarkText' => true,
    'showWatermarkImage' => true,"width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>
</div>