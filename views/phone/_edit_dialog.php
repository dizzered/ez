<?php
/* @var $model \app\models\Item */
/* @var $price \app\models\ItemPrice */
/* @var $this yii\web\View */
/* @var $option \app\models\Option */
/* @var $single boolean */

use app\models\ItemPrice;
use app\models\Option;

$option = Option::findOne(1);
$single = $single ? 'Single' : '';
?>

<div class="phone-dlg ui-dialog ui-widget ui-widget-content ui-corner-all ui-front fn-phone-single">

    <div style="width: auto; min-height: 61px; max-height: none; height: auto;" class="ui-dialog-content ui-widget-content">

        <input type="hidden" id="editPhoneID" value="0" />
        <input type="hidden" id="editCarrierID" value="0" />
        <input type="hidden" id="editPrice" value="0" />
        <input type="hidden" id="editCoockie" value="0" />
        <input type="hidden" id="editNumber" value="0" />

        <div id="editConditionRadio" class="btn-condition btn-group" data-toggle="buttons">
            <label for="editConditionPerfect" class="btn">
                <input type="radio" id="editConditionPerfect" name="editConditionRadio" value="<?= ItemPrice::ITEM_CONDITION_PERFECT ?>">
                <div class="left">PERFECT <p class="cost perfect-cost"></p></div>
                <div class="right">
                    <span class="phone-name"></span>
                    Device is in perfect condition and looks like new. No signs of wear or scratches, has to be 100% functional and include original box with accessories.
                </div>
                <div class="clear"></div>
            </label>

            <label for="editConditionGood" class="btn">
                <input type="radio" id="editConditionGood" name="editConditionRadio" checked="checked" value="<?= ItemPrice::ITEM_CONDITION_GOOD ?>">
                <div class="left">GOOD <p class="cost good-cost"></p></div>
                <div class="right">
                    <span class="phone-name"></span>
                    Device is in good condition and 100% functional. It can have little wear but no cracks in the screen, missing buttons or bad charge ports is allowed.
                </div>
                <div class="clear"></div>
            </label>

            <label for="editConditionFair" class="btn">
                <input type="radio" id="editConditionFair" name="editConditionRadio" value="<?= ItemPrice::ITEM_CONDITION_FAIR ?>">
                <div class="left">FAIR <p class="cost fair-cost"></p></div>
                <div class="right">
                    <span class="phone-name"></span>
                    Device is in fair condition and 100% functional. It can have lots of scratches but no cracks in the screen, missing buttons or bad charge ports is allowed.
                </div>
                <div class="clear"></div>
            </label>
        </div>

        <div class="clear" style="border-bottom: 1px dashed #ddd;padding-top: 20px;margin: 0 20px;"></div>

        <div class="button-group">
            <button id="editPhoneCart" class="btn btn-custom btn-xl text-strong">Continue</button>
        </div>

        <div class="clear"></div>

    </div>
</div>
