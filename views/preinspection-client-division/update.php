<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */

$this->title = 'Update Preinspection Client Division: ' . ' ' . $model->divisionName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Divisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->divisionName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-client-division-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
        'region' => $region,
    ]) ?>

</div>
