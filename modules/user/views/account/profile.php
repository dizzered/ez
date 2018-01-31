<?php
/** @var User $model */
/** @var UserAddress[] $userAddresses */

use app\models\User;
use app\models\UserAddress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-profile container">

    <?php if (Yii::$app->session->hasFlash('profileSaved')): ?>
        <div class="alert alert-success">
            Account details was successfully saved.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <?php if (Yii::$app->session->hasFlash('addressSaved')): ?>
        <div class="alert alert-success">
            Delivery address was successfully saved.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <?php if (Yii::$app->session->hasFlash('addressNotSaved')): ?>
        <div class="alert alert-danger">
            Error occured while delivery address is saved.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <?php if (Yii::$app->session->hasFlash('addressDeleted')): ?>
        <div class="alert alert-warning">
            Delivery address was successfully deleted.
        </div>
        <p>&nbsp;</p>
    <?php endif ?>

    <?php $form = ActiveForm::begin([
        'id' => 'account-details',
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>

    <h1 class="page-title" style="text-align: left;">Account Details</h1>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'email')->textInput(['disabled' => true]) ?>

            <?= $form->field($model, 'first_name') ?>

            <?= $form->field($model, 'last_name') ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class,
                [
                    'mask' => ['99-999-9999', '999-999-9999']
                ]
            ) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'newPassword') ?>

            <?= $form->field($model, 'confirmNewPassword')->label('Confirm') ?>

            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-8">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-warning btn-lg pull-right', 'id' => 'editProfile']) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="clear"></div>

    <hr>

    <?php ActiveForm::end(); ?>

    <div style="height: 2em;"></div>

    <h1 class="page-title pull-left" style="text-align: left;margin-right: 15px; margin-bottom: 20px">My Shipping Address Book <?= count($userAddresses) ? '<sup class="badge">'.count($userAddresses).'</sup>' : ''; ?></h1>

    <div class="pull-left"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New', ['#'], ['class' => 'btn btn-success btn-md btn-add-address'])?></div>

    <div class="clear" style="height: 2em;"></div>

    <div class="row">
        <?php foreach ($userAddresses as $address): ?>
            <?php /** @var UserAddress $address */?>
            <div class="col-md-3">
                <div class="address-cell">
                    <i class="fa fa-map-marker fa-2x pull-left"></i>
                    <p class="pull-left"><?= $address->getFullAddress(false, '<br>', true) ?></p>
                    <div class="clear"></div>
                    <div class="address-cell-action" data-address="<?= $address->id ?>">
                        <span class="glyphicon glyphicon-pencil btn-edit-address" aria-hidden="true"></span>
                        <a href="<?= Yii::$app->getHomeUrl() ?>user/delete-address?id=<?= $address->id ?>" data-confirm="Are you sure you want to delete?">
                            <span class="glyphicon glyphicon-trash btn-delete-address" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>

<div class="clear"></div>
