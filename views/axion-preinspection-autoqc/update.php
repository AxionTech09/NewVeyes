<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Update Axion Preinspection: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
		'valuator' => $valuator,
                'lastStatus' => $lastStatus,
                'block' => $block,
                'sameId' => $sameId,
                'city' => $city,
                'state'=>$state,
                'town' => $town,
                'state' => $state,  
                'callerModel' => $callerModel,
                'company' => $company,
                'division' => $division,
                'branch' => $branch,
                'caller' => $caller,
                'umodel' => $umodel,
                'role' => $role,
                'surveyor_list' => $surveyor_list,
    ]) ?>

</div>
