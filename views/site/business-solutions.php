<?php
/* @var $model \app\models\InquiryForm */

use app\models\State;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Business Solutions Inquiry';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-page container">

    <h1 class="page-title" style="text-align: left;"><?= $this->title ?></h1>

    <p>Since the recycling of consumer devices has become second nature in the US it was only a matter of time until the business world took advantage.</p>

    <p>Now businesses have assets which could be worth thousands of dollars to cash in on.</p>

    <p><strong>So, don’t delay find out what you can make TODAY!</strong></p>

    <p>&nbsp;</p>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Thank you for inquiry. We will contact you in a moment.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <div class="book-like-wrapper">

        <div class="book-like-layer">

            <div class="book-like-layer">

                <?php $form = ActiveForm::begin([
                    'id' => 'inquery-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-offset-4 col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 control-label'],
                    ],
                ]); ?>

                <div class="row">

                    <div class="col-md-6">

                        <div class="inner-padding border-right">

                            <?= $form->field($model, 'firstName')->textInput() ?>

                            <?= $form->field($model, 'lastName')->textInput() ?>

                            <?= $form->field($model, 'businessName')->textInput() ?>

                            <?= $form->field($model, 'email')->textInput() ?>

                            <?= $form->field($model, 'confirmEmail')->textInput() ?>

                            <?= $form->field($model, 'phone')->widget(MaskedInput::class,
                                [
                                    'mask' => ['99-999-9999', '999-999-9999']
                                ]
                            ) ?>

                            <?= $form->field($model, 'address1')->textInput() ?>

                            <?= $form->field($model, 'address2')->textInput() ?>

                            <?= $form->field($model, 'city')->textInput() ?>

                            <?= $form->field($model, 'state')->widget(Select2::class, [
                                    'data' => ArrayHelper::map(State::find()->all(), 'state_code', 'state'),
                                    'options' => ['placeholder' => 'Select a state...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]
                            ) ?>

                            <?= $form->field($model, 'zip')->widget(MaskedInput::class,
                                [
                                    'mask' => ['99999']
                                ]
                            ) ?>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="inner-padding">

                            <?= $form->field($model, 'quantity')->dropDownList($model->quantityLabels) ?>

                            <?= $form->field($model, 'condition')->dropDownList($model->conditionLabels) ?>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8" style="margin-top: -23px;">
                                    <p class="disclaimer">Choose the general overall condition of the devices you wish to sell.</p>
                                </div>
                            </div>

                            <?= $form->field($model, 'additionalInfo')->textarea(['rows' => 4]) ?>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <?= $form->field($model, 'agree')
                                        ->label(
                                            'I have read and agree to the <a href="'.\Yii::$app->getHomeUrl().'terms-and-conditions" target="_blank">Terms &amp; Conditions.</a>',
                                            ['class' => 'control-label agree-checkbox-label']
                                        )
                                        ->checkbox()
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <?= Html::submitButton('Send Inquiry', ['class' => 'btn btn-custom btn-xl text-strong', 'name' => 'corporate_button']) ?>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="clear"></div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>

</div>
