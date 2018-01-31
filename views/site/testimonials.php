<?php

/* @var $this yii\web\View */
/* @var $model Testimonial[] */

use app\models\Testimonial;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Testimonials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-testimonials container">

    <h1 class="page-title" style="text-align: left;">Testimonials</h1>

    <?php foreach ($model as $item): ?>
        <div class="testimonial-row">
            <div class="testimonial-wrapper">
                <h3><?= stripslashes($item->text); ?></h3>
                <p><?= stripslashes($item->signature); ?></p>
            </div>
        </div>
    <?php endforeach ?>

    <?php if (count($model) == 0): ?>
        <div class="alert alert-info">
            Sorry, we were unable to find any testimonial.
        </div>
    <?php endif ?>

</div>