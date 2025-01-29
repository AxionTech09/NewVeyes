<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Create RO User';
$this->params['breadcrumbs'][] = ['label' => 'RO User List', 'url' => ['bouser']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-create">

    <h1 class="botitle"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('bouser_form', [
        'model' => $model,
        'city' => $city,
        'state'=>$state,
        'rocaseassign'=>$rocaseassign,
        'companiesInfo'=>$companiesInfo,
    ]) ?>

</div>
