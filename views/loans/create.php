<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Loans */

$this->title = 'Create Loans';
$this->params['breadcrumbs'][] = ['label' => 'Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loans-create">



    <?= $this->render('_form', [
        'model' => $model,
        'cardealers' => $cardealers,
        'role' => $role,
    ]) ?>

</div>
