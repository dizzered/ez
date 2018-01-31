<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carrier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrier-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->label(false)->hiddenInput() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?php
    if ($model->image) {
        echo '<div class="form-group">'.Html::img('/uploads/carrier/thumb_'.$model->image, ['class' => 'img-thumbnail', 'style' => 'width:200px; vertical-align: text-top;']).'</div>';
    }
    ?>

    <?= $form->field($model, 'svisibility')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= !$model->isNewRecord ? Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/admin/carrier/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) : '' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>