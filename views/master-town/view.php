<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterTown */

$this->title = $model->town;
$this->params['breadcrumbs'][] = ['label' => 'Towns/Survey Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-town-view">

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
            'town',
            [
                    'label' => 'City/District',
                    'value' => isset($model->townCity->city) ? $model->townCity->city : '',
            ],
        ],
    ]) ?>

</div>
