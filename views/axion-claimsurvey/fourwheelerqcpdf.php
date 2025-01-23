<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AxionClaimsurveyFourwheeler */
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


$clientName = \Yii::$app->params['clientName'];
$clientLogoUrl = \Yii::$app->params['clientLogoUrl'];
$clientAddress1 = \Yii::$app->params['clientAddress1'];
$clientAddress2 = \Yii::$app->params['clientAddress2'];
$clientPhone = \Yii::$app->params['clientPhone'];
$clientEmail = \Yii::$app->params['clientEmail'];

$companyList =ArrayHelper::map($company,'id','companyName');

$branchList = ArrayHelper::map($branch,'id','branchName');

$divisionList = ArrayHelper::map($division,'id','divisionName');

$callerList = ArrayHelper::map($caller,'id','firstName');
?>

    
    
    
<div class="box1">
<div class="topbox" >
   <table align="center">
        <tr>
             <td align="center"><h4>Name:<?php echo Yii::$app->user->identity->firstName; ?></h4></td>
            </tr><tr><td align="center"><h4>INSURANCE SURVEYOR/LOSS ASSESSOR</h4></td>
            <tr><td align="center"><h4><?php echo Yii::$app->user->identity->licenseNo; ?></h4></td>
            </tr></table>
            <table class="tftable">
       <tr>
        <td style="width:50%;">Email.Id: <?php echo Yii::$app->user->identity->email; ?></td>
        <td>Mobile.No: <?php echo Yii::$app->user->identity->mobile; ?></td>
    </tr>
       <tr>
        <td style="width:50%;">GST.No:</td>
        <td>PAN.No: <?php echo Yii::$app->user->identity->panNo; ?></td>
    </tr>
    <tr>
   <td rowspan="2">Address:</td>
   </tr>
   </table>
</div>
<div class="spacebox"></div>

<div class="surveyorbox">
<table class="tftable">
    <tr>
        <td style="width:50%;">REPORT NUMBER: <?= $premodel->referenceNo; ?></td>
        <td>REPORT DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?></td>
    </tr>
</table>
</div>

<h5 class="midtitle">MOTOR(Final)SURVEY REPORT</h5> 
<div class="declarationbox">
    <strong>
        This report is issued without prejudice, in respect of its cause, nature and extent of loss/damage, subject to the terms and conditions of the insurance policy.
    </strong>
</div>
<div class="spacebox"></div>

 <h5 class="midtitle">POLICY, INSURER AND INSURED PARTICULARS </h5></td>
<div id="firstbox">
    <table class="tftable" >
    <tr>
        <td width ="50%">POLICY NUMBER</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->policyNo; ?></td>
    </tr>
     <tr >
        <td>POLICY START PERIOD</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->policyStartPeriod; ?></td>
    </tr>
        <tr >
        <td>POLICY END PERIOD</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->policyEndPeriod; ?></td>
    </tr>
    <tr>
        <td>INSURER</td>
        <td style="width:3%;" align="center">:</td>
        <td><?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?>,<?= ($premodel->callerDivision)?$premodel->callerDivision->divisionName:''; ?>,<?= ($premodel->callerBranch)?$premodel->callerBranch->branchName:''; ?></td>
    </tr>

    <tr>
        <td>INSURED</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->insuredName; ?>,<?= $premodel->insuredMobile; ?>,<?= $premodel->insuredAddress; ?> </td>
    </tr>
    </table>
   
</div>

<h5 class="midtitle"> VEHICLE PARTICULARS </h5>

<div id="firstbox">
<table class="tftable">
    <tr>
        <td width ="50%">Claim Number</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->claimNumber; ?></td>
    </tr>
    <tr>
        <td width ="50%">Finance</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->finance; ?></td>
    </tr>
    <tr>
        <td width ="50%">Vehicle Type</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->claimVehicle; ?></td>
    </tr>
    <tr>
        <td>Registration No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->registrationNo; ?></td>
    </tr>
        <tr>
        <td>Registration Date</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->registrationDate; ?></td>
    </tr>
    <tr>
        <td>Chassis No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->chassisNo; ?></td>
    </tr>
        <tr>
        <td>Engine No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->engineNo; ?></td>
    </tr>
    <tr>
        <td>Make&nbsp;/&nbsp;Model</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= ($premodel->pricemake)?$premodel->pricemake->make:''; ?>&nbsp;/&nbsp;<?= ($premodel->pricemodel)?$premodel->pricemodel->model:''; ?></td>
    </tr>
    <tr>
        <td>Class Of Vehicle</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= ($premodel->pricevariant)?$premodel->pricevariant->variant:''; ?></td>
    </tr>

        <tr>
        <td>Type Of Body</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->typeOfBody; ?></td>
    </tr>
    <tr>
        <td>Pre-accident condition</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->preAccidentCondition; ?></td>
    </tr>
        <tr>
        <td>Passanger Carry Capacity</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->passangerCarryCapacity; ?></td>
    </tr>
    <tr>
        <td>Speedometer Reading</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->speedometerReading; ?></td>
    </tr>
        <tr>
        <td>Registered Laden Weight</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->registeredLadenWeight; ?></td>
    </tr>
    <tr>
        <td>Unladen Weight</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->unladenWeight; ?></td>
    </tr>
        <tr>
        <td>Tax / Valid Upto</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->taxType; ?></td>
    </tr>
    <tr>
        <td>Fitness Certificate Valid Upto</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->fitnessCertificateValidUpto; ?></td>
    </tr>
        <tr>
        <td>Permit Valid Upto</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->permitNoValidUpto; ?></td>
    </tr>
        <tr>
        <td>Permit Type</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->permitType; ?></td>
    </tr>
    <tr>
        <td>Area Operation</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $premodel->routeAreaOperation; ?></td>
    </tr>
</table>
   
</div>

<h5 class="midtitle"> DRIVER'S PARTICULARS </h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
        <td width ="50%">Name Of Driver</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->driverName; ?></td>
    </tr>
       <tr>
        <td>Driving Licence No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->drivingLicenceNo; ?></td>
    </tr>
       <tr>
        <td>Date Of Issue</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->dateOfIssue; ?></td>
    </tr>
      <tr>
        <td>Valid Upto</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->validUpto; ?></td>
    </tr>
       <tr>
        <td>Issuing Authority</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->issuingAuthority; ?></td>
    </tr>
       <tr>
        <td>Type Of Licence</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->typeOfLicence; ?></td>
    </tr>       
    <tr>
        <td>Badge No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->badgeNo; ?></td>
    </tr>

</table>
</div>

<div class="spacebox"></div>
<div class="spacebox"></div>
<div class="spacebox"></div>
<div class="spacebox"></div>
<div class="spacebox"></div>


<h5 class="midtitle"> DETAILS OF LOAD CHALLAN </h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
        <td width ="50%">Number</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->number; ?></td>
    </tr>
       <tr>
        <td>Load Date</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->loadDate; ?></td>
    </tr>
       <tr>
        <td>Load Weight</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->loadWeight; ?></td>
    </tr>
      <tr>
        <td>From</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->loadFrom; ?></td>
    </tr>
       <tr>
        <td>To</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->loadTo; ?></td>
    </tr>

</table>
</div>

<div class="spacebox"></div>

<h5 class="midtitle"> ACCIDENT & SURVEY PARTICULARS </h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
        <td width ="50%">Date and time of Accident</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->dateTimeAccident; ?></td>
    </tr>
       <tr>
        <td>Place Of Accident</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->placeOfAccident; ?></td>
    </tr>
       <tr>
        <td>Place Of Survey</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->placeOfSurvey; ?></td>
    </tr>
      <tr>
        <td>Date of Allotment of Survey</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->dateAllotmentOfSurvey; ?></td>
    </tr>
       <tr>
        <td>Date and Time of Survey</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->dateTimeOfSurvey; ?></td>
    </tr>
    

</table>
</div>

<div class="spacebox"></div>


<h5 class="midtitle"> POLICE PARTICULARS </h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
        <td width ="50%">The Accident has been reported to the police</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->accidentReportedToPolice; ?></td>
    </tr>
       <tr>
        <td>Name of Police Station</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->nameOfPoliceStation; ?></td>
    </tr>
       <tr>
        <td>Station Diary No</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->stationDiaryNo; ?></td>
    </tr>

</table>
</div>

<div class="spacebox"></div>

<h5 class="midtitle">THIRD PARTY</h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
        <td width ="50%">Third Party Details-If Any</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->thirdPartyDetails; ?></td>
    </tr>
       <tr>
        <td>Person Available at the time of Survey</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->personAvailableAtTimeOfSurvey; ?></td>
    </tr>
       <tr>
        <td>Whether the Vehicle was Removed For Repairs</td>
        <td style="width:3%;" align="center">:</td>
        <td> <?= $model->vehicleRemovedForRepairs; ?></td>
    </tr>

</table>
</div>


<div class="spacebox"></div>
<h5 class="midtitle">ASSESSMENT</h5>

<div id="vehiclebox">
<table class="tftable">
   <tr>
                <th>#</th>
                <th>Parts</th>
                <th>PartCode</th>
                <th>PartName</th>
                <th>Est-Amt</th>
                <th>Bil-Amt</th>
                <th>Assessed Amt</th>
                <th>GST(%)</th>
                <th>GST-Amt</th>
                <th>Total-Amt</th>
                <th>Dep(%)</th>
                <th>Dep-Amt</th>
                <th>Net-Amt</th>
            </tr>
    <tr>
        <td>1</td>
        <td><?= $model->assestspart; ?></td>
        <td><?= $metalicPart->metalicPartCode; ?></td>
        <td><?= $metalicPart->partName; ?></td>
        <td><?= $metalicPart->estimateAmt; ?></td>
        <td><?= $metalicPart->billedAmt; ?></td>
        <td><?= $metalicPart->assessedAmt; ?></td>
        <td><?= $metalicPart->gstTax; ?></td>
        <td><?= $metalicPart->gstTaxAmt; ?></td>
        <td><?= $metalicPart->totalAmt; ?></td>
        <td><?= $metalicPart->depri; ?></td>
        <td><?= $metalicPart->depriAmt; ?></td>
        <td><?= $metalicPart->netAmt; ?></td>
     
    </tr>
    <?php if($metalicPart->netAmt1 != '')  {?>
    <tr>
        <td>2</td>
        <td><?= $model->assestspart2; ?></td>
        <td><?= $metalicPart->metalicPartCode1; ?></td>
        <td><?= $metalicPart->partName1; ?></td>
        <td><?= $metalicPart->estimateAmt1; ?></td>
        <td><?= $metalicPart->billedAmt1; ?></td>
        <td><?= $metalicPart->assessedAmt1; ?></td>
        <td><?= $metalicPart->gstTax1; ?></td>
        <td><?= $metalicPart->gstTaxAmt1; ?></td>
        <td><?= $metalicPart->totalAmt1; ?></td>
        <td><?= $metalicPart->depri1; ?></td>
        <td><?= $metalicPart->depriAmt1; ?></td>
        <td><?= $metalicPart->netAmt1; ?></td>
     
    </tr>
<?php } ?>
<?php if($metalicPart->netAmt2 != '')  {?>
    <tr>
        <td>3</td>
        <td><?= $model->assestspart3; ?></td>
        <td><?= $metalicPart->metalicPartCode2; ?></td>
        <td><?= $metalicPart->partName2; ?></td>
        <td><?= $metalicPart->estimateAmt2; ?></td>
        <td><?= $metalicPart->billedAmt2; ?></td>
        <td><?= $metalicPart->assessedAmt2; ?></td>
        <td><?= $metalicPart->gstTax2; ?></td>
        <td><?= $metalicPart->gstTaxAmt2; ?></td>
        <td><?= $metalicPart->totalAmt2; ?></td>
        <td><?= $metalicPart->depri2; ?></td>
        <td><?= $metalicPart->depriAmt2; ?></td>
        <td><?= $metalicPart->netAmt2; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt3 != '')  {?>
    <tr>
        <td>4</td>
        <td><?= $model->assestspart4; ?></td>
        <td><?= $metalicPart->metalicPartCode3; ?></td>
        <td><?= $metalicPart->partName3; ?></td>
        <td><?= $metalicPart->estimateAmt3; ?></td>
        <td><?= $metalicPart->billedAmt3; ?></td>
        <td><?= $metalicPart->assessedAmt3; ?></td>
        <td><?= $metalicPart->gstTax3; ?></td>
        <td><?= $metalicPart->gstTaxAmt3; ?></td>
        <td><?= $metalicPart->totalAmt3; ?></td>
        <td><?= $metalicPart->depri3; ?></td>
        <td><?= $metalicPart->depriAmt3; ?></td>
        <td><?= $metalicPart->netAmt3; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt4 != '')  {?>
    <tr>
        <td>5</td>
        <td><?= $model->assestspart5; ?></td>
        <td><?= $metalicPart->metalicPartCode4; ?></td>
        <td><?= $metalicPart->partName4; ?></td>
        <td><?= $metalicPart->estimateAmt4; ?></td>
        <td><?= $metalicPart->billedAmt4; ?></td>
        <td><?= $metalicPart->assessedAmt4; ?></td>
        <td><?= $metalicPart->gstTax4; ?></td>
        <td><?= $metalicPart->gstTaxAmt4; ?></td>
        <td><?= $metalicPart->totalAmt4; ?></td>
        <td><?= $metalicPart->depri4; ?></td>
        <td><?= $metalicPart->depriAmt4; ?></td>
        <td><?= $metalicPart->netAmt4; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt5 != '')  {?>
    <tr>
        <td>6</td>
        <td><?= $model->assestspart6; ?></td>
        <td><?= $metalicPart->metalicPartCode5; ?></td>
        <td><?= $metalicPart->partName5; ?></td>
        <td><?= $metalicPart->estimateAmt5; ?></td>
        <td><?= $metalicPart->billedAmt5; ?></td>
        <td><?= $metalicPart->assessedAmt5; ?></td>
        <td><?= $metalicPart->gstTax5; ?></td>
        <td><?= $metalicPart->gstTaxAmt5; ?></td>
        <td><?= $metalicPart->totalAmt5; ?></td>
        <td><?= $metalicPart->depri5; ?></td>
        <td><?= $metalicPart->depriAmt5; ?></td>
        <td><?= $metalicPart->netAmt5; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt6 != '')  {?>
    <tr>
        <td>7</td>
         <td><?= $model->assestspart7; ?></td>
        <td><?= $metalicPart->metalicPartCode6; ?></td>
        <td><?= $metalicPart->partName6; ?></td>
        <td><?= $metalicPart->estimateAmt6; ?></td>
        <td><?= $metalicPart->billedAmt6; ?></td>
        <td><?= $metalicPart->assessedAmt6; ?></td>
        <td><?= $metalicPart->gstTax6; ?></td>
        <td><?= $metalicPart->gstTaxAmt6; ?></td>
        <td><?= $metalicPart->totalAmt6; ?></td>
        <td><?= $metalicPart->depri6; ?></td>
        <td><?= $metalicPart->depriAmt6; ?></td>
        <td><?= $metalicPart->netAmt6; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt7 != '')  {?>
    <tr>
        <td>8</td>
         <td><?= $model->assestspart8; ?></td>
        <td><?= $metalicPart->metalicPartCode7; ?></td>
        <td><?= $metalicPart->partName7; ?></td>
        <td><?= $metalicPart->estimateAmt7; ?></td>
        <td><?= $metalicPart->billedAmt7; ?></td>
        <td><?= $metalicPart->assessedAmt7; ?></td>
        <td><?= $metalicPart->gstTax7; ?></td>
        <td><?= $metalicPart->gstTaxAmt7; ?></td>
        <td><?= $metalicPart->totalAmt7; ?></td>
        <td><?= $metalicPart->depri7; ?></td>
        <td><?= $metalicPart->depriAmt7; ?></td>
        <td><?= $metalicPart->netAmt7; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt8 != '')  {?>
    <tr>
        <td>9</td>
         <td><?= $model->assestspart9; ?></td>
        <td><?= $metalicPart->metalicPartCode8; ?></td>
        <td><?= $metalicPart->partName8; ?></td>
        <td><?= $metalicPart->estimateAmt8; ?></td>
        <td><?= $metalicPart->billedAmt8; ?></td>
        <td><?= $metalicPart->assessedAmt8; ?></td>
        <td><?= $metalicPart->gstTax8; ?></td>
        <td><?= $metalicPart->gstTaxAmt8; ?></td>
        <td><?= $metalicPart->totalAmt8; ?></td>
        <td><?= $metalicPart->depri8; ?></td>
        <td><?= $metalicPart->depriAmt8; ?></td>
        <td><?= $metalicPart->netAmt8; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt9 != '')  {?>
    <tr>
        <td>10</td>
         <td><?= $model->assestspart10; ?></td>
        <td><?= $metalicPart->metalicPartCode9; ?></td>
        <td><?= $metalicPart->partName9; ?></td>
        <td><?= $metalicPart->estimateAmt9; ?></td>
        <td><?= $metalicPart->billedAmt9; ?></td>
        <td><?= $metalicPart->assessedAmt9; ?></td>
        <td><?= $metalicPart->gstTax9; ?></td>
        <td><?= $metalicPart->gstTaxAmt9; ?></td>
        <td><?= $metalicPart->totalAmt9; ?></td>
        <td><?= $metalicPart->depri9; ?></td>
        <td><?= $metalicPart->depriAmt9; ?></td>
        <td><?= $metalicPart->netAmt9; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt10 != '')  {?>
    <tr>
        <td>11</td>
         <td><?= $model->assestspart11; ?></td>
        <td><?= $metalicPart->metalicPartCode10; ?></td>
        <td><?= $metalicPart->partName10; ?></td>
        <td><?= $metalicPart->estimateAmt10; ?></td>
        <td><?= $metalicPart->billedAmt10; ?></td>
        <td><?= $metalicPart->assessedAmt10; ?></td>
        <td><?= $metalicPart->gstTax10; ?></td>
        <td><?= $metalicPart->gstTaxAmt10; ?></td>
        <td><?= $metalicPart->totalAmt10; ?></td>
        <td><?= $metalicPart->depri10; ?></td>
        <td><?= $metalicPart->depriAmt10; ?></td>
        <td><?= $metalicPart->netAmt10; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt11 != '')  {?>
    <tr>
        <td>12</td>
         <td><?= $model->assestspart12; ?></td>
        <td><?= $metalicPart->metalicPartCode11; ?></td>
        <td><?= $metalicPart->partName11; ?></td>
        <td><?= $metalicPart->estimateAmt11; ?></td>
        <td><?= $metalicPart->billedAmt11; ?></td>
        <td><?= $metalicPart->assessedAmt11; ?></td>
        <td><?= $metalicPart->gstTax11; ?></td>
        <td><?= $metalicPart->gstTaxAmt11; ?></td>
        <td><?= $metalicPart->totalAmt11; ?></td>
        <td><?= $metalicPart->depri11; ?></td>
        <td><?= $metalicPart->depriAmt11; ?></td>
        <td><?= $metalicPart->netAmt11; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt12 != '')  {?>
    <tr>
        <td>13</td>
         <td><?= $model->assestspart13; ?></td>
        <td><?= $metalicPart->metalicPartCode12; ?></td>
        <td><?= $metalicPart->partName12; ?></td>
        <td><?= $metalicPart->estimateAmt12; ?></td>
        <td><?= $metalicPart->billedAmt12; ?></td>
        <td><?= $metalicPart->assessedAmt12; ?></td>
        <td><?= $metalicPart->gstTax12; ?></td>
        <td><?= $metalicPart->gstTaxAmt12; ?></td>
        <td><?= $metalicPart->totalAmt12; ?></td>
        <td><?= $metalicPart->depri12; ?></td>
        <td><?= $metalicPart->depriAmt12; ?></td>
        <td><?= $metalicPart->netAmt12; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt13 != '')  {?>
    <tr>
        <td>14</td>
         <td><?= $model->assestspart14; ?></td>
        <td><?= $metalicPart->metalicPartCode13; ?></td>
        <td><?= $metalicPart->partName13; ?></td>
        <td><?= $metalicPart->estimateAmt13; ?></td>
        <td><?= $metalicPart->billedAmt13; ?></td>
        <td><?= $metalicPart->assessedAmt13; ?></td>
        <td><?= $metalicPart->gstTax13; ?></td>
        <td><?= $metalicPart->gstTaxAmt13; ?></td>
        <td><?= $metalicPart->totalAmt13; ?></td>
        <td><?= $metalicPart->depri13; ?></td>
        <td><?= $metalicPart->depriAmt13; ?></td>
        <td><?= $metalicPart->netAmt13; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt14 != '')  {?>
    <tr>
        <td>15</td>
         <td><?= $model->assestspart15; ?></td>
        <td><?= $metalicPart->metalicPartCode14; ?></td>
        <td><?= $metalicPart->partName14; ?></td>
        <td><?= $metalicPart->estimateAmt14; ?></td>
        <td><?= $metalicPart->billedAmt14; ?></td>
        <td><?= $metalicPart->assessedAmt14; ?></td>
        <td><?= $metalicPart->gstTax14; ?></td>
        <td><?= $metalicPart->gstTaxAmt14; ?></td>
        <td><?= $metalicPart->totalAmt14; ?></td>
        <td><?= $metalicPart->depri14; ?></td>
        <td><?= $metalicPart->depriAmt14; ?></td>
        <td><?= $metalicPart->netAmt14; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt15 != '')  {?>
    <tr>
        <td>16</td>
         <td><?= $model->assestspart16; ?></td>
        <td><?= $metalicPart->metalicPartCode15; ?></td>
        <td><?= $metalicPart->partName15; ?></td>
        <td><?= $metalicPart->estimateAmt15; ?></td>
        <td><?= $metalicPart->billedAmt15; ?></td>
        <td><?= $metalicPart->assessedAmt15; ?></td>
        <td><?= $metalicPart->gstTax15; ?></td>
        <td><?= $metalicPart->gstTaxAmt15; ?></td>
        <td><?= $metalicPart->totalAmt15; ?></td>
        <td><?= $metalicPart->depri15; ?></td>
        <td><?= $metalicPart->depriAmt15; ?></td>
        <td><?= $metalicPart->netAmt15; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt16 != '')  {?>
    <tr>
        <td>17</td>
         <td><?= $model->assestspart17; ?></td>
        <td><?= $metalicPart->metalicPartCode16; ?></td>
        <td><?= $metalicPart->partName16; ?></td>
        <td><?= $metalicPart->estimateAmt16; ?></td>
        <td><?= $metalicPart->billedAmt16; ?></td>
        <td><?= $metalicPart->assessedAmt16; ?></td>
        <td><?= $metalicPart->gstTax16; ?></td>
        <td><?= $metalicPart->gstTaxAmt16; ?></td>
        <td><?= $metalicPart->totalAmt16; ?></td>
        <td><?= $metalicPart->depri16; ?></td>
        <td><?= $metalicPart->depriAmt16; ?></td>
        <td><?= $metalicPart->netAmt16; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt17 != '')  {?>
    <tr>
        <td>18</td>
         <td><?= $model->assestspart18; ?></td>
        <td><?= $metalicPart->metalicPartCode17; ?></td>
        <td><?= $metalicPart->partName17; ?></td>
        <td><?= $metalicPart->estimateAmt17; ?></td>
        <td><?= $metalicPart->billedAmt17; ?></td>
        <td><?= $metalicPart->assessedAmt17; ?></td>
        <td><?= $metalicPart->gstTax17; ?></td>
        <td><?= $metalicPart->gstTaxAmt17; ?></td>
        <td><?= $metalicPart->totalAmt17; ?></td>
        <td><?= $metalicPart->depri17; ?></td>
        <td><?= $metalicPart->depriAmt17; ?></td>
        <td><?= $metalicPart->netAmt17; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt18 != '')  {?>
    <tr>
        <td>19</td>
         <td><?= $model->assestspart19; ?></td>
        <td><?= $metalicPart->metalicPartCode18; ?></td>
        <td><?= $metalicPart->partName18; ?></td>
        <td><?= $metalicPart->estimateAmt18; ?></td>
        <td><?= $metalicPart->billedAmt18; ?></td>
        <td><?= $metalicPart->assessedAmt18; ?></td>
        <td><?= $metalicPart->gstTax18; ?></td>
        <td><?= $metalicPart->gstTaxAmt18; ?></td>
        <td><?= $metalicPart->totalAmt18; ?></td>
        <td><?= $metalicPart->depri18; ?></td>
        <td><?= $metalicPart->depriAmt18; ?></td>
        <td><?= $metalicPart->netAmt18; ?></td>
     
    </tr>
    <?php } ?>
<?php if($metalicPart->netAmt19 != '')  {?>
    <tr>
        <td>20</td>
         <td><?= $model->assestspart20; ?></td>
        <td><?= $metalicPart->metalicPartCode19; ?></td>
        <td><?= $metalicPart->partName19; ?></td>
        <td><?= $metalicPart->estimateAmt19; ?></td>
        <td><?= $metalicPart->billedAmt19; ?></td>
        <td><?= $metalicPart->assessedAmt19; ?></td>
        <td><?= $metalicPart->gstTax19; ?></td>
        <td><?= $metalicPart->gstTaxAmt19; ?></td>
        <td><?= $metalicPart->totalAmt19; ?></td>
        <td><?= $metalicPart->depri19; ?></td>
        <td><?= $metalicPart->depriAmt19; ?></td>
        <td><?= $metalicPart->netAmt19; ?></td>
     
    </tr>
<?php } ?>
<?php if($labchPart->netAmt != '')  {?>
<tr>
        <td>21</td>
         <td><?= $model->assestspart21; ?></td>
        <td><?= $labchPart->metalicPartCode; ?></td>
        <td><?= $labchPart->partName; ?></td>
        <td><?= $labchPart->estimateAmt; ?></td>
        <td><?= $labchPart->billedAmt; ?></td>
        <td><?= $labchPart->assessedAmt; ?></td>
        <td><?= $labchPart->gstTax; ?></td>
        <td><?= $labchPart->gstTaxAmt; ?></td>
        <td><?= $labchPart->totalAmt; ?></td>
        <td><?= $labchPart->depri; ?></td>
        <td><?= $labchPart->depriAmt; ?></td>
        <td><?= $labchPart->netAmt; ?></td>
     
    </tr>
    <?php } ?>
     <?php if($labchPart->netAmt1 != '')  {?>
    <tr>
        <td>22</td>
         <td><?= $model->assestspart22; ?></td>
        <td><?= $labchPart->metalicPartCode1; ?></td>
        <td><?= $labchPart->partName1; ?></td>
        <td><?= $labchPart->estimateAmt1; ?></td>
        <td><?= $labchPart->billedAmt1; ?></td>
        <td><?= $labchPart->assessedAmt1; ?></td>
        <td><?= $labchPart->gstTax1; ?></td>
        <td><?= $labchPart->gstTaxAmt1; ?></td>
        <td><?= $labchPart->totalAmt1; ?></td>
        <td><?= $labchPart->depri1; ?></td>
        <td><?= $labchPart->depriAmt1; ?></td>
        <td><?= $labchPart->netAmt1; ?></td>
     
    </tr>
    <?php } ?>
    <?php if($labchPart->netAmt2 != '')  {?>
    <tr>
        <td>23</td>
         <td><?= $model->assestspart23; ?></td>
        <td><?= $labchPart->metalicPartCode2; ?></td>
        <td><?= $labchPart->partName2; ?></td>
        <td><?= $labchPart->estimateAmt2; ?></td>
        <td><?= $labchPart->billedAmt2; ?></td>
        <td><?= $labchPart->assessedAmt2; ?></td>
        <td><?= $labchPart->gstTax2; ?></td>
        <td><?= $labchPart->gstTaxAmt2; ?></td>
        <td><?= $labchPart->totalAmt2; ?></td>
        <td><?= $labchPart->depri2; ?></td>
        <td><?= $labchPart->depriAmt2; ?></td>
        <td><?= $labchPart->netAmt2; ?></td>
     
    </tr>
    <?php } ?>
    <?php if($labchPart->netAmt3 != '')  {?>
    <tr>
        <td>24</td>
         <td><?= $model->assestspart24; ?></td>
        <td><?= $labchPart->metalicPartCode3; ?></td>
        <td><?= $labchPart->partName3; ?></td>
        <td><?= $labchPart->estimateAmt3; ?></td>
        <td><?= $labchPart->billedAmt3; ?></td>
        <td><?= $labchPart->assessedAmt3; ?></td>
        <td><?= $labchPart->gstTax3; ?></td>
        <td><?= $labchPart->gstTaxAmt3; ?></td>
        <td><?= $labchPart->totalAmt3; ?></td>
        <td><?= $labchPart->depri3; ?></td>
        <td><?= $labchPart->depriAmt3; ?></td>
        <td><?= $labchPart->netAmt3; ?></td>
     
    </tr>
    <?php } ?>
    <?php if($labchPart->netAmt4 != '')  {?>
    <tr>
        <td>25</td>
         <td><?= $model->assestspart25; ?></td>
        <td><?= $labchPart->metalicPartCode4; ?></td>
        <td><?= $labchPart->partName4; ?></td>
        <td><?= $labchPart->estimateAmt4; ?></td>
        <td><?= $labchPart->billedAmt4; ?></td>
        <td><?= $labchPart->assessedAmt4; ?></td>
        <td><?= $labchPart->gstTax4; ?></td>
        <td><?= $labchPart->gstTaxAmt4; ?></td>
        <td><?= $labchPart->totalAmt4; ?></td>
        <td><?= $labchPart->depri4; ?></td>
        <td><?= $labchPart->depriAmt4; ?></td>
        <td><?= $labchPart->netAmt4; ?></td>
     
    </tr>
    <?php } ?>
<?php if($labchPart->netAmt5 != '')  {?>
    <tr>
        <td>26</td>
         <td><?= $model->assestspart26; ?></td>
        <td><?= $labchPart->metalicPartCode5; ?></td>
        <td><?= $labchPart->partName5; ?></td>
        <td><?= $labchPart->estimateAmt5; ?></td>
        <td><?= $labchPart->billedAmt5; ?></td>
        <td><?= $labchPart->assessedAmt5; ?></td>
        <td><?= $labchPart->gstTax5; ?></td>
        <td><?= $labchPart->gstTaxAmt5; ?></td>
        <td><?= $labchPart->totalAmt5; ?></td>
        <td><?= $labchPart->depri5; ?></td>
        <td><?= $labchPart->depriAmt5; ?></td>
        <td><?= $labchPart->netAmt5; ?></td>
     
    </tr>
    <?php } ?>
<?php if($labchPart->netAmt6 != '')  {?>
    <tr>
        <td>27</td>
         <td><?= $model->assestspart27; ?></td>
        <td><?= $labchPart->metalicPartCode6; ?></td>
        <td><?= $labchPart->partName6; ?></td>
        <td><?= $labchPart->estimateAmt6; ?></td>
        <td><?= $labchPart->billedAmt6; ?></td>
        <td><?= $labchPart->assessedAmt6; ?></td>
        <td><?= $labchPart->gstTax6; ?></td>
        <td><?= $labchPart->gstTaxAmt6; ?></td>
        <td><?= $labchPart->totalAmt6; ?></td>
        <td><?= $labchPart->depri6; ?></td>
        <td><?= $labchPart->depriAmt6; ?></td>
        <td><?= $labchPart->netAmt6; ?></td>
     
    </tr>
    <?php } ?>
<?php if($labchPart->netAmt7 != '')  {?>
    <tr>
        <td>28</td>
         <td><?= $model->assestspart28; ?></td>
        <td><?= $labchPart->metalicPartCode7; ?></td>
        <td><?= $labchPart->partName7; ?></td>
        <td><?= $labchPart->estimateAmt7; ?></td>
        <td><?= $labchPart->billedAmt7; ?></td>
        <td><?= $labchPart->assessedAmt7; ?></td>
        <td><?= $labchPart->gstTax7; ?></td>
        <td><?= $labchPart->gstTaxAmt7; ?></td>
        <td><?= $labchPart->totalAmt7; ?></td>
        <td><?= $labchPart->depri7; ?></td>
        <td><?= $labchPart->depriAmt7; ?></td>
        <td><?= $labchPart->netAmt7; ?></td>
     
    </tr>
    <?php } ?>
<?php if($labchPart->netAmt8 != '')  {?>
    <tr>
        <td>29</td>
         <td><?= $model->assestspart29; ?></td>
        <td><?= $labchPart->metalicPartCode8; ?></td>
        <td><?= $labchPart->partName8; ?></td>
        <td><?= $labchPart->estimateAmt8; ?></td>
        <td><?= $labchPart->billedAmt8; ?></td>
        <td><?= $labchPart->assessedAmt8; ?></td>
        <td><?= $labchPart->gstTax8; ?></td>
        <td><?= $labchPart->gstTaxAmt8; ?></td>
        <td><?= $labchPart->totalAmt8; ?></td>
        <td><?= $labchPart->depri8; ?></td>
        <td><?= $labchPart->depriAmt8; ?></td>
        <td><?= $labchPart->netAmt8; ?></td>
     
    </tr>
    <?php } ?>
<?php if($labchPart->netAmt9 != '')  {?>
    <tr>
        <td>30</td>
         <td><?= $model->assestspart30; ?></td>
        <td><?= $labchPart->metalicPartCode9; ?></td>
        <td><?= $labchPart->partName9; ?></td>
        <td><?= $labchPart->estimateAmt9; ?></td>
        <td><?= $labchPart->billedAmt9; ?></td>
        <td><?= $labchPart->assessedAmt9; ?></td>
        <td><?= $labchPart->gstTax9; ?></td>
        <td><?= $labchPart->gstTaxAmt9; ?></td>
        <td><?= $labchPart->totalAmt9; ?></td>
        <td><?= $labchPart->depri9; ?></td>
        <td><?= $labchPart->depriAmt9; ?></td>
        <td><?= $labchPart->netAmt9; ?></td>
     
    </tr>
    <?php } ?>

        <tfoot>
            <tr>
                <td colspan="4" align="right">TOTAL</td>
                <td><?= $model->estTotal; ?></td>
                <td><?= $model->billTotal; ?></td>
                <td><?= $model->assestTotal; ?></td>
                <td></td>
                <td><?= $model->gstcalTotal; ?></td>
                <td><?= $model->gstTotal; ?></td>
                <td></td>
                <td><?= $model->depTotal; ?></td>
                <td><?= $model->netTotal; ?></td>
            </tr>
            <tr>
                <td colspan="12" align="right">COMPULSORY EXCESS Rs.</td>
                <td><?= $model->compEx; ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">IMPOSED EXCESS Rs.</td>
                <td><?= $model->imposEx; ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">SALVAGE AMOUNT Rs.</td>
                <td><?= $model->salvEx; ?></td>
            </tr>
             <tr>
                <td colspan="12" align="right">NCB RECOVERY Rs.</td>
                <td><?= $model->ncbEx; ?></td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
                <td><?= $model->exTotal; ?></td>
            </tr>
             <tr>
            <td colspan="6" align="right"><h5>INSURER'S APPROXIMATE LIABILITY</h5></td>
                <td colspan="2"><h5>Rs.<?= $model->insurerTotal; ?></h5></td>
                <td colspan="5"></td>
            </tr>
        </tfoot>

</table>
</div>
<div class="spacebox"></div>

<div class="remarksbox">
<table class="tftable">
    <tr>
        <td style="width:30%;">Cause Of Accident: <?= $model->causeOfAccident; ?></td>
        <td style="width:35%; text-align: center; height: 160px;">
         <?php
         foreach($phmodel as $obj)
         {
            if($obj->image != '' && $obj->type == 'Photo-01')
            {
             ?>
         <div>
             <h5 style="text-align: center">Photo-01</h5>
         <?= Html::img(Yii::$app->basePath.'/'.$csqcLoc.$obj->image,["width"=>"180px","height"=>"135px"]) ?>
         </div>
         
         <?php
         break;
            }
         }
         ?>  
        </td>

    </tr>
</table>
</div>
<div class="spacebox"></div>



<div id="imgbox">
    
    <?php
        foreach($phmodel as $obj)
        {
            if($obj->image != '' && $obj->type != 'Photo-01')
            {
                ?>
                   <div class="imgdiv">
                       <div class="img"><?= Html::img(Yii::$app->basePath.'/'.$csqcLoc.$obj->image,["width"=>"100%","height"=>"280px"]) ?> </div>
                   </div>

                   <?php
            }

        }
       
        ?>

    <div style="clear: both"></div>    
</div>

<pagebreak />

<div class="topbox">
    <table align="center">
       <tr>
             <td align="center"><h4>Name:<?php echo Yii::$app->user->identity->firstName; ?></h4></td>
            </tr><tr><td align="center"><h4>INSURANCE SURVEYOR/LOSS ASSESSOR</h4></td>
            <tr><td align="center"><h4><?php echo Yii::$app->user->identity->licenseNo; ?></h4></td>
            </tr></table>
            <table class="tftable">
    <tr>
        <td style="width:50%;">Email.Id: <?php echo Yii::$app->user->identity->email; ?></td>
        <td>Mobile.No: <?php echo Yii::$app->user->identity->mobile; ?></td>
    </tr>
       <tr>
        <td style="width:50%;">GST.No:</td>
        <td>PAN.No: <?php echo Yii::$app->user->identity->panNo; ?></td>
    </tr>
      <tr>
   <td rowspan="3">Address:</td>
   </tr>
 
</table> 
</div>
<div class="spacebox"></div>

<h3 class="midtitle">BILL</h3>
<table class="tftable">
    <tr>
        <td style="width:50%;">BILL NUMBER: <?= $premodel->referenceNo; ?></td>
        <td>BILL DATE/TIME: <?= $premodel->intimationDate?date( 'd/m/Y h:i A', strtotime( $premodel->intimationDate )):''; ?></td>
    </tr>
</table>
<h4>To: </h4>
<p><?= ($premodel->callerCompany)?$premodel->callerCompany->companyName:''; ?>,<?= ($premodel->callerDivision)?$premodel->callerDivision->divisionName:''; ?>,<?= ($premodel->callerBranch)?$premodel->callerBranch->branchName:''; ?></p>
<div id="vehiclebox">
<table class="tftable">
    <tr>
        <th><h4>PARTICULARS</h4></th>
        <th><h4>AMOUNT</h4></th>
       
    </tr>
      <tr>
        <td><?= $bill->particular1; ?></td>
        <td><?= $bill->particularAmount1; ?></td>
     
    </tr>
    <tr>
      <td><?= $bill->particular2; ?></td>
        <td><?= $bill->particularAmount2; ?></td>
    </tr>
    <tr>
         <td><?= $bill->particular3; ?></td>
        <td><?= $bill->particularAmount3; ?></td>
    </tr>
     <tr>
         <td><?= $bill->particular4; ?></td>
        <td><?= $bill->particularAmount4; ?></td>
    </tr>
     <tr>
        <td><?= $bill->particular5; ?></td>
        <td><?= $bill->particularAmount5; ?></td>
     
    </tr>
    <tr>
      <td><?= $bill->particular6; ?></td>
        <td><?= $bill->particularAmount6; ?></td>
    </tr>
    <tr>
         <td><?= $bill->particular7; ?></td>
        <td><?= $bill->particularAmount7; ?></td>
    </tr>
    
     <tr>
         <td><?= $bill->particular8; ?></td>
        <td><?= $bill->particularAmount8; ?></td>
    </tr>
        <tr>
        <td align="right">Total....</td>
        <td><?= $bill->total; ?></td>
     
    </tr>
    <tr>
        <td align="left">SGST @ 9%</td>
       <td><?= $bill->sgst; ?></td>
    </tr>
    <tr>
         <td align="left">CGST @ 9%</td>
         <td><?= $bill->cgst; ?></td>
    </tr>
    <tr>
        <td align="right">Rounded off to.....</td>
     
        <td><?= $bill->roundedOffTo; ?></td>
    </tr>
  
</table>



</div>
<div class="remarksbox">
<table class="tftable">
    <tr>
        <td style="width:35%;"></td>
        <td style="width:35%; text-align: center; height: 160px;">Signature</td>
         
    </tr>
</table>
</div>




<div class="spacebox"></div>



</div>

