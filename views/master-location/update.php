<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterLocation */

$this->title = 'Update Master Location: ' . ' ' . $model->locationCity->city."-".$model->locationTown->town;
$this->params['breadcrumbs'][] = ['label' => 'Master Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->locationCity->city."-".$model->locationTown->town, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
        'town' => $town,
    ]) ?>

</div>
