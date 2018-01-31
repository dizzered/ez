<?php

use app\models\Order;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name . ' - Printing') ?></title>
        <?php $this->head() ?>
        <?php $this->registerCssFile('/css/print.css') ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <nav class="navbar">
        <?= Html::img('/img/logo_black.png') ?>
    </nav>

    <div class="order-print">

        <h3 style="text-transform:none; margin-bottom:20px;">Its Time to Send in your Device and Get Cash!</h3>

        <p>&nbsp;</p>

        <p>&nbsp;</p>


        <dl class="dl-horizontal">
            <dt class="round-REMOVED">PREPARE<br>YOUR DEVICE</dt>
            <dd>
                <p>Get cash faster and avoid delays by following these quick steps:</p>
                <ul>
                    <li><strong>Turn off "Find My iPhone"</strong><br>
                        On you iPhone go to <strong>Settings > iCloud </strong> and switch off "FIND MY IPHONE"
                    </li>
                    <!--<li><strong>Lorem ipsum dolor sit amet</strong><br>
                        Consectetur adipiscing elit integer molestie lorem at massa.
                    </li>-->
                </ul>
            </dd>
        </dl>
        <div style="clear:both;"></div>
        <p>&nbsp;</p>

        <dl class="dl-horizontal">
            <dt class="round-REMOVED">SHIP<br>FOR FREE</dt>
            <dd>
                <p>You have all the materials to ship your device!</p>
                <ul>
                    <li><strong>Place your device in the secure bag</strong><br>

                    </li>
                    <li><strong>Insert the bubble bag inside the pre-paid mailer and seal it shut</strong><br>

                    </li>
                    <li><strong>Drop the package off at your nearest mail box or US Post Office</strong><br>

                    </li>
                </ul>
            </dd>
        </dl>
        <div style="clear:both;"></div>

        <p>&nbsp;</p>

        <p>&nbsp;</p>


        <h3>Order
            <small>#<?= $model->order_number ?></small>
        </h3>

        <h3>Order Date:
            <small><?php echo date('m/d/Y', strtotime($model->order_date)); ?></small>
        </h3>

        <h3 class="pull-left">Your Cash Offer <strong> $<?php echo($model->final_sum + $model->promo_sum); ?> </strong></h3>

        <?= $model->promo_sum ? '<h3 class="pull-right"><small>[including promo: $' . $model->promo_sum . ']</small></h3>' : ''; ?>

        <div style="clear:both;"></div>

        <div class="panel panel-primary">
            <div class="panel-body">
                <?= $this->render('_items', ['model' => $model]) ?>
            </div>
        </div>

        <p>&nbsp;</p>

        <?php if ($model->address): ?>
            <address class='pull-left'>
                <strong><?= $model->user->getFullName() ?></strong>
                <br>
                <?= $model->address->getFullAddress(false, '<br />') ?>
            </address>

            <div class="pull-right">
                <p><?= $model->payment_type == Order::ORDER_PAYMENT_TYPE_PAYPAL ? "We'll make payment to your PayPal account:" : "We'll make your check out to:" ?></p>
                <h4><?= $model->payment_type == Order::ORDER_PAYMENT_TYPE_PAYPAL ? $model->paypal : $model->payment_check ?></h4>
            </div>
        <?php else: ?>
            <strong><?= $model->user->getFullName() ?></strong><h4 class='pull-left'>Address was removed</h4>
        <?php endif ?>

        <div style="clear: both;"></div>

    </div>

    <?php $this->endBody() ?>
    </body>

</html>

<script>
    window.print();
</script>

<?php $this->endPage() ?>