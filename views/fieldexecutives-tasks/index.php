<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FieldexecutivesTasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php

$fieldexecutivesData=ArrayHelper::map($fieldexecutives,'id','name');

$gridColumns = [
    
     [
    'class'=>'kartik\grid\ActionColumn',
    /*'dropdown'=>true,
    'dropdownOptions'=>['class'=>'pull-right'],*/
	//'template' => '{view} {update} {delete}',
         'template' => '{update}',
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
	 'buttons' => [
            /* 
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                    'class' => 'activity-view-link',
                    'title' => Yii::t('yii', 'View'),
                    'data-toggle' => 'modal',
                    'data-target' => '#view-modal',
                    'data-id' => $key,
                    'data-pjax' => '0',

                ]);
            },
             * 
             */
	    'update' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                    'class' => 'activity-update-link',
                    'title' => Yii::t('yii', 'Update'),
                    'data-toggle' => 'modal',
                    'data-target' => '#update-modal',
                    'data-id' => $model->processId.'-'.$model->processType,
                    'data-pjax' => '0',

                ]);
            },
           /*         
            'delete' => function ($url, $model, $key) {
                if(Yii::$app->user->identity->type == 'Admin')
                {
                     return Html::a('<span class="glyphicon glyphicon-trash"></span>','#', [
                    'class' => 'activity-delete-link',
                    'title' => Yii::t('yii', 'Delete'),
                    'data-id' => $key,
                    'data-pjax' => '0',

                     ]);
                }
            },   
            * 
            */           
        ],
    ],
     
     /*
    [
    'class'=>'kartik\grid\CheckboxColumn',
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'headerOptions'=>['style'=>'border: 2px #000 solid; background-color:#337ab7;color:#fff;'],
    ],    
                     * 
                     */            
                    
// the name column configuration
                    
    [
        'attribute'=>'processNo',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],
                    
    [
        'attribute'=>'processType',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['Select'=>'Select','Retail'=>'Retail','Repo'=>'Repo','PI'=>'PI'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>false],
                ],
    ],                 

    [
        'attribute'=>'companyName',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],
                    
    [
        'attribute'=>'requestDateTime',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:10px;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' =>([
                    'convertFormat'=>true,   
                'pluginOptions'=>[                                          
                     'timePicker'=>true,
                     'timePickerIncrement'=>15,
                     'locale'=>['format'=>'d-m-Y h:i A']
                ],
                    'presetDropdown'=>true,
            ])
    ],                
                    
    [
        'attribute'=>'vehicleNumber',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],

    ],                
                    
    [
        'attribute'=>'location',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
    ],
                    
    [
        'attribute'=>'fieldexecutiveId',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;padding-right:100px;'],
        'value'=>function ($model) {
            $fieldexecutiveUser = $model->fieldexecutiveUser;
            if(isset($fieldexecutiveUser->name))
            {
                   return  $fieldexecutiveUser->name;
            }
            else { return '';}
         },

        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$fieldexecutivesData,
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]

    ],                

    [
        'attribute'=>'customerAppointmentDateTime',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#337ab7;'],
        'format' => ['date', 'php:d-m-Y h:i a'],
        'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' =>([
                    'convertFormat'=>true,   
                'pluginOptions'=>[                                          
                     'timePicker'=>true,
                     'timePickerIncrement'=>15,
                     'locale'=>['format'=>'d-m-Y h:i A']
                ],
                    'presetDropdown'=>true,
            ])
    ],
                 
    [
        'attribute'=>'status',
        'vAlign'=>'middle',
        'headerOptions'=>['style'=>'border: 2px #000 solid;background-color:#5cb85c;padding-right:100px;'],
        'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['SCHEDULE'=>'SCHEDULE','RE-SCHEDULE'=>'RE-SCHEDULE','COMPLETED'=>'COMPLETED','CANCELLED'=>'CANCELLED'],       
        'filterWidgetOptions'=>[
                'pluginOptions' => [
                    'allowClear'=>true,
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            ]

    ],             
                    
                    
 
];
     
    echo GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>$gridColumns,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'rowOptions'=>['style'=>'border: 2px #000 solid'],
        'rowOptions' => function ($model){
        
          if($model->processType == 'Retail' ){
              return ['style'=>'background-color: #50e8fc;'];
          }else{
            return ['style'=>'background-color: #DAF7A6;'];
          }
         
        }, 
        'containerOptions'=>['style'=>'overflow: auto; font-size:12px;'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'pjax'=>true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar'=> [
            /*
            ['content'=>
                Html::a('<span class="glyphicon glyphicon-plus"></span>','#', [
                        'id' => 'activity-create-link',
                        'class'=>'btn btn-success',
                        'title' => Yii::t('yii', 'Create'),
                        'data-toggle' => 'modal',
                        'data-target' => '#create-modal',
                        //'data-id' => $key,
                        'data-pjax' => '0',

                    ]).' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
            ],
             * 
             */
            '{export}',
            '{toggleData}',
            /*
            ['content'=>(Yii::$app->user->identity->type != 'Admin')? false:
                Html::a('Delete','#', [
                        'id' => 'activity-mul-delete-link',
                        'class'=>'btn btn-success',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-pjax' => '0',
                    ])
            ],
             * 
             */
        ],
        // set export properties
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK,
            'label'=>'Export',
            'header'=>'<li role="presentation" class="dropdown-header">Field Executives Tasks</li>',
        ],
        // parameters from the demo form
        'bordered'=>false,
        'striped'=>false,
        'condensed'=>false,
        'responsive'=>true,
        'hover'=>true,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>'Field Executives Tasks'
        ],
        'resizableColumns'=>false,        
        'persistResize'=>false,
        'exportConfig'=>  [   
        ]
    ]);


?>



<?php $this->registerJs(
    "$('body').on('click', '.activity-update-link', function() {
        var str = $(this).data('id');
        
        var res = str.split('-');
            if(res[1] == 'PI')
            {
              var url = '".Yii::$app->request->baseUrl."/preinspection/update';
            }
            else
            {
              var url = '".Yii::$app->request->baseUrl."/retail-data/update';
            }
            //alert(url);
    $.get(
        url,         
        {
            //id: $(this).closest('tr').data('key')
            id: res[0]
            
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







<?php Modal::begin([
    'id' => 'update-modal',
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">Update Record</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]); ?>
<?php Modal::end(); ?>

