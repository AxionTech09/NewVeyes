<?php
use app\models\CompanyBillingDetails;
use app\models\AxionPreinspectionBilling;

setlocale(LC_MONETARY, 'en_IN');

$company = (isset($model->callerCompany)) ? $model->callerCompany : '';
$companyName = ($company && isset($company->companyName)) ? $company->companyName : '';
$companyAddress = ($company && isset($company->billingAddress)) ? $company->billingAddress : '';

$billDetails = isset($model->billDetails) ? json_decode($model->billDetails) : '';
$companyId = (isset($company->companyId)) ? $company->companyId : $company->id;

// if ($companyId != 10) {
//     $perKm = ($company && isset($company->rateConveyance)) ? $company->rateConveyance : 0;
//     $per2w = ($company && isset($company->rate2Wheeler)) ? $company->rate2Wheeler : 0;
//     $per3w = ($company && isset($company->rate3Wheeler)) ? $company->rate3Wheeler : 0;
//     $per4w = ($company && isset($company->rate4Wheeler)) ? $company->rate4Wheeler : 0;
//     $perCw = ($company && isset($company->rateCommercial)) ? $company->rateCommercial : 0;
//     if($model->id == 8820){
//         $totalKm = 16218;
//         $total2W = 0;
//         $total3W = 0;
//         $total4W = 818;
//         $totalCW = 218;
//     }elseif ($model->id == 8118) {
//         $totalKm = 677;
//         $total2W = 0;
//         $total3W = 0;
//         $total4W = 59;
//         $totalCW = 3;
//     }elseif ($model->id == 8116) {
//         $totalKm = 26705;
//         $total2W = 0;
//         $total3W = 0;
//         $total4W = 253;
//         $totalCW = 171;
//     }elseif ($model->id == 8821) {
//         $totalKm = 13739;
//         $total2W = 0;
//         $total3W = 0;
//         $total4W = 977;
//         $totalCW = 200;
//     }
//     elseif ($model->id == 11498) {
//         $totalKm = 6904;
//         $total2W = 0;
//         $total3W = 0;
//         $total4W = 235;
//         $totalCW = 13;
//     }
//     else{
//         $totalKm = ($billDetails && $billDetails->totalKm) ? $billDetails->totalKm : 0;
//         $total2W = ($billDetails && $billDetails->total2W) ? $billDetails->total2W : 0;
//         $total3W = ($billDetails && $billDetails->total3W) ? $billDetails->total3W : 0;
//         $total4W = ($billDetails && $billDetails->total4W) ? $billDetails->total4W : 0;
//         $totalCW = ($billDetails && $billDetails->totalCW) ? $billDetails->totalCW : 0;
//     }

//     $totalKmRate = $perKm * $totalKm; //$model->amountTotalKm;
//     $total2wRate = $per2w * $total2W;//$model->amount2Wheeler;
//     $total3wRate = $per3w * $total3W;//$model->amount3Wheeler;
//     $total4wRate = $per4w * $total4W;//$model->amount4Wheeler;
//     $totalCwRate = $perCw * $totalCW;//$model->amountCommmercial;

    
//     $totalBillAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;

// }
// else {
//     $companyBillingdetails = CompanyBillingDetails::find()->where(['companyId' => $model->companyId])->all();
    
//     $totalEastKm = $totalEast2W = $totalEast3W = $totalEast4W = $totalEastCW = 0;
//     $totalKm = $total2W = $total3W = $total4W = $totalCW = 0;

//     // Check whether billing for ALL states
//     if (empty($model->stateId))
//     {
//         foreach ($companyBillingdetails as $companyBillingdetail) {
//             // For east states
//             if ($companyBillingdetail->stateId == 10 || $companyBillingdetail->stateId == 11 || $companyBillingdetail->stateId == 18) {
//                 $perEastKm = (isset($companyBillingdetail->rateConveyance)) ? $companyBillingdetail->rateConveyance : 0;
//                 $perEast2w = (isset($companyBillingdetail->rate2Wheeler)) ? $companyBillingdetail->rate2Wheeler : 0;
//                 $perEast3w = (isset($companyBillingdetail->rate3Wheeler)) ? $companyBillingdetail->rate3Wheeler : 0;
//                 $perEast4w = (isset($companyBillingdetail->rate4Wheeler)) ? $companyBillingdetail->rate4Wheeler : 0;
//                 $perEastCw = (isset($companyBillingdetail->rateCommercial)) ? $companyBillingdetail->rateCommercial : 0;
                
//                 $billingEast = AxionPreinspectionBilling::find()->where(['companyId' => $companyBillingdetail->companyId, 'stateId'=> $companyBillingdetail->stateId, 'orderNo' => $model->orderNo])->one();
//                 $billDetailsEast = isset($billingEast->billDetails) ? json_decode($billingEast->billDetails) : '';
                
//                 $totalEastKm += ($billDetailsEast->totalKm) ? $billDetailsEast->totalKm : 0;
//                 $totalEast2W += ($billDetailsEast->total2W) ? $billDetailsEast->total2W : 0;
//                 $totalEast3W += ($billDetailsEast->total3W) ? $billDetailsEast->total3W : 0;
//                 $totalEast4W += ($billDetailsEast->total4W) ? $billDetailsEast->total4W : 0;
//                 $totalEastCW += ($billDetailsEast->totalCW) ? $billDetailsEast->totalCW : 0;
//             }
//             else {
//                 $perKm = (isset($companyBillingdetail->rateConveyance)) ? $companyBillingdetail->rateConveyance : 0;
//                 $per2w = (isset($companyBillingdetail->rate2Wheeler)) ? $companyBillingdetail->rate2Wheeler : 0;
//                 $per3w = (isset($companyBillingdetail->rate3Wheeler)) ? $companyBillingdetail->rate3Wheeler : 0;
//                 $per4w = (isset($companyBillingdetail->rate4Wheeler)) ? $companyBillingdetail->rate4Wheeler : 0;
//                 $perCw = (isset($companyBillingdetail->rateCommercial)) ? $companyBillingdetail->rateCommercial : 0;
            
//                 $billingOtherState = AxionPreinspectionBilling::find()->where(['companyId' => $companyBillingdetail->companyId, 'stateId'=> $companyBillingdetail->stateId, 'orderNo' => $model->orderNo])->one();
//                 $billDetailsOtherStates = isset($billingOtherState->billDetails) ? json_decode($billingOtherState->billDetails) : '';
                
//                 $totalKm += ($billDetailsOtherStates->totalKm) ? $billDetailsOtherStates->totalKm : 0;
//                 $total2W += ($billDetailsOtherStates->total2W) ? $billDetailsOtherStates->total2W : 0;
//                 $total3W += ($billDetailsOtherStates->total3W) ? $billDetailsOtherStates->total3W : 0;
//                 $total4W += ($billDetailsOtherStates->total4W) ? $billDetailsOtherStates->total4W : 0;
//                 $totalCW += ($billDetailsOtherStates->totalCW) ? $billDetailsOtherStates->totalCW : 0;
//             }

//             if($model->id == 8249){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 2;
//                 $totalEastCW = 5;

//                 $totalKm = 7810;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 251;
//                 $totalCW = 93;
//             }elseif($model->id == 8599){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 3;
//                 $totalEastCW = 3;

//                 $totalKm = 5745;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 192;
//                 $totalCW = 58;
//             }elseif($model->id == 8955){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 1;
//                 $totalEastCW = 1;

//                 $totalKm = 5810;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 166;
//                 $totalCW = 53;
//             }elseif($model->id == 9305){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 39;
//                 $totalEastCW = 8;

//                 $totalKm = 6390;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 194;
//                 $totalCW = 41;

//                 $perKm = 2.75;
//             }elseif($model->id == 9682){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 40;
//                 $totalEastCW = 12;

//                 $totalKm = 9399;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 230;
//                 $totalCW = 64;

//                 $perKm = 2.75;
//             }elseif($model->id == 10068){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 18;
//                 $totalEastCW = 2;

//                 $totalKm = 6830;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 196;
//                 $totalCW = 50;

//                 $perKm = 2.75;
//             }elseif($model->id == 10445){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 1;
//                 $totalEastCW = 0;

//                 $totalKm = 4644;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 144;
//                 $totalCW = 23;

//                 $perKm = 2.75;
//             }
//             elseif($model->id == 10827){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 0;
//                 $totalEastCW = 0;

//                 $totalKm = 3096;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 179;
//                 $totalCW = 36;

//                 $perKm = 2.75;
//             }
//             elseif($model->id == 11219){
//                 $totalEastKm = 0;
//                 $totalEast2W = 0;
//                 $totalEast3W = 0;
//                 $totalEast4W = 8;
//                 $totalEastCW = 0;
    
//                 $totalKm = 6096;
//                 $total2W = 0;
//                 $total3W = 0;
//                 $total4W = 150;
//                 $totalCW = 44;
    
//                 $perKm = 2.75;
//             }
    
//             $totalEastKmRate = $totalEastKm * $perEastKm;
//             $totalEast2wRate = $totalEast2W * $perEast2w;
//             $totalEast3wRate = $totalEast3W * $perEast3w;
//             $totalEast4wRate = $totalEast4W * $perEast4w;
//             $totalEastCwRate = $totalEastCW * $perEastCw;
    
//             $totalKmRate = $totalKm * $perKm;
//             $total2wRate = $total2W * $per2w;
//             $total3wRate = $total3W * $per3w;
//             $total4wRate = $total4W * $per4w;
//             $totalCwRate = $totalCW * $perCw;

//             $totalBillAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate + $totalEastKmRate + $totalEast2wRate + $totalEast3wRate + $totalEast4wRate + $totalEastCwRate;
//         }
//     }
//     else
//     {
//         $companyBillingdetail = CompanyBillingDetails::find()->where(['companyId' => $model->companyId, 'stateId' => $model->stateId])->one();
//         // For east states
//         if ($companyBillingdetail->stateId == 10 || $companyBillingdetail->stateId == 11 || $companyBillingdetail->stateId == 18) {
//             $perEastKm = (isset($companyBillingdetail->rateConveyance)) ? $companyBillingdetail->rateConveyance : 0;
//             $perEast2w = (isset($companyBillingdetail->rate2Wheeler)) ? $companyBillingdetail->rate2Wheeler : 0;
//             $perEast3w = (isset($companyBillingdetail->rate3Wheeler)) ? $companyBillingdetail->rate3Wheeler : 0;
//             $perEast4w = (isset($companyBillingdetail->rate4Wheeler)) ? $companyBillingdetail->rate4Wheeler : 0;
//             $perEastCw = (isset($companyBillingdetail->rateCommercial)) ? $companyBillingdetail->rateCommercial : 0;
            
//             $billingEast = AxionPreinspectionBilling::find()->where(['companyId' => $companyBillingdetail->companyId, 'stateId'=> $companyBillingdetail->stateId, 'orderNo' => $model->orderNo])->one();
//             $billDetailsEast = isset($billingEast->billDetails) ? json_decode($billingEast->billDetails) : '';
            
//             $totalEastKm += ($billDetailsEast->totalKm) ? $billDetailsEast->totalKm : 0;
//             $totalEast2W += ($billDetailsEast->total2W) ? $billDetailsEast->total2W : 0;
//             $totalEast3W += ($billDetailsEast->total3W) ? $billDetailsEast->total3W : 0;
//             $totalEast4W += ($billDetailsEast->total4W) ? $billDetailsEast->total4W : 0;
//             $totalEastCW += ($billDetailsEast->totalCW) ? $billDetailsEast->totalCW : 0;
//         }
//         else {
//             $perKm = (isset($companyBillingdetail->rateConveyance)) ? $companyBillingdetail->rateConveyance : 0;
//             $per2w = (isset($companyBillingdetail->rate2Wheeler)) ? $companyBillingdetail->rate2Wheeler : 0;
//             $per3w = (isset($companyBillingdetail->rate3Wheeler)) ? $companyBillingdetail->rate3Wheeler : 0;
//             $per4w = (isset($companyBillingdetail->rate4Wheeler)) ? $companyBillingdetail->rate4Wheeler : 0;
//             $perCw = (isset($companyBillingdetail->rateCommercial)) ? $companyBillingdetail->rateCommercial : 0;
        
//             $billingOtherState = AxionPreinspectionBilling::find()->where(['companyId' => $companyBillingdetail->companyId, 'stateId'=> $companyBillingdetail->stateId, 'orderNo' => $model->orderNo])->one();
//             $billDetailsOtherStates = isset($billingOtherState->billDetails) ? json_decode($billingOtherState->billDetails) : '';
            
//             $totalKm += ($billDetailsOtherStates->totalKm) ? $billDetailsOtherStates->totalKm : 0;
//             $total2W += ($billDetailsOtherStates->total2W) ? $billDetailsOtherStates->total2W : 0;
//             $total3W += ($billDetailsOtherStates->total3W) ? $billDetailsOtherStates->total3W : 0;
//             $total4W += ($billDetailsOtherStates->total4W) ? $billDetailsOtherStates->total4W : 0;
//             $totalCW += ($billDetailsOtherStates->totalCW) ? $billDetailsOtherStates->totalCW : 0;
//         }

//         if($model->id == 8249){
//             $totalEastKm = 0;
//             $totalEast2W = 0;
//             $totalEast3W = 0;
//             $totalEast4W = 2;
//             $totalEastCW = 5;

//             $totalKm = 7810;
//             $total2W = 0;
//             $total3W = 0;
//             $total4W = 251;
//             $totalCW = 93;
//         }elseif($model->id == 8599){
//             $totalEastKm = 0;
//             $totalEast2W = 0;
//             $totalEast3W = 0;
//             $totalEast4W = 3;
//             $totalEastCW = 3;

//             $totalKm = 5745;
//             $total2W = 0;
//             $total3W = 0;
//             $total4W = 192;
//             $totalCW = 58;
//         }elseif($model->id == 10068){
//             $totalEastKm = 0;
//             $totalEast2W = 0;
//             $totalEast3W = 0;
//             $totalEast4W = 18;
//             $totalEastCW = 2;

//             $totalKm = 6830;
//             $total2W = 0;
//             $total3W = 0;
//             $total4W = 196;
//             $totalCW = 50;

//             $perKm = 2.75;
//         }

//         $totalEastKmRate = $totalEastKm * $perEastKm;
//         $totalEast2wRate = $totalEast2W * $perEast2w;
//         $totalEast3wRate = $totalEast3W * $perEast3w;
//         $totalEast4wRate = $totalEast4W * $perEast4w;
//         $totalEastCwRate = $totalEastCW * $perEastCw;

//         $totalKmRate = $totalKm * $perKm;
//         $total2wRate = $total2W * $per2w;
//         $total3wRate = $total3W * $per3w;
//         $total4wRate = $total4W * $per4w;
//         $totalCwRate = $totalCW * $perCw;

//         // $totalBillAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;
//         $totalBillAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate + $totalEastKmRate + $totalEast2wRate + $totalEast3wRate + $totalEast4wRate + $totalEastCwRate;
//     }
    

//     $totalKm += $totalEastKm;
//     if($model->id == 8249){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 8599){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 9305){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 9682){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 10068){ // elseif($model->id == 10068){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 10445){
//         $totalKmRate = $totalKmRate;
//     }elseif($model->id == 11219){
//         $totalKmRate = $totalKmRate;
//     }
//     else{
//         $totalKmRate = $model->amountTotalKm;
//     }
// }

$totalGst = $model->totalGst;
$overallAmount = $model->totalAmount;
$roundAmt = round($model->totalAmount);

$id = ($model->id < 10) ? '0'.$model->id : $model->id;
$logo = Yii::$app->request->baseUrl.'/images/logo.jpeg';
// if($model->companyId == 5){
//     $month_end = strtotime('last day of this month', strtotime($model->billPeriodFrom));    
//     $date = date('d-M-Y', $month_end);
// }else{
//     $month_start = strtotime('first day of next month', strtotime($model->billPeriodFrom));    
//     $date = date('d-M-Y', $month_start);
// }
$fromDate = date("M Y",strtotime($model->billPeriodFrom));
?>

<div class="container">

    <!--<div class="text-right header-section clearfix">
        <img src="images/Axion_logo_sm.png" class="pull-left header-logo" alt="header-logo" width="45" height="45">
        <h4 class="header-text pull-right">Axion Technical <br> Services Pvt Ltd</h4>
    </div>-->

    <br><br>
    
    <h3 class="font-weight-bold text-center tilte">Tax Invoice</h3>
    <table border="1">
        <tr>
            <td rowspan="3" colspan="2">
                <h4 class="font-weight-bold company-name">Axion Technical Services Pvt Ltd</h4>
                <h6> No 6234 TNHB Layout Ayapakkam Chennai, 600077, <br>
                    GSTIN/UIN: 33AAOCA3717H1ZR, <br>
                    State Name : Tamil Nadu, <br>
                    E-Mail : accounts.inspection@axionpcs.in <br>
                </h6>
            </td>
            <td colspan="2">
                <div>Invoice No.</div>
                <div class="font-weight-bold"><?=$model->billNumber?></div>
            </td>
            <td colspan="3">
                <div>Dated</div>
                <div class="font-weight-bold"><?=$date?></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>Delivery Note</div>
                <div class="font-weight-bold"></div>
            </td><br><br>
            <td colspan="3">
                <div>Reference No</div>
                <div class="font-weight-bold"><?=$model->orderNo?></div>
            </td>
        </tr>
        
        <tr>
            <td colspan="5" class="text-center">
                <div>For the month of <b class="font-weight-bold"><?=$fromDate?></b></div>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">

                <h6>Bill To:</h6>
                <h4 class="font-weight-bold text-capitalize company-name"><?= $companyName ?></h4>
                <h6>
                    <?php if (!empty($companyAddress))
                    { 
                        echo trim($companyAddress).', <br>';
                    }
                    else
                    {
                        echo '';
                    } ?>
                    <?php if ($companyId == 9)
                    { 
                        echo 'SBU Head: ' . $model->sbuHead->name . ', <br>';
                    }
                    else
                    {
                        echo '';
                    } ?>
                    GSTIN/UIN: <?=$company->gstNo?>, <br>
                    State Name : <?=ucwords(strtolower($company->state->state));?> <br>
                </h6>
            </td>
            <td colspan="5">
                <div>Terms of Delivery</div>
            </td>
        </tr>

        <!-- Billing Details Starts Here -->
        <br><br><br><br><br>
        <tr>
            <th>S.No</th>
            <th>Description Of Services</th>
            <th>HSN/SAC</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Per</th>
            <th>Amount</th>
        </tr>

        <!-- For ITGI -->
        <?php if ($companyId == 9) { ?>
            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone">1</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">2 Wheeler</td>
                <td class="border-topNone border-bottomNone padding-bottomNone">997134</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$total2W?> Nos</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $per2w)?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone">Nos</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$total2wRate?></td>
            </tr>
        <?php } ?>
        
            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=($companyId == 9) ? '2' : '1'?></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">4 Wheeler</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=($companyId == 9) ? '' : '997134'?></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$total4W?> Nos</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $per4w)?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone">Nos</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$total4wRate?></td>
            </tr>
        <?php
        ?>

        <tr>
            <td class="border-topNone border-bottomNone padding-bottomNone"><?php
                echo $companyId == 9 ? '3' : '2';
            ?></td>
            <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">Commercial</td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalCW?> Nos</td>
            <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $perCw)?></td>
            <td class="border-topNone border-bottomNone padding-bottomNone">Nos</td>
            <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalCwRate?></td>
        </tr>

        <!-- For Royal Sundaram -->
        <?php if ($companyId == 10) { ?>
            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone">3</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">East 4 Wheeler</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalEast4W?> Nos</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $perEast4w)?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone">Nos</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalEast4wRate?></td>
            </tr>

            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone">4</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">East Commercial</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalEastCW?> Nos</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $perEastCw)?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone">Nos</td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalEastCwRate?></td>
            </tr>      
        <?php } ?>

        <tr>
            <td class="border-topNone border-bottomNone padding-bottomNone"><?php
                echo $companyId == 10 ? '5' : ($companyId == 9 ? '4' : '3');
            ?></td>
            <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">Conveyance</td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone"><?=$totalKm?> KM</td>
            <td class="border-topNone border-bottomNone padding-bottomNone"><?=money_format('%!i', $perKm)?></td>
            <td class="border-topNone border-bottomNone padding-bottomNone">KM</td>
            <td class="font-weight-bold border-topNone border-bottomNone"><?=$totalKmRate?></td>
        </tr>

        <tr>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td class="border-topNone border-bottomNone padding-bottomNone"></td>
            <td><?=money_format('%!i', $totalBillAmount);?></td> <?php /* $model->billAmount */?>
        </tr>

        <br><br><br>
        <?php if ($company->billingState == 2) { ?>
            <?php
                $totalCGST = $totalBillAmount * $company->cgst / 100;
                $totalSGST = $totalBillAmount * $company->sgst / 100;
                $totalGST = $totalCGST + $totalSGST;
            ?>
            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone text-right">Output CGST</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone text-right"><?=($company->cgst) ? $company->cgst: ''?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=($company->cgst) ? '%': ''?></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">&#8377; <?=money_format('%!i', $totalCGST);?></td>
            </tr>

            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone text-right">Output SGST</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone text-right"><?=($company->sgst) ? $company->sgst: ''?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=($company->sgst) ? '%': ''?></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">&#8377; <?=money_format('%!i', $totalSGST);?></td>
            </tr>
        <?php } else { ?>
            <?php
                $totalIGST = $totalBillAmount * $company->igst / 100;
                $totalGST = $totalIGST;
            ?>
            <tr>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone text-right">Output IGST</td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"></td>
                <td class="border-topNone border-bottomNone padding-bottomNone text-right"><?=($company->igst) ? $company->igst: ''?></td>
                <td class="border-topNone border-bottomNone padding-bottomNone"><?=($company->igst) ? '%': ''?></td>
                <td class="font-weight-bold border-topNone border-bottomNone padding-bottomNone">&#8377; <?=money_format('%!i', $totalIGST);?></td>
            </tr>
        <?php } ?>
        
        <br><br>
        <?php
            $totalAmountWithGST = $totalBillAmount + $totalGST;
        ?>
        <tr>
            <td></td>
            <td class="font-weight-bold text-right">Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="font-weight-bold">&#8377; <?=money_format('%!i', $totalAmountWithGST);?></td> <?php /* $model->totalAmount */ ?>
        </tr>

        <tr>
            <td class="borderNone" colspan="6">
                <small>Amount Chargeable (in words)</small>
            </td>
            <td class="text-right borderNone"> <small>E. & O.E</small> </td>
        </tr>

        <tr>
            <td class="font-weight-bold border-topNone" colspan="7">
                INR <?= Yii::$app->api->amountInWords($totalAmountWithGST) ?> Only <?php /* $model->totalAmount */ ?>
            </td>
        </tr>
        <!-- Billing Details Ends Here -->

        <!-- Taxation Part Starts Here -->

        <br><br>
        <tr>
            <td <?=($company->billingState != 2) ? 'colspan="3"' : ''?> class="font-weight-bold text-center" rowspan="2">HSN/SAC</td>
            <td class="font-weight-bold" rowspan="2">Taxable Value</td>
            <?php if ($company->billingState == 2) { ?>
                <td class="font-weight-bold text-center" colspan="2">Central Tax</td>
                <td class="font-weight-bold text-center" colspan="2">State Tax</td>
            <?php } else { ?>
                <td class="font-weight-bold text-center" colspan="2">Integrated Tax</td>
            <?php } ?>
            <td class="font-weight-bold" rowspan="2">Taxable Value</td>
        </tr>
            
        <tr>
            <?php if ($company->billingState == 2) { ?>
                <td class="font-weight-bold">Rate</td>
                <td class="font-weight-bold">Amount</td>
                <td class="font-weight-bold">Rate</td>
                <td class="font-weight-bold">Amount</td>
            <?php } else { ?>
                <td class="font-weight-bold">Rate</td>
                <td class="font-weight-bold">Amount</td>
            <?php } ?>
        </tr>

        <tr>
            <td <?=($company->billingState != 2) ? 'colspan="3"' : ''?>>997134</td>
            <td><?=money_format('%!i', $totalBillAmount);?></td> <?php /* $model->billAmount */ ?>
            <?php if ($company->billingState == 2) { ?>
                <?php
                    $totalCGST = $totalBillAmount * $company->cgst / 100;
                    $totalSGST = $totalBillAmount * $company->sgst / 100;
                    $totalGST = $totalCGST + $totalSGST;
                ?>
                <td><?=($company->cgst) ? $company->cgst.'%': ''?></td>
                <td><?=money_format('%!i', $totalCGST);?></td> <?php /* $model->totalCgst */ ?>
                <td><?=($company->sgst) ? $company->sgst.'%': ''?></td>
                <td><?=money_format('%!i', $totalSGST);?></td> <?php /* $model->totalSgst */ ?>
            <?php } else { ?>
                <?php
                    $totalIGST = $totalBillAmount * $company->igst / 100;
                    $totalGST = $totalIGST;
                ?>
                <td><?=($company->igst) ? $company->igst.'%': ''?></td>
                <td><?=money_format('%!i', $totalIGST);?></td> <?php /* $model->totalIgst */ ?>
            <?php } ?>
            <td><?=money_format('%!i', $totalGST);?></td>
        </tr>

        <tr>
            <td class="font-weight-bold text-right" <?=($company->billingState != 2) ? 'colspan="3"' : ''?>>Total</td>
            <td class="font-weight-bold"><?=money_format('%!i', $totalBillAmount);?></td> <?php /* $model->billAmount */ ?>
            <?php if ($company->billingState == 2) { ?>
                <td></td>
                <td class="font-weight-bold"><?=money_format('%!i', $totalCGST);?></td> <?php /* $model->totalCgst */ ?>
                <td></td>
                <td class="font-weight-bold"><?=money_format('%!i', $totalSGST);?></td> <?php /* $model->totalSgst */ ?>
            <?php } else { ?>
                <td></td>
                <td class="font-weight-bold"><?=money_format('%!i', $totalIGST);?></td> <?php /* $model->totalIgst */ ?>
            <?php } ?>
            <td class="font-weight-bold"><?=money_format('%!i', $totalGST);?></td> <?php /* $model->totalGst */ ?>
        </tr>
                
        <tr>
            <td class="borderNone" colspan="7">
                <small>Tax Amount (in words)</small>
            </td>
        </tr>

        <tr>
            <td class="font-weight-bold borderNone" colspan="7">
                INR <?= Yii::$app->api->amountInWords($totalGST) ?> Only <?php /* $model->totalGst */ ?>
            </td>
        </tr>
        <tr>
            <td class="border-topNone" colspan="7">
                <h6 class="font-weight-bold side-heading">Company's Bank Details </h6> 
                Bank Name : State Bank of India, <br>
                A/c No. : 39018578008, <br>
                Branch & IFS Code: Ayappakkam, Chennai & SBIN0016403
        </tr>


        <!-- Taxation Part Starts Here -->
        <br>
        <tr>
            <td colspan="3">
                <h6 class="text-underline font-weight-bold">Declaration</h6><br>
                <div>We declare that this invoice shows the actual price of the
                    goods described and that all particulars are true and
                    correct.</div>
            </td><br><br><br>
            <td colspan="4">
                <h4 class="font-weight-bold company-name">for Axion Technical Services Pvt Ltd </h4>
                <img src="images/axion_sign.png" alt="digital-sign" height="100">
                <!-- Billing_digital_sign.jpg -->
                <!-- <br><br><br><br><br><br> -->
                <p>Authorised Signatory</p>
            </td>
        </tr>

    </table>
</div>

