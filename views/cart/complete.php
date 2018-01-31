<?php
/** @var Order $model  */

use app\models\Order;

$this->title = 'Order #'.$model->order_number.' Complete';
$this->params['breadcrumbs'][] = ['label' => 'My Profile', 'url' => ['user/profile']];
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['user/orders']];
$this->params['breadcrumbs'][] = ['label' => 'Order #'.$model->order_number, 'url' => ['user/order/'.$model->id]];

?>
<div class="cart-complete-index container">
    <h1 class="page-title" style="text-align: left;">Thank you very much!</h1>

    <h3>Your order number is <strong style="font-size: 1.4em;">#<?= $model->order_number ?></strong></h3>

    <p>&nbsp;</p>

    <h3 style="line-height: 1.5;"><strong>What happens next?</strong> You will receive a confirmation email within a few minutes. A shipping kit will then be prepared for you and shipped to the address provided. Upon receipt of the shipping kit follow the included instructions and ship the device back. Once the device is received it will be tested and payment will be issued.</h3>

    <p>&nbsp;</p>

    <p>For questions regarding your order, please email us at <a href="mailto:<?= Yii::$app->params['adminEmail'] ?>"><?= Yii::$app->params['adminEmail'] ?></a></p>

    <p>&nbsp;</p>

    <p>Our team takes pride in the opportunity to work with you.</p>

    <p>Thank you!</p>

    <p>The <?= Yii::$app->name ?> Team</p>

    <div class="clear"><!--//--></div>

    <!--<iframe src="https://sellmymobile.reliatrk.com/p.ashx?a=119&e=159&t=<?= $model->order_number ?>&p=<?= $model->final_sum ?>" height="1" width="1" frameborder="0"></iframe>-->
</div>