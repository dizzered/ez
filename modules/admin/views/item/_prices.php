<?php

use app\models\Carrier;
use app\models\ItemPrice;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Prices</h3>
    </div>
    <div class="panel-body">

        <table class="table">
            <thead>
            <tr>
                <th style="width: 20%;">Carrier</th>
                <?php foreach (ItemPrice::$itemConditionLabels as $label): ?>
                    <th style="width: <?= 80 / count(ItemPrice::$itemConditionLabels) ?>px;"><?= $label?></th>
                <?php endforeach ?>
            </tr>
            </thead>
            <tbody>
                <?php $prices = $model->prices ? $model->prices : [new ItemPrice()]; ?>
                <?php foreach(Carrier::find()->all() as $carrier): ?>
                    <tr>
                        <td><?= $carrier->name ?></td>
                        <?php foreach (ItemPrice::$itemConditionTableLabels as $label): ?>
                            <?php $value = ArrayHelper::map($prices, 'id_carrier', $label); ?>
                            <td>
                                <div class="form-group field-<?= $carrier->id ?>-itemprice-<?= $label ?>" style="margin-bottom: 0;">
                                    <input type="text" id="<?= $carrier->id ?>-itemprice-<?= $label ?>" class="form-control" name="ItemPrice[<?= $carrier->id ?>][<?= $label ?>]" value="<?= ArrayHelper::getValue($value, $carrier->id, 0) ?>" />
                                </div>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>