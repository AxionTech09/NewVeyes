<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PreinspectionClientDivision */

$this->title = $model->regionName;
$this->params['breadcrumbs'][] = ['label' => 'Preinspection Client Region', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-client-region-view">

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
            'regionName',
            'regionCode',
           // 'companyId',
            [
                    'label' => 'Company',
                    'value' => isset($model->divisionCompany->companyName) ? $model->divisionCompany->companyName : '',
            ],
        ],
    ]) ?>

</div>
