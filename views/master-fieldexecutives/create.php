<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterFieldexecutives */

$this->title = 'Create Field Executive';
$this->params['breadcrumbs'][] = ['label' => 'Field Executives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-fieldexecutives-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
