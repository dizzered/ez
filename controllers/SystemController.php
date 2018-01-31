<?php

namespace app\controllers;

use app\models\Cart;
use app\models\User;
use app\models\UserAddress;
use Yii;
use yii\filters\AccessControl;

/**
 *
 * @property User $user;
 * @property User $registration;
 * @property UserAddress $address;
 */

class SystemController extends BaseController
{
    public $user;
    public $address;
    public $registration;

    public function init()
    {
        $this->user = new User();
        $this->registration = new User();
        $this->address = new UserAddress();

        $this->cart = new Cart();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'register'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'restore-password'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        /** @var User $user */
        if ($this->user->load(Yii::$app->request->post()) && $this->user->login()) {
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $this->user, 'registration' => $this->registration, 'address' => $this->address]);
    }

    public function actionRegister()
    {
        /** @var User $registration */
        $this->registration->scenario = 'register';
        $this->address->load(Yii::$app->request->post());

        if ($this->registration->load(Yii::$app->request->post()) && $this->registration->save()) {
            $this->address->user_id = $this->registration->id;
            $this->address->save();

            if ($this->registration->register()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', ['model' => $this->user, 'registration' => $this->registration, 'address' => $this->address]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRestorePassword()
    {
        $this->user->scenario = 'restore';

        if ($this->user->load(Yii::$app->request->post())) {
            $user = User::findByUsername($this->user->email);

            if ($user && $user->resetPassword()) {
                Yii::$app->session->setFlash('passwordReseted');
                return $this->refresh();
            } else {
                $this->user->addError('email', 'No User with such e-mail exist. Please check you email and try again.');
            }
        }

        return $this->render('restore', ['model' => $this->user]);
    }
}
