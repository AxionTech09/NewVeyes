<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientBranch */

$this->title = 'Update Preinspection Client Branch: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->branchName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-client-branch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company' => $company,
        'division' => $division,
    ]) ?>

</div>
