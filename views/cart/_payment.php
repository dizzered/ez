<?php
/* @var $user \app\models\User */
/* @var $newAddress \app\models\UserAddress */
?>

<div class="cart-item-wrapper payment">

    <div class="payment-left">
        <p>Payment Options:</p>
        <span>CHOOSE <span style="color:#ff8c00;">PAYPAL</span> FOR FASTEST PAYMENT!</span>
    </div>

    <div class="payment-choose">
        <div class="custom-radio payment-radio">
            <input type="radio" name="payment_type" value="0" checked class="custom" id="paypal" />
            <label>
                <span><span></span></span>
            </label>
        </div>
        <div class="payment-info first"><label for="paypal"><img src="/img/icon_paypal.png" /></label></div>
        <div class="custom-radio payment-radio">
            <input type="radio" name="payment_type" value="1" class="custom" id="check" />
            <label>
                <span><span></span></span>
            </label>
        </div>
        <div class="payment-info"><label for="check">Check Payment:</label></div>

        <div class="clear payment-padding"></div>

        <div class="paypal payment-note">
            <p><strong><span style="color:#ff8c00;">Paypal is the quickest way to receive payment for your device.</span></strong></br></br></p>
            <p>Please make sure your PayPal account is Verified for fast processing.</p>
        </div>

        <div class="check payment-note" style="display:none;">
            <p><strong><span style="color:#ff8c00;">Please choose our Paypal payment option for faster payment.</span></strong></br></br></p>
            <p>Check payment will take about 10 business days to process.</p>
        </div>

    </div>

    <div class="payment-fields">

        <div class="paypal payment-inputs">

            <p>Your PayPal Email:<br />
                <input type="text" name="emailPaypal" id="emailPaypal" value="" /></p>

            <p>&nbsp;</p>

            <p>Confirm PayPal Email:<br />
                <input type="text" name="confirm_email" id="confirm_email" value="" /></p>

        </div>

        <div class="check payment-inputs" style="display:none;">

            <p>Make check payable to :<br />
                <input type="text" name="check" value="" /></p>

            <p>&nbsp;</p>

            <?php if (!Yii::$app->user->getIsGuest()): ?>

                <p>Verify your check delivery address:<br />
                    <select name="address" id="cartAddress">
                        <?php $user = Yii::$app->user->identity ?>
                        <?php foreach ($user->addresses as $address): ?>
                            <?php /** @var \app\models\UserAddress $address */?>
                            <option value="<?= $address->id ?>"><?= $address->getFullAddress(false, ', ', true) ?></option>
                        <?php endforeach ?>

                        <option value="0">+ Add New</option>
                    </select>
                </p>
            <?php else: ?>
                <input type="hidden" name="address" value="0" />
            <?php endif ?>

        </div>

    </div>

    <div class="clear"></div>

</div>

<div class="clear"></div>
