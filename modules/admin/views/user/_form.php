<?php

use app\models\Payment;
use app\models\UserAddress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Details</h3>
        </div>
        <div class="panel-body">

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>

            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class,
                [
                    'mask' => ['99-999-9999', '999-999-9999']
                ]
            ) ?>

            <?= $form->field($model, 'addition_info')->textarea(['rows' => 4]) ?>

            <?= $form->field($model, 'created')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['/admin/user/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-random"></i> Reset Password', ['/admin/user/reset?id='.$model->id], ['class' => 'btn btn-warning', 'data-confirm' => 'Are you sure you want to reset password?']) ?>
            </div>

        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Addresses</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Address Line 1</th>
                    <th>Address Line 2</th>
                    <th>City</th>
                    <th>State/Province</th>
                    <th>Zip/Postal Code</th>
                </tr>
                </thead>
                <tbody>

                <?php /** @var UserAddress $address */?>
                <?php foreach ($model->addresses as $address): ?>
                    <tr>
                        <td><?= $address->line_1.'<br /><br />'.$address->getFullAddress(true, '<br />') ?></td>
                        <td><?= $address->line_2 ?></td>
                        <td><?= $address->city ?></td>
                        <td><?= $address->state ?></td>
                        <td><?= $address->zip ?></td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Payments</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Sum</th>
                    <th>Order #</th>
                </tr>
                </thead>
                <tbody>

                <?php /** @var Payment $payment */?>
                <?php foreach ($model->payments as $payment): ?>
                    <tr>
                        <td><?= $payment->payment_date ?></td>
                        <td><?= Yii::$app->formatter->asCurrency($payment->payment_sum) ?></td>
                        <td><?= Html::a($payment->order->order_number, '/admin/order/update?id='.$payment->id_order) ?></td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>