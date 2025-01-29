<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use mdm\admin\components\Helper;

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
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
    <link rel="manifest" href="<?php echo Yii::$app->request->baseUrl; ?>/manifest.json">
    <script>
if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('<?php echo Yii::$app->request->baseUrl; ?>/sw.js')
           .then(function() { console.log("Service Worker Registered"); });
}
</script>

</head>
<body class="loginview">
    <!-- <img  src="../images/car.jpg" alt="insurance"> -->
<?php $this->beginBody() ?>

<div >
    <?php
    
$siteName = \Yii::$app->params['siteName'];
$footerName = \Yii::$app->params['footerName'];
$footerUrl = \Yii::$app->params['footerUrl'];
?>
    
    
    

    <div class="container"  style="width:99%;" >
        
        <?= $content ?>
    </div>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
