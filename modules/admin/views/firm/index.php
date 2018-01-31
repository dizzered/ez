<?php

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FirmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-index">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="pull-right" style="margin-top: 20px;"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New', ['/admin/firm/create'], ['class' => 'btn btn-success btn-md'])?></div>

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
                    Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['/admin/firm'], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'Reset data'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{toggleData}',
                '{export}',
            ]
        ],
        'options' =>  [
            'id' => 'firms'
        ],
        'showSort' => true,
        'showPersonalize' => true,
        'theme' => 'simple-bordered',
        'storage'=>'cookie',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'vAlign' => 'top'],
            [
                'attribute' => 'name',
                'content' => function($model) {
                    $image = $model->image ? '/uploads/firm/thumb_'.$model->image : '/img/noimage.png';
                    return Html::img($image, ['class' => 'img-thumbnail', 'style' => 'width:100px; vertical-align: text-top;']).' '.$model->name;
                },
                'vAlign' => 'top'
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'svisibility',
                'vAlign' => 'top',
                'width' => '130px'
            ],
            ['class' => 'kartik\grid\ActionColumn', 'noWrap' => true, 'template'=>'{update}{delete}', 'vAlign' => 'top'],
        ],
    ]); ?>

</div>