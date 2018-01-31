<?php
/** @var View $this */
/** @var Order[] $model */

use app\models\Order;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'My Orders';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-orders container">

    <h1 class="page-title" style="text-align: left;">My Orders <sup class="badge"><?= count($model) ?></sup><br>
        <small>This page will list all of the orders you have placed with us. Click on ORDER # to view details.</small>
    </h1>

    <?php if (count($model)): ?>
        <div class="table-responsive">
            <table class="info extended table-orders">
                <thead>
                <tr>
                    <th class="ui-corner-tl">Order #</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th class="ui-corner-tr">Status</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($model as $order): ?>
                        <tr>
                            <td class="ui-border-left"><?= Html::a($order->order_number, 'order/'.$order->id, ['style' => 'color:darkorange;']) ?></td>
                            <td><?= date('m/d/Y', strtotime($order->order_date)) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($order->final_sum) ?></td>
                            <td><?= count($order->items) ?></td>
                            <td class="ui-border-right"><?= '<span class="label label-'.$order->status->status_label.'">'.$order->status->status_name.'</span>' ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info" style="margin-bottom: 50px;">
            <h4 style="margin: 0; padding: 0;">No orders yet <i class="fa fa-frown-o"></i></h4>
        </div>

        <?= $this->render('@app/views/_firms') ?>
    <?php endif ?>

</div>