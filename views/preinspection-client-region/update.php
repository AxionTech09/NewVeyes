<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */

$this->title = 'Update Preinspection Client Region: ' . ' ' . $model->regionName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Region', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->regionName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-client-region-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
    ]) ?>

</div>
