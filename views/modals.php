<?php

/* @var $this yii\web\View */

use app\models\Item;
use app\models\ItemPrice;
use yii\bootstrap\Modal;
use yii\helpers\Html;

Modal::begin([
    'header' => '<h4>Please wait</h4>',
    'closeButton' => false,
    'size' => 'modal-sm',
    'options' => [
        'id' => 'pleaseWait',
        'data-keyboard' => 'false',
        'data-backdrop' => 'static'
    ]
]);

echo 'Request is processing... <span class="glyphicon glyphicon-refresh glyphicon-animate"></span>';

Modal::end();

Modal::begin([
    'header' => '<h4>Message</h4>',
    'footer' => Html::button('<i class="glyphicon glyphicon-remove"></i> Close', ['class' => 'btn btn-default', 'id' => 'closeMessageModal']),
    'options' => [
        'id' => 'messageModal',
    ]
]);

echo '<div id="messageContent"></div>';

Modal::end();

/*
 * Modal for user address form
 */
Modal::begin([
    'header' => '<h4></h4>',
    'footer' => Html::button('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary', 'id' => 'saveAddress']).
        Html::button('<i class="glyphicon glyphicon-ban-circle"></i> Cancel', ['class' => 'btn btn-default', 'id' => 'closeAddressModal']),
    'options' => [
        'id' => 'addressModal',
    ]
]);

echo '<div id="addressContent"></div>';

Modal::end();

/*
 * Add phone dialog
 */
Modal::begin([
    'header' => '<h4>Select Condition:</h4>',
    'options' => [
        'id' => 'addPhoneDlg',
    ]
]);

echo $this->render('phone/_dialog', ['model' => new Item(), 'price' => new ItemPrice(), 'single' => false]);

Modal::end();

/*
 * Edit phone dialog
 */
Modal::begin([
    'header' => '<h4>Select Condition:</h4>',
    'options' => [
        'id' => 'editPhoneDlg',
    ]
]);

echo $this->render('phone/_edit_dialog', ['model' => new Item(), 'price' => new ItemPrice(), 'single' => false]);

Modal::end();