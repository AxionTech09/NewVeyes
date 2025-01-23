<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Update MIS Verification: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preinspection-update">


    <?= $this->render('_form', [
        'model' => $model		
    ]) ?>

</div>
