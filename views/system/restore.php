<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\User */

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \app\models\State;
use yii\widgets\MaskedInput;

$this->title = 'Password Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-restore-password container">

    <?php if (Yii::$app->session->hasFlash('passwordReseted')): ?>
        <div class="alert alert-success">
            Password was reseted successfully. You will receive e-mail with your new password shortly.
        </div>
    <?php endif; ?>

    <h1 class="page-title" style="text-align: left;">Forgot Your Password?</h1>

    <h3>No problem!</h3>

    <p>Please enter your email address to reset your password.</p>

    <p>&nbsp;</p>

    <div class="row">

        <div class="col-md-6">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter email address..']) ?>

            <div class="form-group">
                <?= Html::submitButton('Reset My Password', ['class' => 'btn btn-custom btn-xl text-strong', 'name' => 'restore-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>