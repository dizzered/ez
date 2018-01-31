<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Option */

$this->title = 'Options';
$this->params['breadcrumbs'][] = ['label' => 'Options'];

?>
<div class="option-update">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>