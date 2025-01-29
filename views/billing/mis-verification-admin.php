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

$billPeriod = (isset($_GET['AxionPreinspectionSearch']) && isset($_GET['AxionPreinspectionSearch']['billPeriod'])) ? $_GET['AxionPreinspectionSearch']['billPeriod'] : $dateVar;
$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0] ;
$billId = isset($_GET['billId']) ? $_GET['billId'] : '';
$stateId = (isset($_GET['AxionPreinspectionBilling']) && isset($_GET['AxionPreinspectionBilling']['stateId'])) ? $_GET['AxionPreinspectionBilling']['stateId'] : '';
print_r($model);
$gridColumns = [
  [
    'attribute'=>'companyId',
    'label' => 'Insurance Company Name',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
      if ($model->billStatus == 'Verified' ){
        return ['style'=>'background-color: #FBDBDF;'];
      }
      else {
        return [];
      }
    },
    'value'=>function ($model) {
      $insurerName = $model->callerCompany;
      if(isset($insurerName->companyName))
      {
        return  $insurerName->companyName;
      }
      else { return '';}
    },
    'filter'=>false,
  ],
  [
      'attribute'=>'stateId',
      'vAlign'=>'middle',
      'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
      'contentOptions' => ['style' => 'border: 1px solid black;'],
      'contentOptions' => function ($model) {
        if($model->billStatus == 'Verified' ){
          return ['style'=>'background-color: #FBDBDF;'];
        }
        else {
          return [];
        }
      },
      'value'=> function ($model) use ($stateId){
        $state = $model->state->state;
        $stateName="";
        if($model->state){
          $stateName = $model->state->state;
        } 
        else {
          if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
            $stateName="ALL";          
          }
        }
        return $stateName;
      },
      'filter'=>false,
  ],
  [
      'attribute'=>'branchId',
      'vAlign'=>'middle',
      'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
      'contentOptions' => ['style' => 'border: 1px solid black;'],
      'contentOptions' => function ($model){
        if($model->billStatus == 'Verified' ){
          return ['style'=>'background-color: #FBDBDF;'];
        }
        else {
          return [];
        }
      },
      'value'=> function ($model) use ($stateId){
          $branchName="";
          if($model->branchId){
            $branchName = $model->branch->branchName;
          }else{
          if($model->billType !='State Bill' && $model->billType !='Branch Bill' && $model->parentId==""){
              $branchName="ALL";          
            }
          }
          return $branchName;
      },
      'filter'=>false,
  ],
  [
    'attribute'=>'sbuHeadId',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
      if($model->billStatus == 'Verified' ){
        return ['style'=>'background-color: #FBDBDF;'];
      }
      else {
        return [];
      }
    },
    'value' => function ($model) {
      $sbuHead = $model->sbuHead;
      if ($sbuHead)
      {
        return $sbuHead->name;
      }
      else
      {
        return '';
      }
    },
    'filter'=>false,
],
  [
      'attribute'=>'billDetaiils',
      'label' => 'Total No of 2W Cases',
      'vAlign'=>'middle',
      'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;width: 6%;white-space: normal;'],
      'contentOptions' => ['style' => 'border: 1px solid black;'],
      'contentOptions' => function ($model){
            if($model->billStatus == 'Verified' ){
                return ['style'=>'background-color: #FBDBDF;'];
            }else{
              return [];
            }
          },
      'value'=> function ($model) use ($stateId){
          if($stateId){
            $res = $model->getTotal($model->id, $model->companyId,$stateId);
            return $res->total2W;
          }else{
            $res = json_decode($model->billDetails);
            return $res->total2W ? $res->total2W : '';
          }
      },
  'filter'=>false,
  ],
  [
    'attribute'=>'billDetaiils',
    'label' => 'Total No of 3W Cases',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;width: 6%;white-space: normal;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
          if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },

    'value'=> function ($model) use ($stateId){
        if($stateId){
          $res = $model->getTotal($model->id, $model->companyId,$stateId);
          return $res->total3W;
        }else{
          $res = json_decode($model->billDetails);
          return $res->total3W ? $res->total3W : '';
        }
    },

    'filter'=>false,
  ],
  [
    'attribute'=>'billDetaiils',
    'label' => 'Total No of 4W Cases',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;width: 6%;white-space: normal;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
          if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },
    'value'=> function ($model) use ($stateId){
        if($stateId){
          $res = $model->getTotal($model->id, $model->companyId,$stateId);
          return $res->total4W;
        }else{
          $res = json_decode($model->billDetails);
          return $res->total4W ? $res->total4W : '';
        }
    },
    'filter'=>false,
  ],
  [
    'attribute'=>'billDetaiils',
    'label' => 'Total No of Commercial Cases',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;width: 6%;white-space: normal;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
          if($model->billStatus == 'Verified' ){
              return ['style'=>'background-color: #FBDBDF;'];
          }else{
            return [];
          }
        },
    'value'=> function ($model) use ($stateId){
        if($stateId){
          $res = $model->getTotal($model->id, $model->companyId,$stateId);
          return $res->totalCW;
        }else{
          $res = json_decode($model->billDetails);
          return $res->totalCW ? $res->totalCW : '';
        }
    },
    'filter'=>false,
  ],
  [
    'attribute'=>'billDetaiils',
    'label' => 'Total No of Extra KM',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;width: 6%;white-space: normal;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model) {
      if($model->billStatus == 'Verified' ) {
          return ['style'=>'background-color: #FBDBDF;'];
      }else {
        return [];
      }
    },
    'value'=> function ($model) use ($stateId){
        if($stateId){
          $res = $model->getTotal($model->id, $model->companyId,$stateId);
          return $res->totalKm;
        }else{
          $res = json_decode($model->billDetails);
          return $res->totalKm ? $res->totalKm : '';
        }
    },
    'filter'=>false,
  ],
  [
    'attribute'=>'billStatus',
    'label' => 'Verification Status',
    'format'=>'raw',
    'vAlign'=>'middle',
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#480155;color:#fff;'],
    'contentOptions' => ['style' => 'border: 1px solid black;'],
    'contentOptions' => function ($model){
      if($model->billStatus == 'Verified' ){
          return ['style'=>'background-color: #FBDBDF;'];
      }else{
        return [];
      }
    },
    'value'=> function ($model){
      return ($model->billStatus == 'Verified') ? '<span class="label label-success">Verified</span>' : '<span class="label label-danger">Unverified</span>';
    },
    'filter'=>false,
  ], 
  [
  'class'=>'kartik\grid\ActionColumn',
      'template' => Helper::filterActionColumn('{mis}'),
      'headerOptions'=>['style'=>'border: 2px #fff solid; background-color:#480155;color:#fff;'],

        'buttons' => [            
          'mis' => function ($url, $model, $key) use ($stateId) {

              return Html::a('MIS',['mis-verification','billId'=>$model->id,"companyId"=>$model->companyId,"stateId"=>$stateId], [
                      'class' => 'btn btn-success',
                      'title' => Yii::t('yii', 'MIS'),                           
                  ]);
          },
      ],
  ],
  [
    'class'=>'kartik\grid\ActionColumn',
    'header' => 'Bill Generation',
    'template' => Helper::filterActionColumn('{generate-bill}'),
    'headerOptions'=>['style'=>'border: 2px #fff solid; background-color:#480155;color:#fff;'],
    'buttons' => [      
      'generate-bill' => function ($url, $model, $key) {       
        if ( $model->billStatus == 'Verified' && 
              (($model->billType != 'State Bill' && $model->billType != 'Branch Bill' && empty($model->stateId) ) || $model->billType != 'Corporate Bill') ) {
          return Html::a('Generate Bill',['bill-generate', 'id'=>$model->id], [
            'class' => 'btn btn-primary',
            'title' => Yii::t('yii', 'Generate Bill'),                           
          ]);
        }               
      },
    ],
  ],
];

  echo '<div class="col-md-12 mt-10">';
  echo $this->render('_search', ['model' => $searchModel,'role'=>$role,'billId'=>$billId]);
  echo '</div>';

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
    'sizes' => [50=>50, 100=>100, 200=>200, 500=>500, 1000=>1000, 2000=>2000, 'All'=> 'All'],
    'options' => ['class'=>'perPage']
] 
);

//echo $dataProvider->totalCount;exit;
echo GridView::widget([
  'dataProvider'=>$dataProvider,
  //'filterModel'=>$searchModel,
  'filterSelector' => 'select[name="per-page"]',
  'columns'=>$gridColumns,
  'summary'=>'', 
  'layout' => "{items}",
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
  'showPageSummary'=>false,

  'floatOverflowContainer' => false,
  'floatHeader' => false,
  'floatHeaderOptions' => ['top' => '50px'],
  'panel'=>[
    'type'=>GridView::TYPE_PRIMARY,
    'headingOptions' => ['class'=>'panel-heading grid-panel-heading pt-10 pb-10 mb-15'],
    'footerOptions' => ['class'=>'panel-footer grid-panel-footer'],
    'footer' => false,
  ],
  'resizableColumns'=>false,
  'persistResize'=>false,
  'exportConfig'=>  [
  ]
]);

Pjax::end(); 
?>

<!-- <style type="text/css">
  #w2-filters{
    display:none;
  }
</style> -->