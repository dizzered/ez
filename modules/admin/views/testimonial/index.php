<?php

use app\models\Promo;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TestimonialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testimonials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-index">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="pull-right" style="margin-top: 20px;"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New', ['/admin/testimonial/create'], ['class' => 'btn btn-success btn-md'])?></div>

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
                    Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['/admin/testimonial'], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'Reset data'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{toggleData}',
                '{export}',
            ]
        ],
        'options' =>  [
            'id' => 'carriers'
        ],
        'showSort' => true,
        'showPersonalize' => true,
        'theme' => 'simple-bordered',
        'storage'=>'cookie',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'vAlign' => 'top'],
            [
                'attribute' => 'text',
                'content' => function($model) {
                    return StringHelper::truncateWords($model->text, 20);
                }
            ],
            'signature',
            [
                'attribute' => 'created',
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
            ['class' => 'kartik\grid\ActionColumn', 'noWrap' => true, 'template'=>'{update}{delete}', 'vAlign' => 'top'],
        ],
    ]); ?>

</div>