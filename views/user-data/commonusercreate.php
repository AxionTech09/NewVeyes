<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Create Executive';
$this->params['breadcrumbs'][] = ['label' => 'Executive List', 'url' => ['commonuser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('commonuser_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
