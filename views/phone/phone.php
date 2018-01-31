<?php

/* @var $model \app\models\Item */
/* @var $price \app\models\ItemPrice */
/* @var $this yii\web\View */

$this->title = 'Sell Your Used '.$model->firm->name.' '.$model->name.' Device!';
$this->params['breadcrumbs'][] = ['label' => $model->firm->name, 'url' => [$model->firm->slug]];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="phone-index container">

    <h1 class="page-title">Sell My <span><?= $model->firm->name ?> <?= $model->name ?></span> Online</h1>

    <div class="body-content">

        <p class="cart-item-wrapper phone-descr">See how much cash you'll receive on buyback for your <?= $model->firm->name ?> <?= $model->name ?> by selecting it's condition below. <strong>Your quote is guaranteed for 14 Days. Sell now to get the highest possible price!</strong></p>

        <?= $this->render('_dialog', ['model' => $model, 'price' => $price, 'single' => true])?>

        <?php if ($model->descr): ?>
            <p class="cart-item-wrapper phone-descr"><?= stripslashes($model->descr) ?></p>
        <?php endif ?>

        <?= $this->render('../_firms')?>

    </div>

    <script>
        var phoneUrl = '<?= Yii::$app->request->getHostInfo().Yii::$app->request->url ?>';
    </script>
</div>