<?php

use app\models\ItemPrice;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
?>

<table class="table">
    <thead>
        <tr>
            <th class="item-image">Image</th>
            <th>Device</th>
            <th>Carrier</th>
            <th>Price</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model->items as $item): ?>
            <?php /** @var $item \app\models\OrderItem */ ?>
            <?php if ($item->item): ?>
                <tr class="align-middle">
                    <td class="item-image"><?= Html::img('/uploads/phone/thumb_'.$item->item->image) ?></td>
                    <td>
                        <?= Html::a($item->item->firm->name.' '.$item->item->name, ['/admin/item/update?id='.$item->item->id]) ?>
                        <br>
                        <?= $item->getAttributeLabel('phone_condition').': <strong>'.ItemPrice::$itemConditionLabels[$item->phone_condition].'</strong>' ?>
                    </td>
                    <td><?= $item->carrier->name ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($item->price) ?></td>
                    <td><?= $item->count ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>

    </tbody>
</table>
