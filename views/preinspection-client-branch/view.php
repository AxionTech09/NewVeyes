<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientBranch */

$this->title = $model->branchName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-branch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'branchName',
            [
                   'label' => 'Division',
                   'value' => isset($model->branchDivision->divisionName) ? $model->branchDivision->divisionName : '',
            ],
            [
                   'label' => 'Company',
                   'value' => isset($model->branchCompany->companyName) ? $model->branchCompany->companyName : '',
            ],
        ],
    ]) ?>

</div>
