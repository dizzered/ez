<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Carrier */

$this->title = 'Create Carrier';
$this->params['breadcrumbs'][] = ['label' => 'Carriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-create">

    <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>

    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>