<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = 'Create Device';
$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['/admin/item']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>