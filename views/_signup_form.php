<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
/* @var $registration \app\models\User */
/* @var $address \app\models\UserAddress */

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \app\models\State;
use yii\widgets\MaskedInput;

?>

<div class="book-like-wrapper">

    <div class="book-like-layer">

        <div class="book-like-layer">

            <div class="row">
                <div class="col-md-6 border-right">
                    <div class="inner-padding">
                        <h2 class="page-title">Your Contact Information:</h2>

                        <?php $form = ActiveForm::begin([
                            'id' => 'register-form',
                            'action' => '/register',
                            'options' => ['name' => 'register-form', 'class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-9\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($registration, 'email') ?>

                        <?= $form->field($registration, 'password')->passwordInput() ?>

                        <?= $form->field($registration, 'confirm')->passwordInput() ?>

                        <?= $form->field($registration, 'first_name')->textInput() ?>

                        <?= $form->field($registration, 'last_name')->textInput() ?>

                        <?= $form->field($registration, 'phone')->widget(MaskedInput::class,
                            [
                                'mask' => ['99-999-9999', '999-999-9999']
                            ]
                        ) ?>

                        <?= $form->field($address, 'line_1')->textInput() ?>

                        <?= $form->field($address, 'line_2')->textInput() ?>

                        <?= $form->field($address, 'city')->textInput() ?>

                        <?= $form->field($address, 'state')->widget(Select2::class, [
                                'data' => ArrayHelper::map(State::find()->all(), 'state_code', 'state'),
                                'options' => ['placeholder' => 'Select a state...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]
                        ) ?>

                        <?= $form->field($address, 'zip')->widget(MaskedInput::class,
                            [
                                'mask' => ['99999']
                            ]
                        ) ?>

                        <div class="col-lg-offset-3 col-lg-9" style="padding: 0 23px;">
                            <?= $form->field($registration, 'terms')->label(
                                'I understand that my offer is good for 14 days, and I acknowledge I have read and accept the <a href="'.
                                Yii::$app->getHomeUrl().'terms-and-conditions" target="_blank">Terms & Conditions</a> and understand device return policy.',
                                [
                                    'class' => 'control-label text-left'
                                ])->checkbox() ?>
                        </div>

                        <?php if (!isset($isCart)): ?>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <?= Html::submitButton('Register', ['class' => 'btn btn-custom btn-xl text-strong', 'name' => 'register-button']) ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="clear"></div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>

                <div class="col-md-6">
                    <div class="inner-padding">

                        <h2 class="page-title">Login:</h2>

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'action' => '/login',
                            'options' => ['name' => 'login-form', 'class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-9\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?php if (!isset($isCart)): ?>
                            <div class="col-lg-offset-3 col-lg-9" style="padding: 0 23px;">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-custom btn-xl text-strong', 'name' => 'login-button']) ?>
                                </div>
                            </div>

                            <div class="col-lg-offset-3" style="color:#999; padding: 0 5px;">
                                Forgot your password? <a href="<?php echo \Yii::$app->getHomeUrl(); ?>restore-password" style="font-weight: bold;color:#999;">Click here to restore!</a>
                            </div>
                        <?php else: ?>
                            <p class="cart-item-wrapper" style="margin:0 auto 10px;"><strong>What happens next?</strong> You will receive a confirmation email within a few minutes of submitting this form. A shipping kit will then be prepared for you and shipped to the address provided. Upon receipt of the shipping kit follow the included instructions and ship the device back. Once the device is received it will be tested and payment will be issued.</p>
                            <p class="cart-item-wrapper" style="margin:0 auto 10px;"><strong>How can I track my order?</strong> Please visit your <a href="<?= Yii::$app->getHomeUrl()?>user/orders"><strong>order page</strong></a> to get status of your completed order.</p>
                        <?php endif ?>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>