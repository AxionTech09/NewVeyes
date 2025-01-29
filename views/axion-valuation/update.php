<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Valuation */

$this->title = 'Update Axion valuation: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Valuation', 'url' => ['index']];
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
                'town' => $town,
                'callerModel' => $callerModel,
                'company' => $company,
                'division' => $division,
                'branch' => $branch,
                'caller' => $caller,
                'umodel' => $umodel,
                'role' => $role,
                'cmodel' => $cmodel,
                'vmodel' => $vmodel,
                'exmodel' => $exmodel,
                'exShowroomPrice' => $exShowroomPrice,
    ]) ?>

</div>
