
<?php

//$company = (isset($model->callerCompany)) ? $model->callerCompany : '';
//$companyName = ($company && isset($company->companyName)) ? $company->companyName : '';
//$companyAddress = ($company && isset($company->billingAddress)) ? $company->billingAddress : '';

$others = isset($hoModel->billDetails) ? json_decode($hoModel->billDetails) : '';
//echo '<pre>';print_r($others->totalKm);exit;
$totalKm=$total2W=$total3W=$total4W=$totalCW=$perKm=$per2w=$per3w=$per4w=$perCw=$igst=$sgst=$cgst=0;

if($others){
    $totalKm = isset($others->totalKm) ? $others->totalKm : 0;
    $total2W = isset($others->total2W) ? $others->total2W : 0;
    $total3W = isset($others->total3W) ? $others->total3W : 0;
    $total4W = isset($others->totalKm) ? $others->total4W : 0;
    $totalCW = isset($others->totalCW) ? $others->totalCW : 0;

    $perKm = isset($others->perKm) ? $others->perKm : 0;
    $per2w = isset($others->per2w) ? $others->per2w : 0;
    $per3w = isset($others->per3w) ? $others->per3w : 0;
    $per4w = isset($others->per4w) ? $others->per4w : 0;
    $perCw = isset($others->perCw) ? $others->perCw : 0;

    $igst = isset($others->igst) ? $others->igst : 0;
    $sgst = isset($others->sgst) ? $others->sgst : 0;
    $cgst = isset($others->cgst) ? $others->cgst : 0;
}


$totalKmRate = $totalKm * $perKm;
$total2wRate = $total2W * $per2w;
$total3wRate = $total3W * $per3w;
$total4wRate = $total4W * $per4w;
$totalCwRate = $totalCW * $perCw;


$totalIgst = $others && isset($others->totalIgst) ? $others->totalIgst: 0;
$totalSgst = $others && isset($others->totalSgst) ? $others->totalSgst: 0;
$totalCgst = $others && isset($others->totalCgst) ? $others->totalCgst: 0;
$totalGst = $others && isset($others->totalGst) ? $others->totalGst: 0;

$billAmount = $hoModel->billAmount;
$overallAmount = $hoModel->totalAmount;
$roundAmt = round($overallAmount);

$id = ($model->orderNo < 10) ? '0'.$model->orderNo : $model->orderNo;
//$id = ($hoModel->hoOrderNo < 10) ? '0'.$hoModel->hoOrderNo : $hoModel->hoOrderNo;

$logo = Yii::$app->request->baseUrl.'/images/logo.jpeg';
$date = date("d-M Y",strtotime($model->generatedDate));
$fromDate = date("F Y",strtotime($model->billPeriodFrom));


?>
<div class="container">

 <p style="float:right">
    <span>
        <img class="pull-right" src="<?= $logo ?>" style="height: 100px;width: 100px;"><br>
    </span>
</p> 
<div class="col-md-6">
    <span style="float: left;">Invoice No. <?= $model->billNumber ?><br>Ref. No. <?= $id ?></span>

</div>
<div class="col-md-6 marginTop" style="float:right;text-align: right;"><span style="float: right;" class="marginTop">Dated <?= $date ?></span>
</div>

<div class="clearfix"> </div>
<div class="text-center" style="margin-top: -20px;">
    <h3> Axion Technical Services Pvt Ltd</h3>
    <h6> No. 6234, TNHB Ayapakkam<br />
        Chennai 600077. <br />
        GSTIN/UIN: 33AAOCA3717H1ZR<br />
        State Name : Tamil Nadu, Code: 33<br />
        CIN: U74999TN2016PTC110288<br />
        E-Mail: mythili.gopi@axionpcs.in
    </h6>
</div>
<div class="clearfix"></div>
<div class="text-center">
    <h5 class="font-weight-bold"> For the Month of <?= $fromDate ?></h5>
    <h6>Party : <span class="font-weight-500 font-size-max"><?= $companyName ?></span></h6>
    <h6><?= $companyAddress ?></h6>
</div>

<div class="clearfix"></div>


<div class="table-responsive">
    <table class="table table-bordered table-sm summaryTable">
        <thead class="summaryTable">
            <tr class="summaryTable">
                <th class="text-center borderSide" style="border-right:1px solid #000;">SL.No</th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">Description of Services</th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">HSN/SAC </th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">Quantity</th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">Rate</th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">Per</th>
                <th class="text-center borderSide" style="border-right:1px solid #000;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sno = 1;
            if($total4W > 0){
                ?>
                <tr class="borderSide">
                    <td class="text-center font-weight-bold borderSide" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $sno ?></span></td>
                    <td class="text-center borderSide" style="border-right:1px solid #000;"><span class="font-weight-bold">4 Wheeler</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $total4W ?> Cases</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($per4w) ?></span></td>
                    <td class="text-center" style="border-right:1px solid #000;">Cases</td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($total4wRate) ?></span></td>
                </tr>
                <?php         
                $sno = 2;
            } 

            if($totalCW > 0){
                ?>
                <tr class="borderSide">
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $sno ?></span></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold">Commercial</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $totalCW ?> Cases</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($perCw) ?></span></td>
                    <td class="text-center" style="border-right:1px solid #000;">Cases</td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalCwRate) ?></span></td>
                </tr>
                <?php 
                $sno = ($sno==1) ? 2 : (($sno==2) ? 3 : 1); 
            }

            if($totalKm > 0){ ?>
                <tr class="borderSide">
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $sno ?></span></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold">Conveyance</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= $totalKm ?> Km</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($perKm) ?></span></td>
                    <td class="text-center" style="border-right:1px solid #000;">KM</td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalKmRate) ?></span></td>
                </tr>
            <?php } ?>
            <tr class="borderSide">
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-left" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right summaryTable"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($billAmount) ?></span></td>
            </tr>
            <?php if($igst > 0){ ?>
                <tr class="borderSide">
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">IGST</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><?= $igst ?></td>
                    <td class="text-left" style="border-right:1px solid #000;">%</td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalIgst) ?></span></td>
                </tr>
            <?php } if($cgst > 0){ ?>
                <tr class="borderSide">
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">CGST</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><?= $cgst ?></td>
                    <td class="text-left" style="border-right:1px solid #000;">%</td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalCgst) ?></span></td>
                </tr>
            <?php } if($sgst > 0){ ?>
                <tr class="borderSide">
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">SGST</span></td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right" style="border-right:1px solid #000;"><?= $sgst ?></td>
                    <td class="text-left" style="border-right:1px solid #000;">%</td>
                    <td class="text-center" style="border-right:1px solid #000;"></td>
                    <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalSgst) ?></span></td>
                </tr>
            <?php } ?>
            <tr class="borderSide">
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">Total GST</span></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($totalGst) ?></span></td>
            </tr>
            <tr class="summaryTable">
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">Total</span></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right"><span class="font-weight-bold"><?= Yii::$app->api->showDecimal($overallAmount) ?> <span class="inr-sign"></span></span></td>
            </tr>
            <tr class="summaryTable">
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right" style="border-right:1px solid #000;"><span class="font-weight-bold">Rounf Off</span></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-center" style="border-right:1px solid #000;"></td>
                <td class="text-right"><span class="font-weight-bold"><?= $roundAmt ?></span></td>
            </tr>
        </tbody>
    </table>
    <p>Amount Chargable(in words) <br> <span class="font-weight-bold"><?= Yii::$app->api->amountInWords($roundAmt) ?> Only</span></p>
</div>
 
<!--div class="col-md-4" style="float:left;">
    <span style="text-align:left;font-size: 12px;">Company’s Service Tax No. : AAOCA3717HSD001 <br>
    Company's PAN : AAOCA3717H </span>
</div>
<div class="col-md-4" style="float:right;">
    <span style="float:right;font-size: 12px;"> Company’s Service Tax No. : AAOCA3717HSD001 <br>
    Company's PAN : AAOCA3717H </span>
</div-->
</div>  