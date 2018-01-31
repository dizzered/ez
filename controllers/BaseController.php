<?php

namespace app\controllers;

use app\models\Cart;
use app\models\User;
use Yii;
use yii\web\Controller;

/** @property Cart $cart */
/** @property User $user */

class BaseController extends Controller
{
    public $pageOgTitle = '';
    public $pageOgDesc = '';
    public $pageOgImage = '';

    public $showTestimonials = true;

    public $cart;
    public $user;

    public $memoryFilterList = [
        'all' => 'All',
        '8gb' => '8 GB',
        '16gb' => '16 GB',
        '32gb' => '32 GB',
        '64gb' => '64 GB',
        '128gb' => '128 GB'
    ];

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function init()
    {
        $this->cart = new Cart();

        $this->user = \Yii::$app->user->identity;
    }

    public function registerOgTags()
    {
        $output = '';

        if ($this->pageOgTitle) {
            $output .= '<meta property="og:title" content="'.$this->pageOgTitle.'" />'.PHP_EOL.'
                <meta itemprop="name" content="'.$this->pageOgTitle.'">'.PHP_EOL;
        }

        if ($this->pageOgDesc) {
            $output .= '<meta property="og:description" content="'.$this->pageOgDesc.'" />'.PHP_EOL.'
                <meta itemprop="description" content="'.$this->pageOgDesc.'">'.PHP_EOL;
        }

        if ($this->pageOgImage) {
            $output .= '<meta property="og:image" content="'.$this->pageOgImage.'" />'.PHP_EOL.'
                <meta itemprop="image" content="'.$this->pageOgImage.'">'.PHP_EOL;
        }

        return $output;
    }
}
