<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterCity */

$this->title = 'Update City/District: ' . ' ' . $model->city;
$this->params['breadcrumbs'][] = ['label' => 'Cities/Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->city, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-city-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
