<?php
/* @var $models \app\models\Firm[] */
$models = \app\models\Firm::findModels();
$showTitle = isset($showTitle) ? $showTitle : true;
?>
<?php if ($showTitle): ?>
    <h2 class="page-title" style="text-align:center">What else would you like to sell today?</h2>
<?php endif ?>

<div class="brands elem-container" style="margin-top:20px;">
    <?php foreach ($models as $model): ?>
        <a href="<?= Yii::$app->getHomeUrl()?>phone/<?= $model->slug ?>" class="elem">
            <img src="<?= Yii::$app->getHomeUrl()?>uploads/firm/thumb_<?= $model->image?>" alt="<?= $model->name ?>" />
            <br />
            <?= $model->name ?>
        </a>
    <?php endforeach ?>
    <div class="clearfix"><!--//--></div>
</div>
