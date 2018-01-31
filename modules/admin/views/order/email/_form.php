<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderEmail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-email-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>