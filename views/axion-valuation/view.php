<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Valuation */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Preinspections', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinspection-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'referenceNo',
            'clientName',
            'insurerDivision',
            'insurerBranch',
            'requestDateTime',
            'executiveName',
            'callerMobileNo',
            'executiveEmailId',
            'customerName',
            'customerMobile',
            'contactPersonMobileNo',
            'customerAddress',
            'registrationNo',
            'engineNo',
            'chassisNo',
            'vehicleType',
            'vehicleTypeRadio',
            'manufacturer',
            'model',
            'manufacturingYear',
            'intimationRemarks',
            'extraKm',
            'vehicleLocation',
            'surveyorName',
            'surveyorContactNo',
            'cashCollectedAmount',
            'cashToBeCollected',
            'rescheduleReason',
            'rescheduleDateTime',
            'variant',
            'cashStatus',
            'status',
            'customerAppointDateTime',
            'remarks',
            //'preinspectionType',
            //'userId',
            //'created_on',
        ],
    ]) ?>

</div>
