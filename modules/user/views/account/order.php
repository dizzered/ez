<?php
/** @var View $this */
/** @var Order $model */

use app\models\Order;
use app\models\OrderItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Order #'.$model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['orders']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-order container">

    <?php if (Yii::$app->session->hasFlash('paymentSaved')): ?>
        <div class="alert alert-success">
            Order details was successfully changed.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <h1 class="page-title" style="text-align: left;"><?= $this->title ?></h1>

    <div class="table-responsive">
        <table class="info extended">
            <thead>
            <tr>
                <th class="ui-corner-tl">Number</th>
                <th>Date</th>
                <th>Status</th>
                <th class="ui-corner-tr"><?= Order::$orderPaymentTypeLabels[$model->payment_type] ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="ui-corner-bl ui-border-left"><?= $model->order_number?></td>
                <td><?= date('m/d/Y', strtotime($model->order_date)) ?></td>
                <td><?= '<span class="label label-'.$model->status->status_label.'">'.$model->status->status_name.'</span>' ?></td>
                <td class="email-text ui-corner-br ui-border-right">
                    <?php if ($model->order_status == Order::ORDER_STATUS_PENDING): ?>
                        <?php $form = ActiveForm::begin([
                            'id' => 'order-payment-type',
                            'options' => [
                                'class' => 'form-inline',
                            ],
                        ]); ?>

                        <?php if ($model->payment_type == Order::ORDER_PAYMENT_TYPE_CHECK): ?>
                            <?= $form->field($model, 'payment_check')->label(false)->textInput(['size' => 24]) ?>
                        <?php else: ?>
                            <?= $form->field($model, 'paypal')->label(false) ?>
                        <?php endif ?>

                        <?= Html::submitButton('<span class="glyphicon glyphicon-refresh"></span> Change', ['class' => 'btn btn-warning']) ?>

                        <?php ActiveForm::end(); ?>
                    <?php else: ?>
                        <?= $model->payment_type == Order::ORDER_PAYMENT_TYPE_CHECK ? $model->payment_check : $model->paypal ?>
                    <?php endif ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <h2 class="page-title" style="text-align: left;">Devices</h2>

    <div class="table-responsive">
        <table class="info extended table-order-items">
            <thead>
            <tr>
                <th class="ui-corner-tl" style="width:120px;">Image</th>
                <th style="text-align:left;">Info</th>
                <th>Carrier</th>
                <th>Price</th>
                <th class="ui-corner-tr">Qty</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($model->items as $item): ?>
                    <?php /** @var OrderItem $item */?>
                    <tr>
                        <td class="ui-border-left"><?= Html::img(Yii::$app->getHomeUrl().'uploads/phone/thumb_'.$item->item->image) ?></td>
                        <td style="text-align:left;">
                            <h3 style="color:#222;"><strong><?= $item->item->firm->name.' '.$item->item->name ?></strong></h3>
                            <h3>Quoted Condition: <span style="color:#0899ff;"><?= \app\models\ItemPrice::$itemConditionLabels[$item->phone_condition] ?></span></h3>
                        </td>
                        <td><h3><?= $item->carrier->name ?></h3></td>
                        <td><h3 style="color:#0899ff;"><strong><?= Yii::$app->formatter->asCurrency($item->price) ?></strong></h3></td>
                        <td class="ui-border-right"><h3 style="color:#222;"><strong><?= $item->count ?></strong></h3></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="5" style="text-align:right;" class="ui-corner-bl ui-corner-br ui-border-lr">
                        <h3 style="color:#222;"><strong>Total: <span style="color:#0899ff;"><?= Yii::$app->formatter->asCurrency($model->getTotalPrice(true)) ?></span></strong>
                            <?= $model->promo_sum ? '<br />Including Promo: '.Yii::$app->formatter->asCurrency($model->promo_sum) : '' ?>
                        </h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="page-title" style="text-align: left;">Delivery Address</h2>

    <?php if ($model->address): ?>
        <?= $this->render('@app/views/_address_form', ['newAddress' => $model->address, 'disabled' => true, 'horizontal' => true])?>
    <?php else: ?>
        <div class="alert alert-danger">
            Address was removed.
        </div>
    <?php endif ?>

    <?php if ($model->order_status == Order::ORDER_STATUS_PENDING && count($model->user->addresses)): ?>
        <h2 class="page-title" style="text-align: left; font-size: 26px;">Change Address</h2>

        <?php $form = ActiveForm::begin([
            'id' => 'order-address-change',
            'options' => [
                'class' => 'form-inline',
            ],
        ]); ?>

        <?= $form->field($model, 'id_address')->label(false)->dropDownList($model->user->getAddressesList()) ?>

        <?= Html::submitButton('<span class="glyphicon glyphicon-refresh"></span> Change', ['class' => 'btn btn-warning']) ?>

        <?php ActiveForm::end(); ?>

        <p class="text-muted" style="margin: 5px 0;">You may add new delivery address in <?= Html::a('profile', Yii::$app->getHomeUrl().'user/profile') ?>.</p>
    <?php endif ?>

    <h2 class="page-title" style="text-align: left;">Shipping</h2>

    <table class="info extended">
        <thead>
        <tr>
            <th class="ui-corner-tl" style="text-align:left">Type</th>
            <th style="text-align:left;">Description</th>
            <th class="ui-corner-tr">Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="ui-border-left ui-corner-bl" style="text-align:left;"><h3><?= $model->shipping->name ?></h3></td>
            <td style="text-align:left;"><h3><?= $model->shipping->descr ?></h3></td>
            <td class="ui-border-right ui-corner-br"><h3 style="color:#0899ff;"><strong><?= Yii::$app->formatter->asCurrency($model->shipping->price) ?></strong></h3></td>
        </tr>
        </tbody>
    </table>

    <!-- <iframe src="https://sellmymobile.reliatrk.com/p.ashx?a=119&e=159&t=<?= $model->order_number; ?>&p=<?= $model->final_sum; ?>" height="1" width="1" frameborder="0"></iframe> -->

</div>