<?php
/* @var $newAddress \app\models\UserAddress */

use app\models\State;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$disabled = isset($disabled) ? $disabled : false;
$horizontal = isset($horizontal) ? $horizontal : false;

?>

<div class="payment-address-form">

    <?php $form = ActiveForm::begin([
        'id' => 'payment-address-form',
        'action' => '/user/save-address',
        'options' => [
            'class' => ''.($horizontal ? 'form-horizontal' : ''),
        ],
        'fieldConfig' => $horizontal
            ? [
                'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ]
            : [],
    ]); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($newAddress, 'line_1')->textInput(['disabled' => $disabled]) ?>

            <?= $form->field($newAddress, 'line_2')->textInput(['disabled' => $disabled]) ?>

            <?= $form->field($newAddress, 'city')->textInput(['disabled' => $disabled]) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($newAddress, 'state')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(State::find()->orderBy(['state' => SORT_ASC])->all(), 'state_code', 'state'),
                'options' => ['placeholder' => 'Select a state ...', 'disabled' => $disabled],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($newAddress, 'zip')->label('Zip/Postal Code')->widget(MaskedInput::class,
                [
                    'mask' => ['99999'],
                    'options' => ['disabled' => $disabled, 'class' => 'form-control']
                ]
            ) ?>

        </div>
    </div>

    <div class="clear"></div>

    <?php ActiveForm::end(); ?>

</div>

<div class="clear"></div>