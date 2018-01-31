<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderStatus */

$this->title = 'Order Status: #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#'.$model->id];
?>
<div class="order-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>