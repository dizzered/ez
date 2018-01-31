<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrderEmail */

$this->title = 'Create Order Email';
$this->params['breadcrumbs'][] = ['label' => 'Order Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-email-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>