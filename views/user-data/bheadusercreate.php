<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Create Branch Head User';
$this->params['breadcrumbs'][] = ['label' => 'Branch Head User List', 'url' => ['bheaduser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('bheaduser_form', [
        'model' => $model,
        'city' => $city,
        'company' => $company,
    ]) ?>

</div>
