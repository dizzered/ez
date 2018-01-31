<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact container">

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>
    <?php endif; ?>

    <h1 class="page-title" style="text-align: left;">Submit a question to our support team</h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us.
        Thank you.
    </p>

    <div class="row">
        <div class="col-lg-8">

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'name') ?>

                <?php if (!Yii::$app->user->isGuest) {
                    $orders = [];
                    $orders[] = '--- Select Order ---';
                    /** @var \app\models\Order $order */
                    /** @var \app\models\User $user */
                    $user = Yii::$app->user->identity;
                    foreach ($user->orders as $order)
                    {
                        $orders[$order->order_number] = '#'.$order->order_number.' [Date: '.date('m/d/Y', strtotime($order->order_date)).']';
                    }

                    if (count($orders) > 0) {
                        echo $form->field($model, 'order')->dropDownList($orders);
                    }
                } ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-6" style="margin-top: 8px;">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-orange btn-xl', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <p>&nbsp;</p>

    <p>&nbsp;</p>

    <div class="row">
        <div class="col-lg-2">Online Chat Support:</div>
        <div class="col-lg-10"><a href="https://app.purechat.com/w/ezbuyback" style="color:#f28022; font-weight:bold;">Click here to Chat!</a></div>
    </div>

    <p>&nbsp;</p>

    <div class="row">
        <div class="col-lg-2">Our Mailing Address:</div>
        <div class="col-lg-10"><strong>10871 Bustleton Ave - Suite #232<br />Philadelphia, PA 19116</strong></div>
    </div>

</div>

<div class="map-container">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3051.4184659574!2d-75.023837!3d40.110676899999994!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c6b250658e0b91%3A0xea2c84e305254498!2zMTA4NzEgQnVzdGxldG9uIEF2ZSwgUGhpbGFkZWxwaGlhLCBQQSAxOTExNiwg0KHQqNCQ!5e0!3m2!1sru!2sru!4v1413552654879" width="100%" height="200" frameborder="0" style="border:0"></iframe>
</div>
