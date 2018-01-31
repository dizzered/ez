<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
/* @var $registration \app\models\User */
/* @var $address \app\models\UserAddress */

$this->title = 'Authorization';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">

    <?= $this->render('../_signup_form', [
        'model' => $model,
        'registration' => $registration,
        'address' => $address,
        'isAjax' => false
    ]) ?>

</div>