<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use yii\widgets\Pjax;
use app\models\LoanDocs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LoansSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loans';
$this->params['breadcrumbs'][] = $this->title;

$statusArray = $searchModel->statusValue;
$ltypeArray = $searchModel->ltypeValue;
$etypeArray = $searchModel->etypeValue;



?>
<div class="loans-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
         

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'bordered'=>false,
        'striped'=>false,
        'condensed'=>false,
        'responsive'=>true,
        'responsiveWrap'=>false,
        'hover'=>true,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>'My Cases'
                 ],
        'resizableColumns'=>false,
        'persistResize'=>false,
        'exportConfig'=>  [
                          ],
        'hover' => true,
        'containerOptions'=>['style'=>'overflow: auto; font-size:12px;'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true,
        // 'showPageSummary'=>true,

        'toolbar' => [
         ['content'=>($role == 'Surveyor' || $role == 'Car Dealers' || $role == 'BO User' || $role == 'Superadmin' || $role == 'Admin')?
                Html::button('<i class="glyphicon glyphicon-plus"></i>',[
           'class'=>'btn btn-success',
           'id' => 'activity-create-link',
           'data-toggle' => 'modal',
           'data-target' => '#create-modal',
           'data-pjax' => '0',
                         ]) :false
            ],   
         [    
            
        'content'=>  
           
          Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')]),
                    
                ],
                     '{export}',
                    '{toggleData}',
             ],
    // 'toggleDataContainer' => ['class' => 'btn-group-sm'],
              'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK,
            'label'=>'Export',
            'header'=>'<li role="presentation" class="dropdown-header">Axion Loan</li>',
        ],
                     'exportContainer' => ['class' => 'btn-group-sm'],
                    
                     'panel' => [
                     'heading'=>'<h3 class="panel-title" style="color: white;">
                     Loans</h3>',
                     'type'=>'success',
       // 'before'=>Html::button('Create Loans',['value' => Url::to('index.php?r=loans/create'),'class' => 'btn btn-success',  'id' => 'activity-create-link','style' => 'background-color:#337ab7;color:#fff;']),
        // 'after'=>Html::a('<i class="fas fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info']),
                     'footer-panel'=>true
                                ],

                    

        'columns' => [
            
            
               ['class' => 'kartik\grid\ActionColumn', 'template' => '{update} {delete}','headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
            
            'buttons' => [
     
                            'update' => function ($url, $model, $key) {
                             return Html::a('<span class="glyphicon glyphicon-pencil msize"></span>','#', [
                            'class' => 'activity-update-link',
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',

                                         ]);
                                   },
                                   
                                   
             'delete' => function ($url, $model) {
                            return  Html::a('<span style="color:black" class="glyphicon glyphicon-trash msize"></span>', 
                              ['loans/delete', 'id' => $model->id], 
                              [
                            'data'=>[
                              'class' => 'activity-delete-link',
                              'title' => Yii::t('yii', 'Delete'),
                              'data-id' => $model->id,
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to delete this item?',
                            ]
                            ]);
                        },                       
     
                        ],
                        ],

                

            
            ['attribute'=>'id','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],],
               ['attribute'=>'firstname','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],],
                ['attribute'=>'lastname','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
                ],
                               
            ['attribute'=>'email','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],],
                      
           
            ['attribute'=>'mobile','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],],
             ['attribute'=>'address','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],],
                    ['attribute'=>'employmentType','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],

               'value'=>function ($model) {
            $et = $model->etypeValue;
                   if(isset($model->employmentType))
            {
                   return  $model->employmentType;
            }
            else { return '';}
         },
         
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$etypeArray,

        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]
               ],
            ['attribute'=>'loanType','vAlign'=>'middle',
            'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],

                 'value'=>function ($model) {
            $lt = $model->ltypeValue;
         
                   if(isset($model->loanType))
            {
                   return  $model->loanType;
            }
            else { return '';}
         },
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$ltypeArray,
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]
                  ],
            
        //      ['attribute'=>'bankStatusId',

        //     'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'], 
        //         'value'=>function ($model) {
        //     $status = $model->statusValue;
        //                  if(isset($model->bankStatusId))
        //     {
        //            return  $model->bankStatusId;
        //     }
        //     else { return '';}
        //  },
        // 'filterType'=>GridView::FILTER_SELECT2,
        //         'filter'=>$statusArray,
        // 'filterWidgetOptions'=>[
        //         'pluginOptions' => [
        //             'allowClear'=>true,
        //             'tags' => true,
        //             'maximumInputLength' => 10
        //         ],
        //     'options' => ['placeholder' => 'Select', 'multiple' => true],
        //     ]
        //      ],
           
          ]
          
          
           ]);
    
    
   ?>
   
   
   <?php $this->registerJs(
    "$('body').on('click', '.activity-update-link', function() {
    $.get(
        '".Yii::$app->request->baseUrl."/loans/update',
        {
            //id: $(this).closest('tr').data('key')
            id: $(this).data('id')

        },
        function (data) {
            //alert(data);
            $('#update-modal').find('.modal-body').html(data);
            $('#update-modal').modal();
        }
    );
});
$('#update-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>

   
   
   
   
      <?php $this->registerJs(
    "$('body').on('click', '#activity-create-link', function() {
    $.get(
        '".Yii::$app->request->baseUrl."/loans/create',
        {
            /*id: $(this).closest('tr').data('key')*/
        },
        function (data) {
        //  alert('test');
            $('#create-modal').find('.modal-body').html(data);
            $('#create-modal').modal();
        }
    );
});
$('#create-modal').on('hidden.bs.modal', function (e) {
    $(this).find('.modal-body').html('');
})
    "
); ?>



<?php Modal::begin([
    'header' => '<h1 align="center">Create Loan Request</h1>',
    'id' => 'create-modal',
    'size' => Modal::SIZE_LARGE,
    'footer' => '<a  href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>


<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h1 align="center">Update Record</h1>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>


</div>



