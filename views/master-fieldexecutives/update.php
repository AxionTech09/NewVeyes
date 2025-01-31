<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterFieldexecutives */

$this->title = 'Update Field Executives: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Fieldexecutives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-fieldexecutives-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
