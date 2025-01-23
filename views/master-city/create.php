<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterCity */

$this->title = 'Create City/District';
$this->params['breadcrumbs'][] = ['label' => 'Cities/Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-city-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
