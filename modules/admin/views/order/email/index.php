<?php

use app\models\OrderEmail;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-email-index">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="pull-right" style="margin-top: 20px;"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New', ['/admin/order-email/create'], ['class' => 'btn btn-success btn-md'])?></div>

    <div class="clearfix"></div>

    <?php foreach ($dataProvider->models as $model): ?>

        <?php /** @var OrderEmail $model */ ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form_'.$model->id
        ]); ?>

        <div class="panel panel-primary">
            <div class="panel-body">
                <table style="width: 100%;" class="formTable">
                    <tr>
                        <td style="width: 60%;">
                            <p>ID: #<?= $model->id ?></p>
                            <?= $form->field($model, 'email_name')->label(false)->textInput(['placeholder' => 'Enter name...']) ?>
                            <?= $form->field($model, 'email_text')->label(false)->textarea(['rows' => 8]) ?>
                            <?= $form->field($model, 'id')->label(false)->hiddenInput() ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/admin/order-email/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) ?>
                        </td>
                        <td style="vertical-align: top; padding-left: 50px;">
                            <h4>Shortcodes</h4>
                            <ul>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">first_name</a>] - insert customer first name</li>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">last_name</a>] - insert customer last name</li>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">email</a>] - insert customer email name</li>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">order</a>] - insert order number</li>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">description</a>] - insert description of device</li>
                                <li>[<a href="#" class="fnShortcode kv-editable-link">payment_amount</a>] - insert payment amount of order</li>
                            </ul>
                            <div class="help-block">Click on shortcode to insert into text.</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    <?php endforeach ?>

</div>