<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Claimsurvey */

$this->title = 'Create Axion Spotsurvey';
$this->params['breadcrumbs'][] = ['label' => 'Axion Claimsurvey', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-create">
 
 <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
        'lastStatus' => $lastStatus,
        'block' => $block,
        'sameId' => $sameId,
        'callerModel' => $callerModel,
        'company' => $company,
        'umodel' => $umodel,
        'role' => $role,
        'division' => $division,
        'branch' => $branch,
        'caller' => $caller,
        'cmodel' => $cmodel,
        'vmodel' => $vmodel,
        'exmodel' => $exmodel,
        'assests' => $assests,
   

    ]) ?>

</div>
