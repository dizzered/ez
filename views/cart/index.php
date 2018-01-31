<?php

/* @var $cart \app\models\Cart */
/* @var $shipping \app\models\Shipping[]  */
/* @var $this \yii\base\View */
/* @var $newAddress \app\models\UserAddress */

use app\models\Promo;
use app\models\User;
use app\models\UserAddress;

$this->title = 'Review Your Cart';
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
$cart = $context->cart;
?>
<div class="cart-index container">

    <?php if (Yii::$app->session->hasFlash('orderNotSaved')): ?>
        <div class="alert alert-danger">
            Error occured while order is saved. Please try again later...
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <?php if ($cart->isEmpty()): ?>
        <h1 class="page-title" style="text-align: left;">Your cart is currently empty.</h1>

        <div class="body-content">
            <h3>Please use search option on top or choose from the list of brands below:</h3>

            <p>&nbsp;</p>

            <?= $this->render('../_firms', ['showTitle' => false])?>
        </div>
    <?php else: ?>

        <?php if (!Yii::$app->user->isGuest): ?>
            <button type="submit" name="" class="bt-orange big payment_button top"><span>Complete <?= Yii::$app->name ?> Order</span></button>
        <?php endif ?>

        <h1 class="page-title cart-title" style="text-align: left;">Review Your Cart</h1>

        <div class="cart">

            <?php foreach ($cart->positions as $key => $position): ?>
                <?php /** @var \app\models\CartItem $position */?>
                <?php /** @var \app\models\Item $item  */?>
                <?php /** @var \app\models\Carrier $carrier */?>
                <?php
                $item = $position->getItem();
                $carrier = $position->getCarrier();
                ?>
                <div class="cart-item-wrapper">
                    <div class="cart-item" data-ajax="<?= $key ?>" data-id="<?= $position->id_item ?>"
                         data-carrier="<?= $position->id_carrier ?>"
                         data-state="<?= $position->condition ?>"
                         data-number="<?= $position->quantity ?>"
                         data-price="<?= $position->cost ?>">
                        <div class="td picture"><img src="<?= Yii::$app->getHomeUrl() ?>uploads/phone/thumb_<?= $item->image ?>" alt="" /></div>
                        <div class="td item-title">
                            <span class="title"><?= $item->firm->name ?> <?= $item->name ?></span>
                            <div style="height:10px;">&nbsp;</div>
                            <p>Quoted Condition: <span style="color: #0899ff;"><?= \app\models\ItemPrice::$itemConditionLabels[$position->condition] ?></span></p>
                            <p>Carrier: <span style="color: #666666;"><?= $carrier->name ?></span></p>
                        </div>
                        <div class="td price">$<?= $position->cost ?></div>
                        <div class="td count"><input type="number" name="count" class="item-count" min="1" value="<?= $position->quantity ?>"  data-price="<?= $position->cost ?>" /></div>
                        <div class="td"><a href="<?= $item->prettyLink($carrier) ?>" class="cart-edit bt-edit">edit</a></div>
                        <div class="td action-remove"><a href="<?= Yii::$app->getHomeUrl()?>cart/remove?item=<?= $key ?>" class="bt-remove"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach ?>

            <div class="total">Your Total <?= Yii::$app->name ?> Quote: <strong>$</strong><span><?= $cart->totalCost() ?></span></div>

            <div class="clear" style="height:15px;"></div>

            <?php if (Promo::isPromoAvailable($cart)): ?>
                <div class="cart-item-wrapper promo">

                    <div class="promo-left">
                        <p>Promo Code:</p>
                    </div>

                    <div class="promo-right">
                        <label for="promo">Enter Promo Code: </label> <input type="text" width="100" name="promo" id="promo" />
                        <a href="#" class="cart-edit" id="getPromo">Apply</a>
                    </div>

                    <div class="clear"></div>

                </div>
            <?php endif ?>

            <form action="<?= Yii::$app->getHomeUrl() ?>cart/complete-order" method="post" name="completeOrder">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                <input type="hidden" name="promo_type" id="promo_type" />
                <input type="hidden" name="promo_number" id="promo_number" value="" />
                <input type="hidden" name="promo_price" id="promo_price" value="0" />

                <div class="cart-item-wrapper shipping">

                    <div class="shipping-left">
                        <p>Shipping Options:</p>
                    </div>

                    <div class="shipping-right">
                        <?php foreach ($shipping as $ship): ?>
                            <div class="shipping-item">
                                <div class="custom-radio shipping-radio">
                                    <input type="radio" id="shipping_<?= $ship->id ?>" name="shipping" value="<?= $ship->id ?>" class="custom" />
                                    <label>
                                        <span><span></span></span>
                                    </label>
                                </div>
                                <div class="shipping-info">
                                    <label for="shipping_<?= $ship->id ?>">
                                    <p class="shipping-title"><?= $ship->name ?></p>
                                    <p><?= $ship->descr ?></p>
                                    </label>
                                </div>
                                <!--<div class="shipping-price">$'.$row['price'].'</div>-->
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="clear"></div>

                </div>

                <div class="clear"><!--//--></div>

                <?= $this->render('_payment', []) ?>
            </form>

            <?php if (Yii::$app->user->isGuest): ?>
                <div class="clear" style="height: 2em;"></div>

                <?= $this->render('../_signup_form', [
                    'model' => new User(),
                    'registration' => new User(),
                    'address' => new UserAddress(),
                    'isAjax' => true,
                    'isCart' => true
                ]) ?>
            <?php endif ?>

            <div class="total">Your Total <?= Yii::$app->name ?> Quote: <strong>$</strong><span><?= $cart->totalCost() ?></span></div>

            <div class="clear" style="height:20px;"></div>

            <button type="submit" name="" class="bt-orange big payment_button"><span>Complete <?= Yii::$app->name ?> Order</span></button>

            <div class="clear" style="height:40px;"></div>

            <?php if (!Yii::$app->user->getIsGuest()): ?>
                <p class="cart-item-wrapper">
                    <strong>What happens next?</strong>
                    You will receive a confirmation email within a few minutes of submitting this form. A shipping kit will then be prepared for you and shipped to the address provided. Upon receipt of the shipping kit follow the included instructions and ship the device back. Once the device is received it will be tested and payment will be issued.
                </p>

                <p class="cart-item-wrapper">
                    <strong>How can I track my order?</strong>
                    Please visit your <a href="<?= Yii::$app->getHomeUrl() ?>user/orders"><strong>order page</strong></a> to get status of your completed order.</p>
            <?php endif ?>

        </div>
    <?php endif ?>
</div>