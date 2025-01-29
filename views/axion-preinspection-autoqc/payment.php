<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Please complete the payment process to download the INSPECTION Report';

$csrfToken = Yii::$app->request->csrfToken;

?>
<div style="text-align: center" class="mt-80">
    <h3 style="text-align: center; color : #06612a"><?= Html::encode($this->title) ?></h3>
    <br><br>
    <h3>
        Amount : RS <b>
                <?php
                $amountInPaisa = $amount; 
                $amountInRupees = $amountInPaisa / 100;
                
                echo number_format($amountInRupees, 2).' /-';
                ?></b>
    </h3>
    <br><br>
    <form action="<?=  Url::to(['axion-preinspection-autoqc/callback']) ?>" method="POST">
        <input type="hidden" name="_csrf" value="<?= $csrfToken ?>">
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="<?= Html::encode($apiKey) ?>"
            data-amount="<?= Html::encode($amount) ?>"
            data-currency="<?= Html::encode($currency) ?>"
            data-order_id="<?= Html::encode($razorpayOrderId) ?>"
            data-buttontext="Pay Now"
            data-name="Axion Technical Services PVT LTD"
            data-description="INSPECTION Payment"
            data-image="https://www.axionpcs.in/assets/images/logo/axion-logo.png"
            data-prefill.name=""
            data-prefill.email=""
            data-prefill.contact=""
            data-theme.color="#06612a">
        </script>
        <style>
            .razorpay-payment-button {
                background-color: #06612a;
                color: white;
                border: none;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
            }
            .razorpay-payment-button:hover {
                background-color: #04471d;
            }
        </style>
        <input type="hidden" name="order_id" value="<?= Html::encode($razorpayOrderId) ?>">
    </form>
</div>


<script>
    var options = {
        "key": "<?= Html::encode($apiKey) ?>",
        "amount": "<?= Html::encode($amount) ?>",
        "currency": "<?= Html::encode($currency) ?>",
        "order_id": "<?= Html::encode($razorpayOrderId) ?>",
        "handler": function (response) {
            // Payment was successful, redirect to the next page with the payment status
            document.getElementById('payment_status').value = "success";
            "./payment?id=" + id
            window.location.href = "./vehicleqc?id=<?= $premodel->id ?>&+page=completed&status=success";
        },
        "modal": {
            "ondismiss": function () {
                // Payment failed or was dismissed
                window.location.href = "./vehicleqc?id=<?= $premodel->id ?>&+page=completed&status=failed";
            }
        }
    };
    var rzp = new Razorpay(options);

    document.getElementById('razorpay-form').onsubmit = function (e) {
        e.preventDefault();
        rzp.open();
    };
</script>