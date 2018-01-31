<?php

use app\models\Firm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Description</h3>
                </div>
                <div class="panel-body">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'descr')->textarea(['rows' => 8]) ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Details</h3>
                </div>
                <div class="panel-body">

                    <?= $form->field($model, 'id_firm')->dropDownList(ArrayHelper::map(Firm::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>

                    <?= $form->field($model, 'image')->label(false)->hiddenInput() ?>

                    <?= $form->field($model, 'file')->fileInput() ?>

                    <?php
                    if ($model->image) {
                        echo '<div class="form-group">'.Html::img('/uploads/phone/thumb_'.$model->image, ['class' => 'img-thumbnail', 'style' => 'width:100px; vertical-align: text-top;']).'</div>';
                    }
                    ?>

                    <?= $form->field($model, 'svisibility')->checkbox() ?>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?= $this->render('_prices', ['model' => $model, 'form' => $form]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= !$model->isNewRecord ? Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/admin/item/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) : '' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>