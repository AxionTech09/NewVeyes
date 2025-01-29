<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientCaller */

$this->title = $model->callerName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-caller-view">

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
            'callerName',
            [
                   'label' => 'Branch',
                   'value' => isset($model->callerBranch->branchName) ? $model->callerBranch->branchName : '',
            ],
            [
                   'label' => 'Division',
                   'value' => isset($model->callerDivision->divisionName) ? $model->callerDivision->divisionName : '',
            ],
            [
                   'label' => 'Company',
                   'value' => isset($model->callerCompany->companyName) ? $model->callerCompany->companyName : '',
            ],
            'callerDesignation',
            'callerMobileNo',
            'callerEmailId:email',
            'callerAdditionInfo',
            'supervisorName',
            'supervisorDesignation',
        ],
    ]) ?>

</div>
