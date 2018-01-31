<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Firm */

$this->title = 'Update Firm: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Firms', 'url' => ['/admin/firm']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div class="firm-update">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>