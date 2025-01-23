<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Create Axion Spotsurvey';
$this->params['breadcrumbs'][] = ['label' => 'Axion Preinspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-create">
 
 <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    

    <?= $this->render('_formScheduled', [
        'model' => $model,
        'city' => $city,
        'state'=>$state,
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
        'surveyor_list' => $surveyor_list,
    ]) ?>

</div>
