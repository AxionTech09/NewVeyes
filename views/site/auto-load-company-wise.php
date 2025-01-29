<?php

/* @var $this yii\web\View */
/* @var $companies array */
/* @var $completedClaims array */
/* @var $ros array */
/* @var $title string */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $title . '';
?>

<h1 class="title"><?= Html::encode($this->title) ?></h1>
<div class="table-filter">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['site/auto-load-cro-table'],
        'options' => ['class' => 'filter-form'],
    ]); ?>
        <?= Html::dropDownList('month', Yii::$app->request->get('month'), [
            '' => 'Select Month',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ], ['class' => 'month-dropdown']) ?> <!-- Adding a class for styling -->

        <?= Html::dropDownList('year', Yii::$app->request->get('year'), [
            '' => 'Select Year',
            date('Y') => date('Y'),
            date('Y') - 1 => date('Y') - 1,
            date('Y') - 2 => date('Y') - 2,
            date('Y') - 3 => date('Y') - 3,
            date('Y') - 4 => date('Y') - 4,
            date('Y') - 5 => date('Y') - 5,
            date('Y') - 6 => date('Y') - 6,
            date('Y') - 7 => date('Y') - 7,
            date('Y') - 8 => date('Y') - 8,
            date('Y') - 9 => date('Y') - 9,
        ], ['class' => 'year-dropdown']) ?> <!-- Adding a class for styling -->

        <?= Html::submitButton('Filter', ['class' => 'filter-btn']) ?>
    <?php ActiveForm::end(); ?>
</div>



<?php if (count($completedClaims) > 0): ?>
    <div class="table-container"> <!-- Centering container -->
        <div class="fixed-table-grid">
            <div class="fixed-left">
                <div class=""> RO/Company </div>
                <?php foreach ($ros as $ro): ?>
                    <div class="border-top"><?= Html::encode($ro['firstName']) ?></div>
                <?php endforeach; ?>
                <div class="border-top">Total</div>
            </div>
            <div class="custom-table">
                <div class="custom-table-heading main-heading">
                <?php 
                $companyAbbreviations = [
                    'GO DIGIT GENERAL INSURANCE LIMITED' => 'GDGIC',
                    'HDFC ERGO GENERAL INSURANCE CO.LTD' => 'HEGIE',
                    'IFFCO TOKIO GENERAL INSURANCE CO. LTD' => 'ITGIC',
                    'Magma General Insurance Limited' => 'MGIC',
                    'RAHEJA QBE GENERAL INSURANCE CO.LTD' => 'RQGIC',
                    'ROYAL SUNDARAM GENERAL INSURANCE Co.Ltd' => 'RSGIC',
                    'TAGIC FLOOD CLAIMS' => 'TFC',
                    'TATA AIG GENERAL INSURANCE CO.LTD' => 'TAGIC',
                    'THE NEW INDIA ASSURANCE CO LTD' => 'NIACL',
                    'THE ORIENTAL INSURANCE CO.LTD' => 'OIC'
                ];
                foreach ($companies as $company): 
                    $abbr = isset($companyAbbreviations[$company['companyName']]) ? $companyAbbreviations[$company['companyName']] : substr($company['companyName'], 0, 5);
                ?>
                    <div class="heading" title="<?= Html::encode($company['companyName']) ?>"><?= Html::encode($abbr) ?></div>
                <?php endforeach; ?>
                    <div class="heading">Total</div>
                </div>
                <div class="custom-table-body">
                    <?php
                    $columnTotals = array_fill(0, count($companies), 0);
                    foreach ($ros as $ro): ?>
                        <?php 
                        $rowTotal = 0; // Initialize row total for the current RO
                        foreach ($companies as $index => $company): 
                            $value = isset($completedClaims[$ro['id']][$company['id']]) ? $completedClaims[$ro['id']][$company['id']] : 0;
                            $columnTotals[$index] += $value;
                            $rowTotal += $value; // Add value to row total
                        ?>
                            <div class="border-top"><?= $value ?></div>
                        <?php endforeach; ?>
                        <div class="border-top"><?= $rowTotal ?></div> <!-- Display row total -->
                    <?php endforeach; ?>
                    <?php foreach ($columnTotals as $total): ?>
                        <div class="border-top-bottom"><?= $total ?></div>
                    <?php endforeach; ?>
                    <div class="border-top-bottom"><?= array_sum($columnTotals) ?></div>
                </div>
            </div>
        </div>
    </div> <!-- End centering container -->
<?php else: ?>
    <div class="alert alert-warning" role="alert">No Data Found...!</div>
<?php endif; ?>
<style>
    .font-blod {
        font-weight: 900;
    }

    .table-container {
        display: flex;
        justify-content: center; /* Center align horizontally */
        align-items: center; /* Center align vertically */
        min-height: 100vh; /* Full height of the viewport */
    }

    .fixed-table-grid {
        display: grid;
        grid-template-columns: auto auto;
        border-radius: 15px;
        overflow: auto;
        box-shadow: 0px 0px 5px #0000003b;
        width: max-content;
        height: max-content;
        max-height: calc(100vh - 30vh);
    }

    .fixed-left div {
        font-size: 10px;
        font-weight: 600;
        padding: 0px 8px;
        text-transform: uppercase;
     
        border-right: 1px solid;
    }

    .left-heading {
        width: 190px;
        height: 300px;
    }

    .fixed-left .heading {
        padding: 3px;
    }

    @media (max-width: 560px) {
        .fixed-left div {
            text-overflow: ellipsis;
            width: 165px;
            white-space: nowrap;
            overflow: hidden;
        }
    }

    .custom-table {
        overflow-x: auto;
        max-width: 100%;
    }

    .custom-table-heading.main-heading,
    .custom-table-body {
        display: grid;
        grid-template-columns: repeat(<?= count($companies) + 1 ?>, 53px);
        text-align: center;
        white-space: nowrap;
        font-size: 12px;
    }

    .custom-table-heading.main-heading .heading {
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.1em;
        padding: 3px;
        width: 53px;
        height: 25px;
        text-orientation: mixed;
        border-right: 1px solid;
    }

    .heading {
        width: 53px;
        height: 25px;
    }

    .custom-table-heading.main-heading .heading:last-child {
        border-right-style: hidden;
    }

    .custom-table-body div {
        cursor: pointer;
    }

    .border-top {
        border-top: 1px solid;
        border-right: 1px solid;
    }

    .border-top-bottom {
        border-top: 1px solid;
        border-right: 1px solid;
    }

    .border-right {
        border-right: 1px solid;
    }

    .border-left {
        border-left: 1px solid;
    }

    .border-left-none {
        border-left-style: hidden !important;
    }

    .border-right-none {
        border-right-style: hidden !important;
    }

    .filter-form {
        display: flex;
        align-items: center;
    }

    .month-dropdown,
    .year-dropdown,
    .filter-btn {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .filter-btn {
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    .filter-btn:hover {
        background-color: #0056b3;
    }

    .custom-table-heading.main-heading .heading:hover {
        background-color: #f0f0f0;
        cursor: default;
    }
</style>
