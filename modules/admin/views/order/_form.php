<?php

use app\helpers\UserHtml;
use app\models\Order;
use app\models\OrderItem;
use app\models\OrderStatus;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-9\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Details</h3>
        </div>
        <div class="panel-body">

            <?= $form->field($model, 'order_number')->textInput(['readonly' => true]) ?>

            <?= $form->field($model, 'order_date')->textInput(['readonly' => true]) ?>

            <div class="form-group field-order-id_user">
                <label class="col-lg-3 control-label" for="order-id_user">User</label>
                <div class="col-lg-9" style="padding-top: 7px;"><?= UserHtml::userLink($model->user)?></div>
                <div class="col-lg-offset-3 col-lg-9"><div class="help-block"></div></div>
                <input type="hidden" id="userEmail" value="<?= $model->user->email ?>" />
            </div>

            <div class="form-group field-order-expiration">
                <label class="col-lg-3 control-label" for="order-expiration">Expiration</label>
                <div class="col-lg-9" style="padding-top: 7px;"><?= $model->expired ? '<h4 style="margin: 0"><span class="label label-danger">Expired '.$model->expirationDate.'</span></h4>' : $model->expirationDate ?></div>
                <div class="col-lg-offset-3 col-lg-9"><div class="help-block"></div></div>
            </div>

            <div class="form-group field-order-payment_type">
                <label class="col-lg-3 control-label" for="order-payment_type">
                    <?= Order::$orderPaymentTypeLabels[$model->payment_type] ?>
                </label>
                <div class="col-lg-9" style="padding-top: 7px;">
                    <?= $model->payment_type == Order::ORDER_PAYMENT_TYPE_PAYPAL ? $model->paypal : $model->payment_check ?>
                </div>
                <div class="col-lg-offset-3 col-lg-9"><div class="help-block"></div></div>
            </div>

            <?= $form->field($model, 'reprice_info', ['labelOptions' => ['style' => 'padding-top: 0;']])->widget(CKEditor::className(), [
                'options' => ['rows' => 4],
                'clientOptions' => [
                    'height' => '150px'
                ],
                'preset' => 'basic',

            ]) ?>

            <?= $form->field($model, 'addition_info')->textarea(['rows' => 4]) ?>

            <?= $form->field($model, 'final_sum')->textInput() ?>

            <?= $form->field($model, 'promo_sum')->textInput() ?>

            <?= $form->field($model, 'order_status')->dropDownList(OrderStatus::asArray(true)) ?>

            <?= $form->field($model, 'transaction_number')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <div class="col-lg-3" style="text-align: right">
                    <label for="order-send">Send e-mail</label>
                </div>
                <div class="col-lg-9">
                    <input type="checkbox" id="order-send" name="order_send" value="1" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <div class="pull-right">
                        <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['/admin/order/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-print"></i> Print', ['/admin/order/view?id='.$model->id], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Devices</h3>
        </div>
        <div class="panel-body">
            <?= $this->render('_items', ['model' => $model]) ?>
        </div>
    </div>

    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Address</h3>
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

                    <?php if($model->address): ?>
                        <tr>
                            <td><?= $model->address->line_1.'<br /><br />'.$model->address->getFullAddress(true, '<br />') ?></td>
                            <td><?= $model->address->line_2 ?></td>
                            <td><?= $model->address->city ?></td>
                            <td><?= $model->address->state ?></td>
                            <td><?= $model->address->zip ?></td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan='5'>Address was removed</td></tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>

    <?php if (count($model->getLog())): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Changing Log</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Order Recieved</td>
                        <td><?= $model->order_date ?></td>
                    </tr>
                    <?php foreach ($model->getLog() as $log): ?>
                        <tr>
                            <td><?= $log->text ?></td>
                            <td><?= $log->date ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Send message to user</h3>
        </div>
        <div class="panel-body">
            <div class="form-group" style="margin-left: 0; margin-right:  0;">
                <label for="messageSubject">Subject</label>
                <?= Html::input('text', 'messageSubject', Yii::$app->name.': Order #'.$model->order_number, ['class' => 'form-control', 'id' => 'messageSubject']) ?>
            </div>

            <div class="form-group" style="margin-left: 0; margin-right:  0;">
                <label for="messageText">Message Text</label>
                <?= CKEditor::widget([
                    'name' => 'messageText',
                    'options' => [
                        'id' => 'messageText',
                        'rows' => 16,
                    ],
                    'clientOptions' => [
                        'height' => '400px'
                    ],
                    'preset' => 'basic',
                ]) ?>
            </div>

            <div class="pull-right">
                <?= Html::button('<i class="glyphicon glyphicon-envelope"></i> Send Message', ['class' => 'btn btn-success', 'id' => 'sendMessage']) ?>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Shipping</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $model->shipping->name ?></td>
                    <td><?= $model->shipping->descr ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($model->shipping->price) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>