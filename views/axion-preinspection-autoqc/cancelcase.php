<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Change RO';
?>
<div class="preinspection-cancel-case">
    <?= $this->render('_cancel-case-form', ['premodel' => $premodel]) ?>
</div>
