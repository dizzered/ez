<?php
use app\helpers\UserColumn;
use app\models\Order;
use app\models\OrderStatus;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'exportConfig' => [
                GridView::HTML => true,
                GridView::CSV => true,
                GridView::EXCEL => true

            ],
            'resizableColumns' => false,
            'striped' => true,
            'bordered' => true,
            'pjax' => true,
            'hover' => true,
            'filterModel' => $searchModel,
            //'panelFooterTemplate' => '{pager} <div class="pull-right">{summary}</div>',
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => false,
                'before' => '{summary}',
                'after' => false,
            ],
            'toolbar' =>  [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['/admin/order'], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'Reset data'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{toggleData}',
                '{export}',
            ]
        ],
        'options' =>  [
            'id' => 'orders'
        ],
        'showSort' => true,
        'showPersonalize' => true,
        'theme' => 'simple-bordered',
        'storage'=>'cookie',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'vAlign' => 'top'],
            //'id',
            [
                'attribute' => 'order_number',
                'width' => '100px'
            ],
            [
                'attribute' => 'order_date',
                'filterType'=>GridView::FILTER_DATE_RANGE,
                'format'=>'raw',
                'width' => '300px',
                'filterWidgetOptions'=>[
                    'hideInput' => false,
                    'presetDropdown'=>true,
                    'pluginOptions'=>[
                        'locale'=>['format'=> 'DD MMM YYYY'],
                        'opens'=>'left'
                    ]
                ],
            ],
            [
                'class' => UserColumn::class,
                'attribute' => 'id_user',
                'user_attribute' => 'user',
            ],
            [
                'attribute' => 'order_status',
                'content' => function($model) {
                    $mailed = $model->status->status_id != Order::ORDER_STATUS_BOX_MAILED ? ' | <a href="#" onclick="setBoxMailed('.$model->id.')"><small>shipping kit mailed</small></a>' : '';
                    return '<span class="label label-'.$model->status->status_label.'">'.$model->status->status_name.'</span>'.$mailed;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=> OrderStatus::asArray(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'All orders...'],
                'format'=>'raw',
                'width' => '250px',
                'contentOptions' => function($model) {
                    return ['class' => 'status-'.$model->id];
                }
            ],

            //'id_address',
            //'id_shipping',
            //'payment_type',
            // 'payment_check:ntext',
            // 'paypal',
            // 'transaction_number',
            // 'addition_info:ntext',
            // 'final_sum',
            // 'promo_sum',

            [
                'class' => 'kartik\grid\ActionColumn',
                'noWrap' => true,
                'template'=>'{update}{delete}',
                'vAlign' => 'top'],
        ],
    ]); ?>

</div>