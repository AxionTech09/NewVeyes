<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .header-logo img {
            position: absolute;
            top: 10px;
            left: 10px;
            height: auto;
            width: 10%;
            /* Adjust these values as needed */
        }
        @media (max-width: 768px) {
            .header-logo img {
                width: 25%; /* Width for screens with a max width of 768px */
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="header-logo">
        <img src="https://www.axionpcs.in/assets/images/logo/axion-logo.png" alt="Axion Logo" />
    </div>
    <div class="container">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
