<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context BaseController */
/* @var $cart Cart */

use app\controllers\BaseController;
use app\models\Cart;
use app\models\Testimonial;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$context = $this->context;
$cart = $context->cart;

$checkController = function ($route) {
    if (is_array($route)) {
        $result = false;
        foreach ($route as $url) {
            if ($url === $this->context->getUniqueId()) {
                $result = true;
            }
        }
        return $result;
    } else {
        return $route === $this->context->getUniqueId();
    }
};

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="<?= Yii::$app->getHomeUrl() ?>favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon.ico" type="image/x-icon" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name.' - '.$this->title) ?></title>
    <?php $this->registerMetaTag(['name' => 'keywords', 'content' => 'sell, used device, '.$this->title]); ?>
    <?php $this->registerMetaTag(['name' => 'description', 'content' => $this->title]); ?>
    <?= $context->registerOgTags(); ?>
    <?php $this->head() ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-56188476-1', 'auto');
        ga('send', 'pageview');
    </script>

    <script>
        var baseUrl = '<?= Yii::$app->getHomeUrl() ?>';
        var phoneUrl = '';
        var isGuest = <?= Yii::$app->user->isGuest ? 'true' : 'false'?>;
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>
<script>
    FB.init({
        appId  : '1027894727234697',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true, // parse XFBML
        channelUrl : '<?= Yii::$app->getHomeUrl() ?>channel.html', // channel.html file
        oauth  : true // enable OAuth 2.0
    });

    FB.Event.subscribe('edge.create', function(href, widget) {
        updateFBLike();
    });

    FB.Event.subscribe('edge.remove', function(href, widget) {
        updateFBUnlike();
    });
</script>
<div class="wrap">
    <?php
    $navBarOptions = [
        'brandLabel' => Html::img('/img/logo_black.png'),
        'brandUrl' => Yii::$app->homeUrl,
    ];

    $admin = Yii::$app->user->can('admin') ?
        [['label' => 'admin', 'url' => ['/admin']]] :
        [];

    $logout = !Yii::$app->user->isGuest ? [['label' => 'logout', 'url' => ['/system/logout']],] : [];
    $cartLabel = 'my cart <span class="header-positions">'.
        (!$cart->isEmpty() ? '('.$cart->totalPositions().')' : '').
        '</span> <span class="header-total">'.
        (!$cart->isEmpty() ? '$'.$cart->totalCost() : '').'</span>';

    $account = [
        'label' => 'my account',
        'items' => [
            ['label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>profile', 'url' => ['/user/profile']],
            ['label' => '<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>orders', 'url' => ['/user/orders']],
            ['label' => '<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>payments', 'url' => ['/user/payments']],
            ['label' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>support', 'url' => ['/contact']],
            ['label' => '<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>logout', 'url' => ['/system/logout']],
        ]
    ];

    $navOptions = [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => ArrayHelper::merge(
            [
                Yii::$app->user->isGuest ?
                    ['label' => 'register', 'url' => ['/system/login']] :
                    $account,
                ['label' => 'how it works', 'url' => ['/site/how-it-works']],
                ['label' => 'faq', 'url' => ['/site/faq']],
                ['label' => 'contact', 'url' => ['/site/contact']],
                [
                    'label' => $cartLabel,
                    'url' => ['/cart'],
                    'active' => $checkController('cart'),
                    'options' => ['class' => 'my-cart'.(!$cart->isEmpty() ? ' header-cart-link' : '')],
                ],
            ],
            $admin
        )
    ];

    NavBar::begin(ArrayHelper::merge(
        $navBarOptions,
        [
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ]
        ]
    ));
    echo Nav::widget($navOptions);
    NavBar::end();
    ?>

    <div class="home slider-wrapper <?= 'bkgnd-'.mt_rand(1, 9); ?>">
        <div class="jk_nav_content search-wrapper">

            <h2 class="slogan">WE BUY USED SMARTPHONES, TABLETS<div class="clear" style="height:0;"><!--//--></div>AND OTHER GADGETS!</h2>

            <!-- search -->
            <div class="insidesearch">
                <div id="searchnew">
                    <div class="form">
                        <?php $form = ActiveForm::begin([
                            'action' => '/search'
                        ]) ?>
                        <input id="query" type="text" name="query" placeholder="Type your device model" />
                        <input type="submit" value="" class="bt-search" />
                        <div class="clearfix"><!--//--></div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <!-- END search -->
        </div>
    </div>

    <div id="ajaxSearch" style="display:none;">
        <div class="icon-close" id="closeSearch"></div>
        <div class="ajax-result"></div>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <?= $content ?>

    <div class="returning-container">
        <div class="container">
            <div class="page-title" style="text-align:center; margin: 0">
                <strong>Device Return Guarantee!</strong>
            </div>
            <br/>
            <p class="page-subtitle"><strong>It's OK to change your mind, we’ll ship your device back!</strong></p>
        </div>
    </div>

    <div class="easy-container">
        <div class="container">
            <h2><strong>Easy steps to get cash for your device:</strong></h2>

            <a href="<?= Yii::$app->getHomeUrl()?>how-it-works" class="easy-link">

                <div class=" easy-item">
                    <div class="easy-find"></div>
                    Get a quote!<br /><!--<span>on our site</span>-->
                </div>

                <div class=" easy-item">
                    <div class="easy-sell"></div>
                    Ship it free!<br /><!--<span>for free</span>-->
                </div>

                <div class=" easy-item">
                    <div class="easy-paid"></div>
                    Get paid!<br /><!--<span>FAST!</span>-->
                </div>

                <div class="clearfix"></div>
            </a>

        </div>
    </div>

    <?php if ($context->showTestimonials && $testimonials = Testimonial::findModels(true, 3)): ?>
        <div class="testimonials-footer">
            <div class="container">
                <div class="page-title" style="text-align:center;"><strong>Hear what our customers are saying:</strong></div>
                <div class="row">
                    <a href="<?= Yii::$app->getHomeUrl()?>testimonials">
                        <?php foreach ($testimonials as $item): ?>
                            <div class="col-md-4">
                                <div class="testimonial-wrapper">
                                    <h3><?= StringHelper::truncateWords($item->text, 17) ?></h3>
                                    <p>&mdash; <?= $item->signature ?></p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    <?php endif ?>

</div>

<footer class="footer">

    <div class="container">

        <div class="row">

            <div class="footer-content col-md-3">
                <p class="title">Website Map</p>
                <ul>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>how-it-works">How It Works</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>business-solutions">Business Solutions</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>faq">Common Questions</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>privacy-policy">Privacy Policy</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>terms-and-conditions">Terms & Conditions</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>contact">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-content col-md-3">
                <p class="title">Quick Find Links</p>
                <ul>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/apple">Sell my Apple device</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/samsung">Sell my Samsung device</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/htc">Sell my HTC device</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/lg">Sell my LG device</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/motorola">Sell my Motorola device</a></li>
                    <li><a href="<?= Yii::$app->getHomeUrl()?>phone/nokia">Sell my Nokia device</a></li>
                </ul>
            </div>

            <div class="footer-content col-md-6">
                <p class="title">Connect with us</p>
                <div id="share-buttons">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/pages/Ezbuybackcom/851025584917328" target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a>
                    <!-- Twitter -->
                    <a href="https://twitter.com/EZBUYBACKCOM" target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a>
                </div>

                <div class="copyright">
                    <p>All Trademarks, Logos and Brands are the properties of their respective owners. <br>&copy; Copyright 2013-<?= date("Y");?> -  <?= Yii::$app->name ?></p>
                </div>
            </div>

            <div class="clear"></div>

        </div>

        <div class="clear"></div>

    </div>

</footer>

<?= $this->render('@app/views/modals') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
