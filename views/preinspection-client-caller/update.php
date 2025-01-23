<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCaller */

$this->title = 'Update Client: ' . ' ' . $model->callerName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->callerName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-client-caller-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
        'division' => $division,
        'branch' => $branch,
    ]) ?>

</div>
