<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterFieldexecutives */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Field Executives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-fieldexecutives-view">

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
            'name',
            'valuationUserId',
            'piUserId',
            'address',
            [
            'attribute'=>'dob', 
                'format' => ['date', 'php:d-m-Y'],
            ],
            'email:email',
            'mobile',
            'nominee',
            'spouseName',
            'mobile2',
            [
                   'label' => 'Base Location',
                   'value' => isset($model->locationCity->city) ? $model->locationCity->city : '',
            ],
            'basicSalary',
            'caseRate',
            'loans',
            'repaymentInstalment',
            'bankName',
            'accNumber',
            'ifsc',
            'branchName',
        ],
    ]) ?>

</div>
