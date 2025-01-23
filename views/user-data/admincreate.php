<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Create Admin';
$this->params['breadcrumbs'][] = ['label' => 'Admin List', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('admin_form', [
        'model' => $model,
        'city' => $city,
    ]) ?>

</div>
