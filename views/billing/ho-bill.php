<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use yii\widgets\Pjax;
use app\models\PreinspectionClientBranch;
use app\models\PreinspectionClientDivision;
use app\models\PreinspectionClientCompany;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AxionSpotsurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;

$gridColumns = [
[
    'attribute'=>'hoBillNumber',
    'label' => 'HO Bill Number',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'], 
    'filter'=>false,
],   
[
    'attribute'=>'billNumber',
    'label' => 'Bill Number',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'], 
    'value'=>'bill.billNumber',
    'filter'=>false,
],    
[
    'attribute'=>'companyId',
    'label' => 'Insurer Name',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => 'company.companyName',
    'filter'=>false,
],
[
    'attribute'=>'stateId',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value'=> 'state.state',
    'filter'=>false,
],
[
    'attribute'=>'branchId',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value'=> 'branch.branchName',
     'filter'=>false,
],
[
    'attribute'=>'billAmount',
    'label' => 'Bill Amount',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'filter'=>false,
    'value' => function($model){
        return Yii::$app->api->showDecimal($model->billAmount);
    },
],  
[
    'attribute'=>'totalGst',
    'label' => 'Total GST',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'filter'=>false,
    'value' => function($model){
        return Yii::$app->api->showDecimal($model->totalGst);
    },
],
[
    'attribute'=>'totalAmount',
    'label' => 'Total Amount',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'filter'=>false,
     'value' => function($model){
        return Yii::$app->api->showDecimal($model->totalAmount);
    },
],
[
    'attribute'=>'generatedDate',
    'label' => 'Month/Year',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        $date = date('M-y',strtotime($model->billPeriodFrom));
        return $date;
    },
    'filter'=>false,
],
[
    'attribute'=>'billStatus',
    'label' => 'HO Bill Status',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'filter'=>false,
],
[
    'attribute'=>'generatedBy',
    'label' => 'Gernerated By',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => 'user.firstName',
    'filter'=>false,
],
[
    'attribute'=>'hoGeneratedOn',
    'label' => 'Gernerated Date',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'value' => function($model){
        return date('d-m-Y',strtotime($model->generatedDate));
    },
    'filter'=>false,
],
[
'class'=>'kartik\grid\ActionColumn',
    'template' => Helper::filterActionColumn('{downloadPdf}{downloadMis}{remarks}'),
    'headerOptions'=>['style'=>'border: 2px #fff solid; background-color:#480155;color:#fff;'],
      'buttons' => [ 
        'downloadPdf' => function ($url, $model, $key) {
            return Html::a(FA::icon('file-pdf', ['class' => 'mr-5 mt-5 text-danger']),['ho-bill-list'], [
                    'class' => 'downloadPdf',
                    'target' => '_blank',
                    'title' => Yii::t('yii', 'View/Download PDF'),  
                    'data-id'=>$model->id                     
                ]);
        },
        'downloadMis' => function ($url, $model, $key) {
            return Html::a(FA::icon('file-excel', ['class' => 'mr-5 mt-5 text-success']),['ho-bill-list'], [
                    'class' => 'downloadMis',
                    'target' => '_blank',
                    'title' => Yii::t('yii', 'Download MIS'),  
                    'data-id'=>$model->id                      
                ]);
        },
        'remarks' => function ($url, $model, $key) {
            return Html::a(FA::icon('comment', ['class' => 'mr-5 mt-5 text-primary']),'#', [
                        'class' => 'comment-link',
                        'title' => Yii::t('yii', 'Remarks'),
                        'data-toggle' => 'modal',
                        'data-target' => '#comment-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',

                    ]);
        },
    ],
],
];

$models = $dataProvider->getModels();
$ids = [];
foreach ($models as $model) {
    $ids[] = $model->id;
}

Pjax::begin();

$perPage =  \nterms\pagesize\PageSize::widget(
[   
    'template' => '{list}',
    'defaultPageSize' => 50,
    'sizes' => [10=>10,20=>20,50=>50,100=>100,200=>200,500=>500],
    'options' => ['class'=>'perPage']
] 
);

echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'filterSelector' => 'select[name="per-page"]',
    'columns'=>$gridColumns,
    'layout' => "\n{items}",
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'rowOptions'=>['style'=>'border: 2px #000 solid'],    
        'containerOptions'=>['style'=>'overflow: auto; font-size:12px;'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar'=> [

        [ 'content'=>   
       // Html::a(FA::icon('redo'), [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Refresh Grid')])
      $perPage
    ],
],
        // set export properties
'export'=>[
    'fontAwesome'=>true,
    'showConfirmAlert'=>false,
    'target'=>GridView::TARGET_BLANK,
    'label'=>'Export',
    'header'=>'<li role="presentation" class="dropdown-header">Axion Preinspection Fresh Records</li>',
],
        // parameters from the demo form
'bordered'=>false,
'striped'=>false,
'condensed'=>false,
'responsive'=>true,
'responsiveWrap'=>false,
'hover'=>true,
'showPageSummary'=>true,
'floatOverflowContainer' => false,
'floatHeader' => false,
'floatHeaderOptions' => ['top' => '50px'],
'panel'=>[
    'type'=>GridView::TYPE_PRIMARY,
    'headingOptions' => ['class'=>'panel-heading grid-panel-heading pt-10 pb-10 mb-15'],
    'footerOptions' => ['class'=>'panel-footer grid-panel-footer'],
],
'resizableColumns'=>false,
'persistResize'=>false,
'exportConfig'=>  [
]
]);

Pjax::end(); 
?>
<style type="text/css">
    .btn-toolbar .dropdown{
        width: auto !important;
    }
    .perPage{
        height: 33px;
        margin: 0px 3px 0px 1px;
        padding: 5px 15px;
    }
    
</style>

<?php
$pdfurl = Yii::$app->request->baseUrl."/billing/download-ho-pdf";
$updateUrl = Yii::$app->request->baseUrl."/billing/bill-update";
$commentUrl = Yii::$app->request->baseUrl."/billing/ho-remarks";
$misUrl = Yii::$app->request->baseUrl."/billing/download-ho-mis";

$this->registerJs(
        "
    $('body').on('click', '.downloadPdf', function() {
        var id = $(this).attr('data-id');
        var url = '$pdfurl'+'?id='+id;
        window.open(
          url,
          '_blank'
        );
    });

     $('body').on('click', '.downloadMis', function() {
        var id = $(this).attr('data-id');
        var url = '$misUrl'+'?id='+id;
        window.open(
          url,
          '_blank'
        );
    });

    $('body').on('click', '.update-link', function() {
        $.get(
            '".$updateUrl."',
            {
                id: $(this).data('id')
            },
            function (data) {
                $('#update-modal').find('.modal-body').html(data);
                $('#update-modal').modal();
            }
        );
    });

$('#update-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
});

 $('body').on('click', '.comment-link', function() {
        $.get(
            '".$commentUrl."',
            {
                id: $(this).data('id')
            },
            function (data) {
                $('#comment-modal').find('.modal-body').html(data);
                $('#comment-modal').find('.modal-body #ho').val('ho');
                $('#comment-modal').modal();
                $('#remarks-form').trigger('reset');
            }
        );
    });

    $('#comment-modal').on('hidden.bs.modal', function (e) {
        //$(this).find('.modal-body').html('');
    });

        "
    );
?>

<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'comment-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Remarks</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>