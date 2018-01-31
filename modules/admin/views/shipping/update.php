<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Firm */

$this->title = 'Update Shipping: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shipping', 'url' => ['/admin/shipping']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div class="shipping-update">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>