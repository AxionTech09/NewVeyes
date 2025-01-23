<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterLocation */

$this->title = $model->locationCity->city."-".$model->locationTown->town;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-location-view">

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
            [
                   'label' => 'City/District',
                   'value' => isset($model->locationCity->city) ? $model->locationCity->city : '',
            ],
            [
                   'label' => 'Town/Survey Location',
                   'value' => isset($model->locationTown->town) ? $model->locationTown->town : '',
            ],
            'conveyance',
            'extraKms',
        ],
    ]) ?>

</div>
