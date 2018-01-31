<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

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

AdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name.' - Administration') ?></title>
    <?php $this->head() ?>
    <script>
        var baseUrl = '<?= Yii::$app->getHomeUrl() ?>';
        var phoneUrl = '';
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('/img/logo_black.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Users', 'url' => ['/admin/user'], 'active' => $checkController('admin/user')],
            [
                'label' => 'Orders',
                'items' => [
                    ['label' => 'Orders', 'url' => '/admin/order'],
                    ['label' => 'Statuses', 'url' => '/admin/order-status'],
                    ['label' => 'Emails', 'url' => '/admin/order-email'],
                ],
                'active' => $checkController(['admin/order', 'admin/order-status', 'admin/order-email'])
            ],
            ['label' => 'Firms', 'url' => ['/admin/firm'], 'active' => $checkController('admin/firm')],
            ['label' => 'Carriers', 'url' => ['/admin/carrier'], 'active' => $checkController('admin/carrier')],
            [
                'label' => 'Devices',
                'items' => [
                    ['label' => 'Devices', 'url' => ['/admin/item']],
                    ['label' => 'Export', 'url' => ['/admin/item/export']]
                ],
                'active' => $checkController(['admin/item', 'admin/item/export'])
            ],
            ['label' => 'Shipping', 'url' => ['/admin/shipping'], 'active' => $checkController('admin/shipping')],
            ['label' => 'Promos', 'url' => ['/admin/promo'], 'active' => $checkController('admin/promo')],
            ['label' => 'Testimonials', 'url' => ['/admin/testimonial'], 'active' => $checkController('admin/testimonial')],
            ['label' => 'Options', 'url' => ['/admin/option'], 'active' => $checkController('admin/option')],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container" style="margin-top: 60px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
        } ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name.' '.date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?= $this->render('@app/views/modals') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
