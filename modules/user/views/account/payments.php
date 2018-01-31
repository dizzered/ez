<?php
/** @var View $this */
/** @var Payment[] $model */

use app\models\Order;
use app\models\Payment;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'My Payments';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-payments container">

    <h1 class="page-title" style="text-align: left;">My Payments <sup class="badge"><?= count($model) ?></sup><br>
        <small>Listed below are payments that were made to you. Click on ORDER # to view details.</small>
    </h1>

    <?php if (count($model)): ?>
        <div class="table-responsive">
            <table class="info extended table-orders">
                <thead>
                <tr>
                    <th class="ui-corner-tl">Order #</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th class="ui-corner-tr">Amount</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($model as $payment): ?>
                        <?php /** @var Payment $payment */?>
                        <?php if ($payment->order): ?>
                            <tr>
                                <td class="ui-border-left"><?= Html::a($payment->order->order_number, 'order/'.$payment->order->id, ['style' => 'color:darkorange;']) ?></td>
                                <td><?= date('m/d/Y', strtotime($payment->payment_date)) ?></td>
                                <td><?= $payment->order->status->status_name ?></td>
                                <td class="ui-border-right"><?= Yii::$app->formatter->asCurrency($payment->payment_sum) ?></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="ui-border-left danger">Order was removed.</td>
                                <td class="danger"><?= date('m/d/Y', strtotime($payment->payment_date)) ?></td>
                                <td>&mdash;</td>
                                <td class="ui-border-right danger"><?= Yii::$app->formatter->asCurrency($payment->payment_sum) ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info" style="margin-bottom: 50px;">
            <h4 style="margin: 0; padding: 0;">No payments yet <i class="fa fa-frown-o"></i></h4>
        </div>

        <?= $this->render('@app/views/_firms') ?>
    <?php endif ?>

</div>