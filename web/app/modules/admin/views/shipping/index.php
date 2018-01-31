<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shippings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shipping', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'descr:ntext',
            'price',
            'image',
            // 'svisibility',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
