<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterTown */

$this->title = 'Update Town/Survey Location: ' . ' ' . $model->town;
$this->params['breadcrumbs'][] = ['label' => 'Towns/Survey Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->town, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-town-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
