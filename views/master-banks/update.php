<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterBanks */

$this->title = 'Update Master Banks: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-banks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
