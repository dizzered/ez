<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'id_address',
            'id_shipping',
            'payment_type',
            // 'payment_check:ntext',
            // 'paypal',
            // 'transaction_number',
            // 'order_date',
            // 'order_status',
            // 'order_number',
            // 'addition_info:ntext',
            // 'final_sum',
            // 'promo_sum',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
