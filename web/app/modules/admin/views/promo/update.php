<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promo */

$this->title = 'Update Promo: ' . ' ' . $model->promo_id;
$this->params['breadcrumbs'][] = ['label' => 'Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->promo_id, 'url' => ['view', 'id' => $model->promo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
