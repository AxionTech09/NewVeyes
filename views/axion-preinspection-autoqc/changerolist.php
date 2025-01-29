<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\models\Preinspection */

$this->title = 'Change RO Of Axion Preinspection: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Change RO';
?>
<div class="preinspection-rolist">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?= $this->render('_roform', [

                'smodel'=>$smodel,

                'state'=>$state,

                'role' => $role,
    ]) ?>

</div>
