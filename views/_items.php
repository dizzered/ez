<?php

/* @var $model \app\models\Firm */
/* @var $this yii\web\View */

use app\models\Item;
use app\models\ItemPrice;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

?>

<?php if (count($items)): ?>
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

            <a id="elem_<?= $idx ?>" href="<?= Item::getPrettyLink($item['carrier_name'], $item['firm_name'], $item['name']) ?>" class="isotope elem carrier_<?= $item['id_carrier'] ?> <?= $mem_class ?>" style="display: block;" data-id="<?= $item['id'] ?>" data-carrier="<?= $item['id_carrier'] ?>">
                <img src="<?= Yii::$app->getHomeUrl() ?>uploads/phone/thumb_<?= $item['image'] ?>" alt="<?= $item['name'] ?> <?= $item['carrier_name'] ?>" />
                <br /><?= $item['name'] ?><br /><span class="carrier"><?= $item['carrier_name'] ?></span>
                <br /><span class="price-good"><span>up to</span> $<?= $item['price_good'] ?></span><div class="sell-btn">SELL</div></a>
            <?php ++$idx; ?>

        <?php endforeach ?>

        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <h3 class="page-title">Sorry, we were unable to find any results...</h3>
    <div class="clear" style="height: 1px;"></div>
<?php endif ?>
