<?php

/* @var $model \app\models\Firm */
/* @var $carriers \app\models\Carrier[] */
/* @var $this yii\web\View */

use app\models\Item;
use app\models\ItemPrice;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

$this->title = 'Sell Your Used '.$model->name.' Device!';
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="firm-index container">

    <h1 class="page-title">Which <span><?= $model->name ?></span> device would you like to sell?</h1>

    <div class="body-content">

        <div class="phones-filters">
            <span>Carrier:&nbsp;&nbsp;
                <?= Html::dropDownList('carrier', null, ArrayHelper::merge(['all' => 'All'], ArrayHelper::map($carriers, 'id', 'name')), ['id' => 'carrier']) ?>
            </span>&nbsp;&nbsp;<span>Memory:&nbsp;&nbsp;
                <?= Html::dropDownList('memory', null, $this->context->memoryFilterList, ['id' => 'memory']) ?>
            </span>
        </div>

        <div class="selector elem-container">
            <?php $idx = 0; ?>
            <?php foreach ($items as $item): ?>
                <?php
                $name_arr = explode(' ', $item['name']);
                $mem_class = '';
                foreach ($name_arr as $str)
                {
                    $pos = strpos($str, 'GB');
                    if ($pos !== false) {
                        $mem_class = strtolower($str);
                    }
                }
                ?>

                <a id="elem_<?= $idx ?>" href="<?= Item::getPrettyLink($item['carrier_name'], $model->name, $item['name']) ?>" class="isotope elem carrier_<?= $item['id_carrier'] ?> <?= $mem_class ?>" style="display: block;" data-id="<?= $item['id'] ?>" data-carrier="<?= $item['id_carrier'] ?>">
                    <img src="<?= Yii::$app->getHomeUrl() ?>uploads/phone/thumb_<?= $item['image'] ?>" alt="<?= $item['name'] ?> <?= $item['carrier_name'] ?>" />
                    <br /><?= $item['name'] ?><br /><span class="carrier"><?= $item['carrier_name'] ?></span>
                    <br /><span class="price-good"><span>up to</span> $<?= $item['price_good'] ?></span><div class="sell-btn">SELL</div></a>
                <?php ++$idx; ?>

            <?php endforeach ?>

            <div class="clearfix"></div>
        </div>

    </div>
</div>