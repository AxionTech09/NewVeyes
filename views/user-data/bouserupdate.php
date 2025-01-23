<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$this->title = 'Update RO User: ' . ' ' . $model->firstName;
$this->params['breadcrumbs'][] = ['label' => 'RO User List', 'url' => ['bouser']];
$this->params['breadcrumbs'][] = ['label' => $model->firstName, 'url' => ['view-bouser', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userdata-update">
    
    <?= $this->render('bouser_form', [
        'model' => $model,
        'city' => $city,
        'state'=>$state,        
        'rocaseassign'=>$rocaseassign,
        'companiesInfo'=>$companiesInfo,
        'rousers'=>$rousers,
    ]) ?>

</div>
