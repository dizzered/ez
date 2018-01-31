<?php
$this->title = 'We have an easy way for you to sell!';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-page container">

    <h1 class="page-title" style="margin-bottom: 20px;"><?= $this->title ?></h1>

    <p class="cart-item-wrapper phone-descr"><strong>You can sell your iPhone, Samsung Galaxy or Note, LG G4, G3 or G2, HTC M8 or M9 or any number of other cell phones and tablets quickly and easily today.</strong></p>

    <div class="page-title">Tap each circle to learn more:</div>

    <div id="hiwTabs">

        <ul>
            <li class="step-1"><a href="#step-1"><span class="big-title"></span><div></div><span class="big-title">Get a quote!</span><br /><!--<span class="small-title">on our site</span>--></a></li>
            <li class="step-2"><a href="#step-2"><span class="big-title"></span><div></div><span class="big-title">Ship it free!</span><br /><!--<span class="small-title">for free</span>--></a></li>
            <li class="step-3"><a href="#step-3"><span class="big-title"></span><div></div><span class="big-title">Get paid!</span><br /><!--<span class="small-title">FAST</span>--></a></li>
        </ul>

        <div id="step-1">
            <h3>Get a quote!</h3>

            <p>Search <a href="<?= Yii::$app->getHomeUrl() ?>"><?= Yii::$app->name ?></a> to find and select your device. We'll show you the best offer available for your device based on it's condition. Add as many devices to the cart as you wish by clicking Pay Me Now button. Fill out small registration form and complete your order!</p>
        </div>

        <div id="step-2">
            <h3>Ship it free!</h3>
            <p>
                Accept our cash offer and we'll send you a pre-paid shipping label or box with tracking included. There is no hassle to ship and no hidden costs to sell. Simply place your device in a box and drop it off at any USPS collection stations.<BR><BR></p>
        </div>

        <div id="step-3">
            <h3>Get paid!</h3>
            <p>Choose PayPal or check. We will issue payment within 5 business days of receiving your device. For your peace of mind, we send you email updates every step of the way.<BR><BR></p>
        </div>

    </div>

    <div class="clear" style="height:50px;"><!--//--></div>

    <div class="page-title">Please choose your device below and get paid fast!</div>

    <?= $this->render('../_firms', ['showTitle' => false])?>

</div>