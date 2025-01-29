<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use mdm\admin\components\Helper;
use yii\bootstrap\Dropdown;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAR;
use rmrevin\yii\fontawesome\FAS;
//use cakebake\bootstrap\select\BootstrapSelectAsset;


AppAsset::register($this);
//BootstrapSelectAsset::register($this);
if(!Yii::$app->user->getId())
{
    $role="Customer";
    $userEmail="guest@123.com";
    $userFirstName="Customer";
}
else
{
    $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
    $userEmail=Yii::$app->user->identity->email;
    $userFirstName=Yii::$app->user->identity->firstName;
    $userCreateAccess=Yii::$app->user->identity->create_access;
    $userQcAccess=Yii::$app->user->identity->qc_access;
}



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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    
    $siteName = \Yii::$app->params['siteName'];
    $footerName = \Yii::$app->params['footerName'];
    $footerUrl = \Yii::$app->params['footerUrl'];

    if (Yii::$app->user->isGuest)
        echo '<aside id="side-menu" class="pull-left collapsed-side-menu">';
    else
        echo '<aside id="side-menu" class="pull-left">';
  
    NavBar::begin([
        //'brandLabel' => Html::img('@web/images/veyes.jpeg',["class"=>"logo-image", 'alt'=>$siteName]),
        //'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => ($userEmail != 'guest@123.com')?'navbar-inverse':'navbar-inverse guest-navbar',
        ],
    ]);
    
    
    $menuItems = [
        // [
        //     'label' => FAS::icon('tachometer-alt', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Dashboard</span>', 
        //     'options' => ['class' =>  (Yii::$app->controller->id == 'site' &&  Yii::$app->controller->action->id == 'index') ? 'active' : ''],
        //     'url' => ['/']
        // ],
        [
            'label' => FA::icon('tachometer-alt', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Dashboard</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'error') ? 'active' : ''], 'visible' => ($role != 'Branch Head'),
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#dashboard-list'],
            'dropDownOptions' => ['id' => 'dashboard-list', 'class' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'error') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white agingwise']).'Age Wise', 'url' => 'javascript:;','options' => ['id' =>  'agingwise', 'class' => (Yii::$app->session->get('dashboard-menu') != 'targetreport') && (Yii::$app->controller->id == 'site') ? 'active' : '']],
                '<li  class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white targetreport']).'Target Report', 'url' => 'javascript:;','options' => ['id' =>  'targetreport', 'class' => (Yii::$app->session->get('dashboard-menu') == 'targetreport') && (Yii::$app->controller->id == 'site') ? 'active' : '']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'RO & Company Wise Report', 'url' => ['/site/auto-load-cro-table'] ],
                '<li class="divider"></li>',
                // ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Scheduled Cases', 'url' => ['/axion-preinspection/scheduled']],
                // '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id != 'error') ? 'active' : ''],
            ],
        ],
        [
            'label' => FA::icon('gavel', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Access Rules</span>', 
            'options' => ['class' => (preg_match("/admin/i", Yii::$app->controller->route) !== 0) ? 'active' : ''],
            'url' => ['/admin']
        ],
    /*    [
            'label' => 'Loan',
            'items' => [
                        ['label' => 'Master Bank', 'url' => ['/master-banks/index']],
                        '<li class="divider"></li>',
                        ['label' => 'Create Loan Request', 'url' => ['/loans/index']],
                        
                    ],
        ], 
        */  
        [
            'label' => FA::icon('search', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Preinspection</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'axion-preinspection') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#preinspection-list'],
            'dropDownOptions' => ['id' => 'preinspection-list', 'class' => (Yii::$app->controller->id == 'axion-preinspection') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']) . 'Create Request', 'url' => ['/axion-preinspection/create-request'], 'visible' => $role == 'Superadmin' || $userCreateAccess == 'Y' || Yii::$app->user->getId() == 10180],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Fresh Cases', 'url' => ['/axion-preinspection/fresh'], 'visible' => $role == 'Superadmin' || $userQcAccess == 'Y'],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Scheduled Cases', 'url' => ['/axion-preinspection/scheduled'], 'visible' => $role == 'Superadmin' || $userQcAccess == 'Y'],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Inspect/QC', 'url' => ['/axion-preinspection/completed'], 'visible' => $role == 'Superadmin' || $userQcAccess == 'Y'],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Completed Case', 'url' => ['/axion-preinspection/completed-case'], 'visible' => $role == 'Superadmin' || $userQcAccess == 'Y'],
                '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'axion-preinspection') ? 'active' : ''],
            ],
        ],
        // UIIC AUTO QC MENU START
        [
            'label' => FA::icon('search', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Pi Auto QC Screen</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'axion-preinspection-autoqc') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#Autoqc-list'],
            'dropDownOptions' => ['id' => 'Autoqc-list', 'class' => (Yii::$app->controller->id == 'axion-preinspection-autoqc') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Create Request', 'url' => ['/axion-preinspection-autoqc/create-request']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Quick Create Request', 'url' => ['/axion-preinspection-autoqc/uiic-quick-create-request']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Fresh Cases', 'url' => ['/axion-preinspection-autoqc/fresh']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Scheduled Cases', 'url' => ['/axion-preinspection-autoqc/scheduled']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Inspect/QC', 'url' => ['/axion-preinspection-autoqc/completed']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Completed Case', 'url' => ['/axion-preinspection-autoqc/completed-case']],
                '<li class="divider"></li>',
                // ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'PI Auto QC Screen', 'url' => ['/axion-preinspection-autoqc/qc-screen']],
                // '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'axion-preinspection') ? 'active' : ''],
            ],
        ],
        // UIIC AUTO QC MENU END
        [
            'label' => FA::icon('book', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Claims Survey</span>',
            'visible' => ($userEmail != 'guest@123.com' && $role != 'Surveyor'),
            'options' => ['class' => (Yii::$app->controller->id == 'axion-claimsurvey') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#claims-survey-list'],
            'dropDownOptions' => ['id' => 'claims-survey-list', 'class' => (Yii::$app->controller->id == 'axion-claimsurvey') ? 'collapse in' : ''],
            'items' => [  
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Create Request', 'url' => ['/axion-claimsurvey/create-request']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'My Cases','url' => ['/axion-claimsurvey/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Assessment', 'url' => ['/axion-claimsurvey/completed']],
                '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'axion-claimsurvey') ? 'active' : ''],
            ],
        ],

        [
            'label' => FA::icon('balance-scale', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Valuation</span>',
            'visible' => ($userEmail != 'guest@123.com' && $role != 'Branch Executive' && $role != 'Veyes UAT' && $role != 'Branch Head'),
            'options' => ['class' => (Yii::$app->controller->id == 'axion-valuation') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#valuation-list'],
            'dropDownOptions' => ['id' => 'valuation-list', 'class' => (Yii::$app->controller->id == 'axion-valuation') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Create Request', 'url' => ['/axion-valuation/create-request']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'My Cases', 'url' => ['/axion-valuation/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Inspect/QC', 'url' => ['/axion-valuation/completed']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Completed Case', 'url' => ['/axion-valuation/completed-case']],
                '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'axion-valuation') ? 'active' : ''],
            ],
        ],
        [
            'label' => FAS::icon('user-tie', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Field Executives</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'fieldexecutives-tasks') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#field-executives-list'],
            'dropDownOptions' => ['id' => 'field-executives-list', 'class' => (Yii::$app->controller->id == 'fieldexecutives-tasks') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Tasks', 'url' => ['/fieldexecutives-tasks/index']],
                '<li class="divider"></li>',
                //['label' => 'Appointments', 'url' => ['/master-fieldexecutives/appointment'], 'visible' => !Yii::$app->user->isGuest],
                //'<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'fieldexecutives-tasks') ? 'active' : ''],
            ],
        ],
        
        [
            'label' => FA::icon('folder-open', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Masters</span>',
            'options' => ['class' => (preg_match("/master-|preinspection-client-/i", Yii::$app->controller->id)) ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#masters-list'],
            'dropDownOptions' => ['id' => 'masters-list', 'class' => (preg_match("/master-|preinspection-client-/i", Yii::$app->controller->id)) ? 'collapse in' : ''],
            'items' => [
                //['label' => 'Field Executives Appointments', 'url' => ['/master-fieldexecutives/appointment'], 'visible' => !Yii::$app->user->isGuest],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Update Field Executives', 'url' => ['/master-fieldexecutives/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Update Location Data', 'url' => ['/master-location/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Update State', 'url' => ['/master-state/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Update Towns ', 'url' => ['/master-town/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Update Cities', 'url' => ['/master-city/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Client Master Data', 'url' => ['/preinspection-client-caller/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Add Branch', 'url' => ['/preinspection-client-branch/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Add Division', 'url' => ['/preinspection-client-division/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Add Company', 'url' => ['/preinspection-client-company/index']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Add Region', 'url' => ['/preinspection-client-region/index']],
                '<li class="divider"></li>',
                'options' => ['class' => (preg_match("/master-|preinspection-client-/i", Yii::$app->controller->id)) ? 'active' : ''],
            ],
        ],
        [
            'label' => FA::icon('users', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Users</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'user-data') ? 'active' : ''],
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#users-list'],
            'dropDownOptions' => ['id' => 'users-list', 'class' => (Yii::$app->controller->id == 'user-data') ? 'collapse in' : ''],
            'items' => [
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Admin List', 'url' => ['/user-data/admin'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'RO User List', 'url' => ['/user-data/bouser'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Surveyor List', 'url' => ['/user-data/surveyor'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Branch Head User List', 'url' => ['/user-data/bheaduser'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Branch Executive User List', 'url' => ['/user-data/bexecutiveuser'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Associate Dealers List', 'url' => ['/user-data/cardealers'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                ['label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Executive', 'url' => ['/user-data/commonuser'], 'options' => ['class' => 'submenu']],
                '<li class="divider"></li>',
                'options' => ['class' => (Yii::$app->controller->id == 'user-data') ? 'active' : ''],
            ],
        ],
        [
            'label' => FA::icon('file-invoice', ['class' => 'nav-icon text-white']).'<span class="side-menu-label">Billing</span>',
            'options' => ['class' => (Yii::$app->controller->id == 'billiing') ? 'active' : ''],
            'visible' => ($role == 'BO User' || $role == 'Superadmin'),
            'linkOptions' => ['data-toggle' => 'collapse', 'data-target' => '#billing-list'],
            'dropDownOptions' => ['id' => 'billing-list', 'class' => (Yii::$app->controller->id == 'billing') ? 'collapse in' : ''],
            'items' => [ 
                    
                [
                    'label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Billing MIS Verification', 
                    'url' => ['/billing/mis-verification-admin'],
                     'visible' => ($role == 'Superadmin'),
                    'options' => ['class' => 'submenu']
                ],
                [
                    'label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Billing MIS Verification', 
                    'url' => ['/billing/mis-verification'],
                     'visible' => ($role == 'BO User'),
                    'options' => ['class' => 'submenu']
                ],
                '<li class="divider"></li>',      
                [
                    'label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'Billing Summary', 
                    'url' => ['/billing/summary'],
                    'visible' => ($role == 'BO User' || $role == 'Superadmin'),
                    'options' => ['class' => 'submenu']
                ],
                '<li class="divider"></li>',      
                [
                    'label' => FA::icon('check-circle', ['class' => 'nav-icon text-white']).'HO Bill List', 
                    'url' => ['/billing/ho-bill-list'],
                    'visible' => ($role == 'BO User' || $role == 'Superadmin'),
                    'options' => ['class' => 'submenu']
                ],
            ],
        ],
    ];

    $menuItems = Helper::filter($menuItems);

    echo Nav::widget([
        'options' => ['class' => 'nav'],
        'items' => $menuItems,
        'activateItems'=>true,
        'encodeLabels' => false
    ]);

    NavBar::end();
    echo '</aside>'; 
    ?>

    <div id="top-menu">
        <?php if (!Yii::$app->user->isGuest) { ?> 
            <div class="top-menu navbar-stack-icon">
                <?=FA::icon('bars', ['class' => 'nav-icon text-white'])?>
            </div>
        <?php } ?>
        <div class="top-menu logo">
            <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('/')?>"><?=Html::img('@web/images/veyes.jpeg',["class"=>"logo-image", 'alt'=>$siteName])?></a>
        </div>        
        <div class="top-menu account">
            <?php if (Yii::$app->user->isGuest && !(Yii::$app->controller->id == 'axion-preinspection' && Yii::$app->controller->action->id == 'vehicleqc')) { 
                echo Html::a('Login', '/site/login', ['class' => 'btn btn-primary login-btn']);
            } 
            else if (!(Yii::$app->controller->id == 'axion-preinspection' && Yii::$app->controller->action->id == 'vehicleqc')) {
                
                echo '<div class="dropdown">';
                echo '<a href="#" data-toggle="dropdown" class="dropdown-toggle">' . FA::icon('user-circle', ['class' => 'top-menu-icon text-white']).Yii::$app->user->identity->firstName . ' <b class="caret"></b></a>';
    
                echo Dropdown::widget([
                    'items' => [
                        ['label' => FA::icon('edit', ['class' => 'top-menu-icon']).'Change Password', 'url' => Yii::$app->urlManager->createAbsoluteUrl('site/change-password'), 'visible' => ($userEmail != 'guest@123.com' && $role == 'Superadmin'), 'linkOptions' => ['id'=>'change-password',]],
                        ['label' => FA::icon('paper-plane', ['class' => 'top-menu-icon']).'Logout', 'url' => '/site/logout', 'linkOptions' => ['data-method' => 'post']],
                    ],
                    'encodeLabels' => false
                ]);
    
                echo '</div>';

            } ?>
        </div>
    </div>

    <div class="container main-container pull-right">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
    <div class="clear"></div>
</div>


<!-- Flash session data -->

<?php if (Yii::$app->session->hasFlash('Success')) { ?>
  <div class="alert alert-success alert-dismissable flash-message">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
      x</button>
    <h5 class="flash-msg"><?=FA::icon('thumbs-up')?> <?= Yii::$app->session->getFlash('Success') ?></h5>
  </div>
<?php } ?>

<?php if (Yii::$app->session->hasFlash('Failure')) { ?>
  <div class="alert alert-danger alert-dismissable flash-message">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
      x</button>
    <h5 class="flash-msg"><?=FA::icon('thumbs-down')?></i> <?= Yii::$app->session->getFlash('Failure') ?></h5>
  </div>
<?php } ?>

<footer class="footer">
    <div class="container"  style="width:99%;">
        <p>&copy; <a href="<?php echo $footerUrl; ?>"><?php echo $footerName; ?> </a> <?= date('Y') ?></p>

        <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        $('#agingwise a').click(function(){
            if(localStorage.getItem('dashboard')){
                localStorage.removeItem('dashboard');
                localStorage.setItem('dashboard', 'agingwise');
            }else{
                localStorage.setItem('dashboard', 'agingwise');
            }
            loadDashboard(localStorage.getItem('dashboard'));
        });
        $('#targetreport a').click(function(){
            if(localStorage.getItem('dashboard')){
                localStorage.removeItem('dashboard');
                localStorage.setItem('dashboard', 'targetreport');
            }else{
                localStorage.setItem('dashboard', 'targetreport');
            }
            loadDashboard(localStorage.getItem('dashboard'));
        });
        function loadDashboard(name){            
            $.ajax({
                url: '<?php echo YII::$app->request->baseUrl . '/site/load-dashboard'; ?>',
                type: 'POST',
                data: {
                    name
                },
                success: function (response){
                    localStorage.removeItem('dashboard');
                }
            });
        }
        // $(document).ready(function(){
        //     if(localStorage.getItem('dashboard')){
        //         if(localStorage.getItem('dashboard') == 'agingwise'){
        //             $('#targetreport').removeClass('active');
        //             $('#agingwise').addClass('active');
        //         }else if(localStorage.getItem('dashboard') == 'targetreport'){
        //             $('#agingwise').removeClass('active');
        //             $('#targetreport').addClass('active');
        //         }
        //     }else{
        //         $('#agingwise').removeClass('active');
        //         $('#targetreport').removeClass('active');
        //     }
        // });
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
