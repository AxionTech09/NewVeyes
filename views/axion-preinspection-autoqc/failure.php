<?php
use yii\helpers\Html;

$this->title = 'Payment Failure';
?>

<h1><?= Html::encode($this->title) ?></h1>
<p>Payment failed! Error: <?= Html::encode($error) ?></p>
