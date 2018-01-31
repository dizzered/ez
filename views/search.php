<?php

/* @var $model \app\models\Firm */
/* @var $carriers \app\models\Carrier[] */
/* @var $this yii\web\View */
/* @var $query string */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Sell Your Old Device for Top Cash!';
?>
<div class="search-index container">

    <?php if (count($items)): ?>
        <h1 class="page-title">Search results for <span><?= $query ?></span></h1>

        <div class="body-content">

            <div class="phones-filters">
                <span>Carrier:&nbsp;&nbsp;
                    <?= Html::dropDownList('carrier', null, ArrayHelper::merge(['all' => 'All'], ArrayHelper::map($carriers, 'id', 'name')), ['id' => 'carrier']) ?>
                </span>&nbsp;&nbsp;<span>Memory:&nbsp;&nbsp;
                    <?= Html::dropDownList('memory', null, $this->context->memoryFilterList, ['id' => 'memory']) ?>
                </span>
            </div>

            <?= $this->render('_items', ['items' => $items]) ?>

        </div>
    <?php else: ?>
        <h2 class="page-title"><small>Sorry, we were unable to find any results...</small></h2>
        <div class="clear" style="height: 1px;"></div>

        <?= $this->render('_firms') ?>
    <?php endif ?>
</div>