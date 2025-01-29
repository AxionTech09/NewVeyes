<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Update Bill: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bill Summary', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bill-update">


    <?= $this->render('_billform', [
        'model' => $model		
    ]) ?>

</div>
