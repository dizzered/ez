<?php
/** @var Order $model */

use app\models\ItemPrice;
use app\models\Order;
?>

<table style="width:100%;">
    <tr>
        <td>
            <?= $text ?>
        </td>
    </tr>
</table>

<div class="table-responsive">
    <table style="width:100%; margin:0 auto; border-spacing: 0; border-collapse: collapse; border: 1px solid #ddd;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; border-bottom-width: 2px; background: #eee; padding:10px; text-align:left;">Phone</th>
                <th style="border: 1px solid #ddd; border-bottom-width: 2px; background: #eee; padding:10px; text-align:left;">Condition</th>
                <th style="border: 1px solid #ddd; border-bottom-width: 2px; background: #eee; padding:10px; text-align:left;">Carrier</th>
                <th style="border: 1px solid #ddd; border-bottom-width: 2px; background: #eee; padding:10px; text-align:left;">Price</th>
                <th style="border: 1px solid #ddd; border-bottom-width: 2px; background: #eee; padding:10px; text-align:left;">Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->items as $item): ?>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;"><?= $item->item->firm->name.' '.$item->item->name ?></td>
                    <td style="border: 1px solid #ddd; padding: 10px;"><?= ItemPrice::$itemConditionLabels[$item->phone_condition] ?></td>
                    <td style="border: 1px solid #ddd; padding: 10px;"><?= $item->carrier->name ?></td>
                    <td style="border: 1px solid #ddd; padding: 10px;"><?= $item->price ?></td>
                    <td style="border: 1px solid #ddd; padding: 10px;"><?= $item->count ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div style='margin: 10px;'>
    <strong>Total: <?= Yii::$app->formatter->asCurrency($model->final_sum + $model->promo_sum)?></strong>
    <?= $model->promo_sum ? '<br />Including Promo:'.Yii::$app->formatter->asCurrency($model->promo_sum) : '' ?>
</div>