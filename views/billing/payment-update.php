<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
$totalRecived = ($billSummary->billAmount - (($billSummary->billAmount * 10) / 100)) + ($billSummary->totalGst);
?>
<div id="payment_update" class="preinspection-box">
    <?php $form = ActiveForm::begin(['id' => "paymentUpdate"]); ?>
    <div class="panel-body">
        <div class="col-sm-4"> 
            <span><b>Invoice No: <?=$billSummary->billNumber?></b></span> 
        </div>
        <div class="col-sm-4">
            <span><b>Sub Total: <?=sprintf("%.2f", $billSummary->billAmount)?></b></span>
        </div>
        <div class="col-sm-4">
            <span><b>GST: <?=sprintf("%.2f", $billSummary->totalGst)?></b></span>
        </div>
        <div class="col-sm-4"> 
            <span><b>Total: <?=sprintf("%.2f", $billSummary->totalAmount)?></b></span> 
        </div>
        <div class="col-sm-8"> 
            <span><b>Total Receivable Amount: <?=sprintf("%.2f", $billSummary->totalAmount)?></b></span> 
            <?= $form->field($billSummary, 'total_amount_receivable')->textInput(['class' => 'form-control', 'type' => 'hidden', 'value' => sprintf("%.2f", $billSummary->totalAmount)])->label(false) ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6"> 
            <?= $form->field($billSummary, 'received_amount')->textInput(['class' => 'amount received_amount form-control','value' => '']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($billSummary, 'received_gst_amount')->textInput(['class' => 'amount gst_amount form-control','value' => '']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($billSummary, 'received_tds_amount')->textInput(['class' => 'amount tds_amount form-control','value' => '']) ?>
        </div>
        <div class="col-sm-6"> 
            <?= $form->field($billSummary, 'received_short_amount')->textInput(['class' => 'amount short_amount form-control', 'value' => '']) ?>
        </div>           
        <div class="col-sm-6"> 
            <?= $form->field($billSummary, 'received_payment_details')->textInput(['class' => 'payment_details form-control']) ?>
        </div>        
        <div class="col-sm-6"> 
            <?= $form->field($billSummary, 'payment_received_on')->widget(DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,  'options' => [
                'pluginOptions' => [
                    'autoclose' => true
                ]
                ]
            ]) ?>
        </div>
        <div class="col-sm-6"> 
            <div id="total-received" class="text-danger"><b>Total Received: <span>0.00</span></b></div>
        </div>
    <?php ActiveForm::end(); ?>           
    </div> <!-- Panel Body End Here -->
</div> 
<?php
$script = <<< JS
$('#paymentUpdate').on('beforeSubmit', function(e) 
{
    var form = $(this);

    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        // beforeSend: function() {
        //     $("#loading-image").show();
        // },
        success: function (data) {
                if(data != '')
                {
                    var res = $.parseJSON(data);
                    if(res.status == 'success'){
                        $('#payment-update-modal').modal('hide');
                        $('#payment-update-modal').find('.modal-body').html('');
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
// 
$('input').on('change',function(){
    if(!$(this).hasClass('payment_details') && !$(this).hasClass('payment_received_on')){
    $(this).val($(this).val().replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1'));   
    }
    if(!$(this).hasClass('payment_details') && !$(this).hasClass('payment_received_on')){   
        inputval = $(this).val();
        if(inputval.split('.').length > 1){          
            $(this).val(inputval);
        }
        else{
            if(inputval == ''){
                $(this).val('');
            }else{
                inputval = $(this).val();
                $(this).val(inputval+'.00');
            }
        }
    }
    if($(this).hasClass('amount')){
        updateSumamount();
    }
});
function updateSumamount(){
console.log('updateSumamount');
amount = 0.00;
$('input.amount').each(function(){
    // $(this).val(parseFloat($(this).val()).toFixed(2));
    console.log($(this).val());
    tempAmt = $(this).val() != '' ? parseFloat($(this).val()).toFixed(2) : '0.00';
    amount = parseFloat(amount) + parseFloat(tempAmt);
});
var total_amount_received = $('#axionpreinspectionbilling-total_amount_receivable').val();
if(total_amount_received == amount){
    if($('#total-received').hasClass('text-danger')){
        $('#total-received').removeClass('text-danger');
    }
    $('#total-received').addClass('text-success');
    if($('.payment-update-submit').length == 0){
        $('#payment-update-modal .modal-footer').append('<a href="javascript:;" class="btn btn-primary payment-update-submit">Update</a>');
        $('.payment-update-submit').click(function(){
            $("#paymentUpdate").submit();
        });
    }
}else{
    if($('#total-received').hasClass('text-success')){
        $('#total-received').removeClass('text-success');
    }
    $('#total-received').addClass('text-danger');
    $('.payment-update-submit').remove();
}
$('#total-received span').text(parseFloat(amount).toFixed(2));
}
JS;
$this->registerJS($script);
?>