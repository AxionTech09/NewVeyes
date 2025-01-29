<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Razorpay Payment Test';

$csrfToken = Yii::$app->request->csrfToken;

?>

<h1><?= Html::encode($this->title) ?></h1>

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
        data-description="Payment Testing"
        data-image="https://www.axionpcs.in/assets/images/logo/axion-logo.png"
        data-theme.color="#F37254">
    </script>
    <input type="hidden" name="order_id" value="<?= Html::encode($razorpayOrderId) ?>">
</form>