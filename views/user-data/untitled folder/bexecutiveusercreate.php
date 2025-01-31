<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Create Branch Executive User';
$this->params['breadcrumbs'][] = ['label' => 'Branch Executive User List', 'url' => ['bexecutiveuser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('bexecutiveuser_form', [
        'model' => $model,
    ]) ?>

</div>
