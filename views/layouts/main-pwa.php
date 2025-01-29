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
    <!--<script src="https://static.opentok.com/v2/js/opentok.js"></script>-->
    <!--<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>-->
    <script src="https://static.opentok.com/v2.14/js/opentok.min.js"></script>
    <link rel="manifest" href="<?php echo Yii::$app->request->baseUrl; ?>/manifest.json">
    <script>
if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('<?php echo Yii::$app->request->baseUrl; ?>/sw.js')
           .then(function() { console.log("Service Worker Registered"); });
}
</script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" >
    <?php
    
$siteName = \Yii::$app->params['siteName'];
$footerName = \Yii::$app->params['footerName'];
$footerUrl = \Yii::$app->params['footerUrl'];
    
    
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/veyes.jpeg',["class"=>"logo-image", 'alt'=>$siteName]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    
    $menuItems = [
            ['label' => 'Access Rules', 'url' => ['/admin']],
            ['label' => 'Video Session Demo', 'url' => ['/video-requests/index']],
            ['label' => 'Task', 'url' => ['/events/index']],
            [
             'label' => 'Loan',
             'items' => [
                            ['label' => 'Add Bank', 'url' => ['/master-banks/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Create Loan', 'url' => ['/loans/index']],
                            
                     ],
            ],
            
            
            [
             'label' => 'Preinspection',
             'items' => [
                            ['label' => 'Create Request', 'url' => ['/axion-preinspection/create-request']],
                            '<li class="divider"></li>',
                            ['label' => 'My Cases', 'url' => ['/axion-preinspection/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Inspect/QC', 'url' => ['/axion-preinspection/completed']],
                            '<li class="divider"></li>',
                     ],
            ],
            [
             'label' => 'Field Executives',
             'items' => [
                            ['label' => 'Tasks', 'url' => ['/fieldexecutives-tasks/index']],
                            '<li class="divider"></li>',
                            //['label' => 'Appointments', 'url' => ['/master-fieldexecutives/appointment'], 'visible' => !Yii::$app->user->isGuest],
                            //'<li class="divider"></li>',
                     ],
            ],
            [
             'label' => 'Masters',
             'items' => [
                            //['label' => 'Field Executives Appointments', 'url' => ['/master-fieldexecutives/appointment'], 'visible' => !Yii::$app->user->isGuest],
                            '<li class="divider"></li>',
                            ['label' => 'Update Field Executives', 'url' => ['/master-fieldexecutives/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Update Location Data', 'url' => ['/master-location/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Update Towns ', 'url' => ['/master-town/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Update Cities', 'url' => ['/master-city/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Client Master Data', 'url' => ['/preinspection-client-caller/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Add Branch', 'url' => ['/preinspection-client-branch/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Add Division', 'url' => ['/preinspection-client-division/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Add Company', 'url' => ['/preinspection-client-company/index']],
                            '<li class="divider"></li>',
                     ],
            ],
            [
             'label' => 'Users',
             'items' => [
                            ['label' => 'Admin List', 'url' => ['/user-data/admin']],
                            '<li class="divider"></li>',
                            ['label' => 'BO User List', 'url' => ['/user-data/bouser']],
                            '<li class="divider"></li>',
                            ['label' => 'Surveyor List', 'url' => ['/user-data/surveyor']],
                            '<li class="divider"></li>',
                            ['label' => 'Branch Head User List', 'url' => ['/user-data/bheaduser']],
                            '<li class="divider"></li>',
                            ['label' => 'Branch Executive User List', 'url' => ['/user-data/bexecutiveuser']],
                            '<li class="divider"></li>',
                            //['label' => 'Appointments', 'url' => ['/master-fieldexecutives/appointment'], 'visible' => !Yii::$app->user->isGuest],
                            //'<li class="divider"></li>',
                     ],
            ],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->firstName . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
];

$menuItems = Helper::filter($menuItems);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);

  

    NavBar::end();
    ?>

    <div class="container"  style="width:99%;" >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container"  style="width:99%;">
        <p class="pull-left">&copy; <a href="<?php echo $footerUrl; ?>"><?php echo $footerName; ?> </a> <?= date('Y') ?></p>

        <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
