<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterTown */

$this->title = 'Create Town/Survey Location';
$this->params['breadcrumbs'][] = ['label' => 'Towns/Survey Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-town-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
