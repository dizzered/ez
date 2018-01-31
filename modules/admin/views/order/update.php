<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Order ' . '#' . $model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['/admin/order']];
$this->params['breadcrumbs'][] = ['label' => 'Order #'.$model->order_number];
?>
<div class="order-update">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>