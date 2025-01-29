<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterCity */

$this->title = 'Update State: ' . ' ' . $model->state;
$this->params['breadcrumbs'][] = ['label' => 'State', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->state, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-state-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
