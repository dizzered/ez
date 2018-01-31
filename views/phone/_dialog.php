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
        <input type="hidden" id="phoneID<?= $single ?>" value="<?= $model->id ?>" />
        <input type="hidden" id="carrierID<?= $single ?>" value="<?= $price->id_carrier ?>" />
        <input type="hidden" id="price<?= $single ?>" value="0" />
        <input type="hidden" id="perfectCost" class="condition-cost-hidden conditionPerfect<?= $single ?>" name="perfectCost" value="<?= $price->price_good ?>" />
        <input type="hidden" id="goodCost" class="condition-cost-hidden conditionGood<?= $single ?>" name="goodCost" value="<?= $price->price_fair ?>" />
        <input type="hidden" id="fairCost" class="condition-cost-hidden conditionFair<?= $single ?>" name="fairCost" value="<?= $price->price_poor ?>" />
        <input type="hidden" id="shareBonus" name="shareBonus" value="<?= $option->share_bonus ?>" />

        <div id="conditionRadio<?= $single ?>" class="btn-condition btn-group" data-toggle="buttons">
            <label for="conditionPerfect<?= $single ?>" class="btn active">
                <input type="radio" id="conditionPerfect<?= $single ?>" name="conditionRadio<?= $single ?>" checked="checked" value="<?= ItemPrice::ITEM_CONDITION_PERFECT ?>">
                <div class="left">PERFECT <p class="cost perfect-cost">$<?= $price->price_good ?></p></div>
                <div class="right">
                    <span class="phone-name"><?= $model->id ? $model->firm->name : '' ?> <?= $model->name ?></span>
                    is in perfect condition and looks like new. No signs of wear or scratches, has to be 100% functional and include original box with accessories.
                </div>
            </label>
            <label for="conditionGood<?= $single ?>" class="btn">
                <input type="radio" id="conditionGood<?= $single ?>" name="conditionRadio<?= $single ?>" value="<?= ItemPrice::ITEM_CONDITION_GOOD ?>">
                <div class="left">GOOD <p class="cost good-cost">$<?= $price->price_fair ?></p></div>
                <div class="right">
                    <span class="phone-name"><?= $model->id ? $model->firm->name : '' ?> <?= $model->name ?></span>
                    is in good condition and 100% functional. It can have little wear but no cracks in the screen, missing buttons or bad charge ports is allowed.
                </div>
            </label>
            <label for="conditionFair<?= $single ?>" class="btn">
                <input type="radio" id="conditionFair<?= $single ?>" name="conditionRadio<?= $single ?>" value="<?= ItemPrice::ITEM_CONDITION_FAIR ?>">
                <div class="left">FAIR <p class="cost fair-cost">$<?= $price->price_poor ?></p></div>
                <div class="right">
                    <span class="phone-name"><?= $model->id ? $model->firm->name : '' ?> <?= $model->name ?></span>
                    is in fair condition and 100% functional. It can have lots of scratches but no cracks in the screen, missing buttons or bad charge ports is allowed.
                </div>
            </label>
        </div>

        <div class="phone-desc-wrapper">

            <button class="btn-orange phoneCart<?= $single ?> phoneCartTop phoneCartTop<?= $single ?>">Pay Me Now</button>

            <?php if ((int) $option->share_bonus > 0)  { ?>
                <div class="corporate-note">
                    <?php
                    switch ($option->share_type) {
                        case 'like': echo $this->render('_like'.($single ? '_single' : ''), ['option' => $option]); break;
                        case 'share': echo $this->render('_share', ['option' => $option]); break;
                        default: echo $this->render('_business'); break;
                    }
                    ?>
                </div>
            <?php } ?>

            <p class="phone-carrier">Carrier: <span><?= $price->id ? $price->carrier->name : '' ?></span></p>

            <h2><?= $model->id ? $model->firm->name : '' ?> <?= $model->name ?></h2>

            <div class="phone-img-wrapper" style="margin-top: 12.5px;">

                <div class="phone-img">
                    <img itemprop="image" src="<?= $model->image ? 'http://ezbuyback.com/uploads/phone/thumb_'.$model->image : '' ?>" alt="Sell My <span><?= $model->id ? $model->firm->name : '' ?> <?= $model->name ?></span> Online">
                </div>

                <a href="/"><div id="phoneContinue<?= $single ?>" class="phoneContinue"><span> + add another device</span></div></a>

                <div class="clear"></div>


                <!--
                <div class="clear" style="margin:0 auto 15px;"></div>
                <div class="trustpilot-widget" data-locale="en-US" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="553042380000ff00057ed0f8" data-style-height="20px" data-style-width="100%" data-theme="light">
                <a href="https://www.trustpilot.com/review/ezbuyback.com" target="_blank">Trustpilot</a>
                </div>
                -->

            </div>

            <button class="btn-orange phoneCart<?= $single ?>">Pay Me Now</button>

        </div>

        <div class="clear"></div>

    </div>
</div>