<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Claimsurvey */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-view">
<!--
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'referenceNo',
            'insurerName',
            'insurerDivision',
            'insurerBranch',
            'intimationDate',
            'callerName',
            'callerMobileNo',
            'callerDetails',
            'insuredName',
            'insuredMobile',
            'contactPersonMobileNo',
            'insuredAddress',
            'registrationNo',
            'engineNo',
            'chassisNo',
            'vehicleType',
            'vehicleTypeRadio',
            'maleId',
            'modelId',
            'variantId',
            'manufacturingYear',
            'intimationRemarks',
            'extraKM',
            'surveyLocation',
            'surveyorName',
            'surveyorContactNo',
            'sendLink',
            'surveyorAppointDateTime',
            'rescheduleReason',
            'rescheduleDateTime',
            'inspectionType',
            'paymentMode',
            'status',
            'customerAppointDateTime',
            'remarks',
            //'preinspectionType',
            //'userId',
            //'created_on',
        ],
    ]) ?>

</div>
