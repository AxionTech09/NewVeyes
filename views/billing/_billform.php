<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AxionPreinspection */
/* @var $form yii\widgets\ActiveForm */

date_default_timezone_set('Asia/Calcutta');
//$paymentArray = $model->paymentValue;


$company = (isset($model->callerCompany)) ? $model->callerCompany : '';
$companyName = ($company && isset($company->companyName)) ? $company->companyName : '';
$companyAddress = ($company && isset($company->billingAddress)) ? $company->billingAddress : '';

$others = isset($model->billDetails) ? json_decode($model->billDetails) : '';
//echo '<pre>';print_r($others->totalKm);exit;
$totalKm = ($others && $others->totalKm) ? $others->totalKm : 0;
$total2W = 0;//($others && $others->total2W) ? $others->total2W : 0;
$total3W = 0;//($others && $others->total3W) ? $others->total3W : 0;
$total4W = ($others && $others->totalKm) ? $others->total4W : 0;
$totalCW = ($others && $others->totalCW) ? $others->totalCW : 0;
$totalEast4W = ($others && $others->totalEast4W) ? $others->totalEast4W : 0;
$totalEastCW = ($others && $others->totalEastCW) ? $others->totalEastCW : 0;

$perKm = ($company && isset($company->rateConveyance)) ? $company->rateConveyance : 0;
$per2w = 0;//($company && isset($company->rate2Wheeler)) ? $company->rate2Wheeler : 0;
$per3w = 0;//($company && isset($company->rate3Wheeler)) ? $company->rate3Wheeler : 0;
$per4w = ($company && isset($company->rate4Wheeler)) ? $company->rate4Wheeler : 0;
$perCw = ($company && isset($company->rateCommercial)) ? $company->rateCommercial : 0;

$igst = ($company && isset($company->igst)) ? $company->igst : 0;
$sgst = ($company && isset($company->sgst)) ? $company->sgst : 0;
$cgst = ($company && isset($company->cgst)) ? $company->cgst : 0;


$totalKmRate = $totalKm * $perKm;
$total2wRate = 0;//$total2W * $per2w;
$total3wRate = 0;//$total3W * $per3w;
$total4wRate = $total4W * $per4w;
$totalCwRate = $totalCW * $perCw;



$totalAmount = $totalKmRate + $total2wRate + $total3wRate + $total4wRate + $totalCwRate;

$totalIgst = ($totalAmount * $igst) / 100;
$totalSgst = ($totalAmount * $sgst) / 100;
$totalCgst = ($totalAmount * $cgst) / 100;

$totalGst = $totalIgst + $totalSgst + $totalCgst;
$overallAmount = $totalAmount + $totalGst;
$roundAmt = round($overallAmount);
?>

<style>
.editinput input{
    display:none;
}
.editinput span, .editinput a{
    display:block;
}
.editinput.active input{
    display:block;
}
.editinput.active span, .editinput.active a{
    display:none;
}
</style>    

<div class="preinspection-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
    
    <div id="company_details" class="preinspection-box">
       
   
    <div class="form-group">
    <?= $form->field($model, 'billNumber')->textInput(['readonly' =>true]) ?>
    </div>        



        <div class="table-responsive">
<h4>Vehicle Details</h2>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th class="text-center">Sr.No</th>
            <th class="text-center">Vehicle Type</th>
            <th class="text-center">Cases</th>
            <th class="text-center">Rate (INR)</th>
            <th class="text-center">Amount (INR)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">Commercial Vehicle</td>
            <td class="text-center">
                <div class="col-md-12">
                <?= $form->field($model, 'totalCW')->textInput(['maxlength' => true,'value' => $totalCW,'class'=>'text-center totalCW','id'=>'totalCW'])->label(false) ?>
                </div>
            </td>
            <td class="text-center editinput">
                <span class="perCw"><?= Yii::$app->api->showDecimal($perCw) ?></span>
                <input type="text" class="numeric perCw" value="<?= Yii::$app->api->showDecimal($perCw) ?>">
                <a href="javascript:;" class="edit">Edit</a>
            </td>
            <td class="text-right totalCwRate"><?= Yii::$app->api->showDecimal($totalCwRate) ?></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="text-center">Four Wheeler</td>
             <td class="text-center">
                <div class="col-md-12">
                <?= $form->field($model, 'total4W')->textInput(['maxlength' => true,'value' => $total4W,'class'=>'text-center total4W','id'=>'total4W'])->label(false) ?>
                </div>
            </td>
            <td class="text-center editinput">
                <span class="per4w"><?= Yii::$app->api->showDecimal($per4w) ?></span>
                <input type="text" class="numeric per4w" value="<?= Yii::$app->api->showDecimal($per4w) ?>">
                <a href="javascript:;" class="edit">Edit</a>
            </td>
            <td class="text-right total4wRate"><?= Yii::$app->api->showDecimal($total4wRate) ?></td>
        </tr>

        <?php if($model->companyId == 10){ ?>
            <tr>
                <td class="text-center">3</td>
                <td class="text-center">East 4 Wheeler </td>
                <td class="text-center">
                    <div class="col-md-12">
                    <?= $form->field($model, 'totalEast4W')->textInput(['maxlength' => true,'value' => $totalEast4W,'class'=>'text-center totalEast4W','id'=>'totalEast4W'])->label(false) ?>
                    </div>
                </td>
                <td class="text-center editinput">
                    <span class="perEast4w"><?= Yii::$app->api->showDecimal($perEast4w) ?></span>
                    <input type="text" class="numeric perEast4w" value="<?= Yii::$app->api->showDecimal($perEast4w) ?>">
                    <a href="javascript:;" class="edit">Edit</a>
                </td>
                <td class="text-right totalEast4wRate"><?= Yii::$app->api->showDecimal($totalEast4wRate) ?></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td class="text-center">East Commercial </td>
                <td class="text-center">
                    <div class="col-md-12">
                    <?= $form->field($model, 'totalEastCW')->textInput(['maxlength' => true,'value' => $totalEastCW,'class'=>'text-center totalEastCW','id'=>'totalEastCW'])->label(false) ?>
                    </div>
                </td>
                <td class="text-center editinput perEastCw">
                    <span class="perEastCw"><?= Yii::$app->api->showDecimal($perEastCw) ?></span>
                    <input type="text" class="numeric perEastCw" value="<?= Yii::$app->api->showDecimal($perEastCw) ?>">
                    <a href="javascript:;" class="edit">Edit</a>
                </td>
                <td class="text-right totalEastCWRate"><?= Yii::$app->api->showDecimal($totalEastCWRate) ?></td>
            </tr>
            <tr>
            <td class="text-center">5</td>
            <td class="text-center">Conveyance</td>
            <td class="text-center">
                <div class="col-md-12">
                <?= $form->field($model, 'totalKm')->textInput(['maxlength' => true,'value' => $totalKm,'class'=>'text-center totalKm','id'=>'totalKm'])->label(false) ?>
                </div>
            </td>
            <td class="text-center editinput perKm">
                <span class="perKm"><?= Yii::$app->api->showDecimal($perKm) ?></span>
                <input type="text" class="numeric perKm" value="<?= Yii::$app->api->showDecimal($perKm) ?>">
                <a href="javascript:;" class="edit">Edit</a>
            </td>
            <td class="text-right totalKmRate"><?= Yii::$app->api->showDecimal($totalKmRate) ?></td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td class="text-center">3</td>
            <td class="text-center">Conveyance</td>
            <td class="text-center">
                <div class="col-md-12">
                <?= $form->field($model, 'totalKm')->textInput(['maxlength' => true,'value' => $totalKm,'class'=>'text-center totalKm','id'=>'totalKm'])->label(false) ?>
                </div>
            </td>
            <td class="text-center editinput">
                <span class="perKm"><?= Yii::$app->api->showDecimal($perKm) ?></span>
                <input type="text" class="numeric perKm" value="<?= Yii::$app->api->showDecimal($perKm) ?>">
                <a href="javascript:;" class="edit">Edit</a>
            </td>
            <td class="text-right totalKmRate"><?= Yii::$app->api->showDecimal($totalKmRate) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

        
    <div class="clear"></div>

    <div class="table-responsive">
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>Total</th>
            <th class="text-right totalAmount"><?= Yii::$app->api->showDecimal($totalAmount) ?></th>
        </tr>
       
        <tr>
            <th>Total GST</th>
            <th class="text-right totalGst"><?= Yii::$app->api->showDecimal($totalGst) ?></th>
        </tr>
        <tr>
            <th>Grand Total</th>
            <th class="text-right overallAmount"><?= Yii::$app->api->showDecimal($overallAmount) ?></th>
        </tr>
         <tr>
            <th>Round Off</th>
            <th class="text-right roundAmt"><?= $roundAmt ?></th>
        </tr>
    </thead>
</table>
</div>
<?= $form->field($model, 'totalAmount')->hiddenInput(['value' => $totalAmount,'id'=>'totalAmount'])->label(false) ?>
<?= $form->field($model, 'totalGst')->hiddenInput(['value' => $totalGst,'id'=>'totalGst'])->label(false) ?>
<?= $form->field($model, 'overallAmount')->hiddenInput(['value' => $overallAmount,'id'=>'overallAmount'])->label(false) ?>
<?= $form->field($model, 'roundAmt')->hiddenInput(['value' => $roundAmt,'id'=>'roundAmt'])->label(false) ?>
<?= $form->field($model, 'igst')->hiddenInput(['value' => $igst,'id'=>'igst'])->label(false) ?>
<?= $form->field($model, 'cgst')->hiddenInput(['value' => $cgst,'id'=>'cgst'])->label(false) ?>
<?= $form->field($model, 'sgst')->hiddenInput(['value' => $sgst,'id'=>'sgst'])->label(false) ?>
<?= $form->field($model, 'total3W')->hiddenInput(['value' => $total3W,'id'=>'total3W'])->label(false) ?>
<?= $form->field($model, 'total2W')->hiddenInput(['value' => $total2W,'id'=>'total2W'])->label(false) ?>
    
    <?php  echo Html::hiddenInput('name', $model->isNewRecord?"Y":"N", ['id' => 'newRecord']); ?>
    <?php if($model->billStatus == 'Billed'){ ?>
    <div class="form-group">
        <?= Html::submitButton( 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
<?php } ?>
    <div id="ajaxLoad">
        <img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
    </div>
    <?php
    
    ActiveForm::end(); ?>
    
</div>



<?php
$script = <<< JS
   $('input[type="text"]').on("change",function(){
        $(this).parent().find('span').text($(this).val());
        console.log($(this).val());
        var totalCW = $('#totalCW').val() ?? 0;
        var total4W = $('#total4W').val() ?? 0;
        var total3W = 0; //$('#total3W').val();
        var total2W = 0; //$('#total2W').val();
        var totalKm = $('#totalKm').val() ?? 0;

        // East

        var totalEast4W = $('.totalEast4W').val() ?? 0;
        var totalEastCW = $('.totalEastCW').val() ?? 0;

        var igst = $('#igst').val() ?? 0;
        var cgst = $('#cgst').val() ?? 0;
        var sgst = $('#sgst').val() ?? 0;


        var perCw = $('span.perCw').text() ?? 0;
        var per4W = $('span.per4w').text() ?? 0;
        var per3W = 0; //$('.per3w').text();
        var per2W = 0; //$('.per2w').text();
        var perKm = $('span.perKm').text() ?? 0;
        var perEast4W = $('span.perEast4w').text() ?? 0;
        var perEastCw = $('span.perEastCw').text() ?? 0;

        var totalCwRate = totalCW * perCw;
        var total4wRate = total4W * per4W;
        var total3wRate = 0; //total3W * per3W;
        var total2wRate = 0; //total2W * per2W;
        var totalKmRate = totalKm * perKm;        
        var totalEastCwRate = totalEastCW * perEastCw;
        var totalEast4wRate = totalEast4W * perEast4W;
        console.log('totalEastCW - ' +totalEastCW+' * '+ 'perEastCw - '+perEastCw);
        console.log('totalEast4W - ' +totalEast4W+' * '+ 'perEast4W - '+perEast4W);
        console.log(totalEastCwRate);
        // $(".totalEast4wRate").text(totalEast4wRate.toFixed(2));
        // $('.totalEastCWRate').text(totalEastCwRate.toFixed(2));
        // return false;
        var totalAmount = parseFloat(totalKmRate.toFixed(2)) + parseFloat(total2wRate.toFixed(2)) + parseFloat(total3wRate.toFixed(2)) + parseFloat(total4wRate.toFixed(2)) + parseFloat(totalCwRate.toFixed(2)) + parseFloat(totalEastCwRate.toFixed(2)) + parseFloat(totalEast4wRate.toFixed(2));

        var totalIgst = (totalAmount * igst) / 100;
        var totalSgst = (totalAmount * sgst) / 100;
        var totalCgst = (totalAmount * cgst) / 100;

        var totalGst = parseFloat(totalIgst) + parseFloat(totalSgst) + parseFloat(totalCgst);
        var overallAmount = parseFloat(totalAmount) + parseFloat(totalGst);
        var roundAmt = Math.round(overallAmount);

        $(".totalCwRate").text(totalCwRate.toFixed(2));
        $(".total4wRate").text(total4wRate.toFixed(2));
        $(".totalEastCWRate").text(totalEastCwRate.toFixed(2));
        $(".totalEast4wRate").text(totalEast4wRate.toFixed(2));
        //$(".total3wRate").text(total3wRate.toFixed(2));
        //$(".total2wRate").text(total2wRate.toFixed(2));
        $(".totalKmRate").text(totalKmRate.toFixed(2));

        $(".totalAmount").text(totalAmount.toFixed(2));
        $(".totalGst").text(totalGst.toFixed(2));
        $(".overallAmount").text(overallAmount.toFixed(2));
        $(".roundAmt").text(roundAmt);    

        $("#totalAmount").val(totalAmount.toFixed(2));
        $("#totalGst").val(totalGst.toFixed(2));
        $("#overallAmount").val(overallAmount.toFixed(2));
        $("#roundAmt").val(roundAmt);    


    });     
$('#AxionPreinspectionBilling').on('beforeSubmit', function(e) 
{
        var lastStatus = $('#lastStatus').val();
        var newRecord = $('#newRecord').val();
        var totalCW = $('#totalCW').val();
        var total4W = $('#total4W').val();
        //var total3W = $('#total3W').val();
        //var total2W = $('#total2W').val();
        var totalKm = $('#totalKm').val();
      
        if(totalCW =='')
        {
            alert("Please enter Number of Commercial Cases");
            return false;
        }

        if(total4W =='')
        {
            alert("Please enter Number of Four Wheelers");
            return false;
        }

        /*if(total3W =='')
        {
            alert("Please enter Number of Three Wheelers");
            return false;
        }

        if(total2W =='')
        {
            alert("Please enter Number of Two Wheelers");
            return false;
        }*/

        if(totalKm =='')
        {
            alert("Please enter Total Conveyance");
            return false;
        }

        
        var form = $(this);

        var formData = form.serialize();

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            beforeSend: function() {
                 $("#loading-image").show();
              },
            success: function (data) {
                   if(data != '')
                   {
                      var res = $.parseJSON(data)
                      if(res.status != 'success')
                      {
                        alert("Update Failed");
                        window.location.href = "./";
                      }
                      else{
                        alert("Records Updated Succesfully");
                        $(document).find('#update-modal').modal('hide');
                        $(form).trigger("reset");
                        //$('#w0').yiiGridView('applyFilter');
                        $("#loading-image").hide();
                        location.reload();
                      }
                    }
            },
            error: function (jqXHR, exception) {
                //alert("Something went wrong");
                alert(jqXHR.responseText);
            }
        });
}).on('submit', function(e){
    e.preventDefault();
});
$('.edit').click(function(){
    $(this).parent().addClass('active');
});
JS;
$this->registerJS($script);
?>

<style type="text/css">
   
    .table-bordered th{
        border: 1px solid #ddd !important;
    }
</style>