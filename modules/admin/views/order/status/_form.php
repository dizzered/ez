<?php

use app\models\OrderEmail;
use app\models\OrderStatus;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderStatus */
/* @var $form yii\widgets\ActiveForm */

// Templating example of formatting each list element
$url = \Yii::$app->urlManager->baseUrl . '/images/flags/';
$format = <<< SCRIPT
function format(status_label) {
    if (!status_label.id) return status_label.text; // optgroup
    classStr = 'label label-' +  status_label.text.toLowerCase();
    return '<span class="' + classStr + '">' + status_label.text + '</span>';
}
SCRIPT;
$escape = new JsExpression("function(m) { return m; }");
$this->registerJs($format, View::POS_HEAD);
?>

<div class="order-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status_id')->textInput(['size' => 10, 'style' => 'width: auto;']) ?>

    <?= $form->field($model, 'status_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_text_id')->dropDownList(ArrayHelper::merge(['' => 'Select Message...'], ArrayHelper::map(OrderEmail::find()->orderBy(['email_name' => SORT_ASC])->all(), 'id', 'email_name'))) ?>

    <?= $form->field($model, 'status_label')->widget(Select2::classname(), [
        'data' => OrderStatus::$orderStatusesClasses,
        'options' => ['placeholder' => 'Select Label...'],
        'pluginOptions' => [
            'allowClear' => true,
            'templateResult' => new JsExpression('format'),
            'templateSelection' => new JsExpression('format'),
            'escapeMarkup' => $escape,
        ],
    ]); ?>

    <?= $form->field($model, 'visibility')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= !$model->isNewRecord ? Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/admin/order-status/delete?id='.$model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete?']) : '' ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>