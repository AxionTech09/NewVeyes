<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterLocation */

$this->title = 'Create Location';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
