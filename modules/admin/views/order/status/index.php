<?php

use app\models\OrderEmail;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-status-index">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="pull-right" style="margin-top: 20px;"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New', ['/admin/order-status/create'], ['class' => 'btn btn-success btn-md'])?></div>

    <div class="clearfix"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'status_id',
            'status_name',
            'email_text_id',

            ['class' => 'kartik\grid\ActionColumn', 'noWrap' => true, 'template'=>'{update}{delete}', 'vAlign' => 'top'],
        ],
    ]); ?>

</div>