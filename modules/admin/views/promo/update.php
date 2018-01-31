<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promo */

$this->title = 'Update Promo: ' . ' ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Promos', 'url' => ['/admin/promo']];
$this->params['breadcrumbs'][] = ['label' => $model->code];
?>
<div class="promo-update">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>