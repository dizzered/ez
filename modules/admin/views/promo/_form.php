<?php

use app\models\Firm;
use app\models\Item;
use app\models\Promo;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Promo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Promo::$promoTypeLabels) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'expiration_date')->widget(DatePicker::class, [
        'options' => ['placeholder' => 'Leave blank if promo will never expire...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose'=>true
        ]
    ]) ?>

    <?= $form->field($model, 'group')->dropDownList(Promo::$promoGroupLabels) ?>

    <div class="group firm">
        <?php /** @var Firm $firm */ ?>
        <?php foreach (Firm::find()->where(['svisibility' => 1])->orderBy(['name' => SORT_ASC])->all() as $firm): ?>
            <p>
                <input type="checkbox" name="firm[]" id="firm_<?= $firm->id ?>" value="<?= $firm->id ?>" <?= in_array($firm->id, $model->itemsArray) ? 'checked="checked"' : ''; ?> />
                <label for="firm_<?= $firm->id ?>"><?= $firm->name ?></label>
            </p>
        <?php endforeach ?>
    </div>

    <div class="panel panel-default group device-group">
        <div class="panel-heading">
            <div class="device-search">
                <input type="text" id="deviceSearch" name="deviceSearch" class="form-control" placeholder="Search by name..." />
                <span class="clear-search glyphicon glyphicon-remove-circle"></span>
            </div>
        </div>
        <div class="panel-body">
            <?php /** @var Item $item */ ?>
            <?php foreach (Item::find()->where(['svisibility' => 1])->orderBy(['name' => SORT_ASC])->all() as $item): ?>
                <p>
                    <input type="checkbox" name="device[]" id="device_<?= $item->id ?>" value="<?= $item->id ?>" <?= in_array($item->id, $model->itemsArray) ? 'checked="checked"' : ''; ?> />
                    <label for="device_<?= $item->id ?>"><?= $item->name ?> (<?= $item->firm->name ?>)</label>
                </p>
            <?php endforeach ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= !$model->isNewRecord ? Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/admin/promo/delete?id='.$model->promo_id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) : '' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>