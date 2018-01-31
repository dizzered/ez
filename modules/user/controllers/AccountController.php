<?php

namespace app\modules\user\controllers;

use app\controllers\BaseController;
use app\models\Order;
use app\models\User;
use app\models\UserAddress;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/** @property User $user */

class AccountController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-address-form' => ['post'],
                    'save-address' => ['post'],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $this->user->scenario = 'profile';

        if ($this->user->load(\Yii::$app->request->post()) && $this->user->save()) {
            if ($this->user->newPassword && !$this->user->hasErrors()) {
                $this->user->resetPassword($this->user->newPassword);
            }

            \Yii::$app->session->setFlash('profileSaved');

            return $this->refresh();
        }

        return $this->render('profile', ['model' => $this->user, 'userAddresses' => $this->user->addresses]);
    }


    public function actionOrders()
    {
        $model = $this->user->orders;

        return $this->render('orders', ['model' => $model]);
    }

    public function actionOrder($id)
    {
        $model = $this->findOrderModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('paymentSaved');

            return $this->redirect(\Yii::$app->request->getReferrer());
        }

        return $this->render('order', ['model' => $model]);
    }

    public function actionPayments()
    {
        $model = $this->user->payments;

        return $this->render('payments', ['model' => $model]);
    }

    public function actionGetAddressForm()
    {
        $addressId = \Yii::$app->request->post('id', null);

        if ($addressId) {
            $model = $this->findAddressModel($addressId);
        } else {
            $model = new UserAddress();
            $model->setUser(\Yii::$app->user->identity);
        }

        \Yii::$app->session->set('userAddress', $model);

        return $this->renderAjax('@app/views/_address_form', ['newAddress' => $model]);
    }

    public function actionSaveAddress()
    {
        $model = \Yii::$app->session->get('userAddress');

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('addressSaved');
        } else {
            \Yii::$app->session->setFlash('addressNotSaved');
        }

        return $this->redirect(\Yii::$app->request->getReferrer());
    }

    public function actionDeleteAddress($id)
    {
        $this->findAddressModel($id)->delete();

        \Yii::$app->session->setFlash('addressDeleted');

        return $this->redirect(['/user/profile']);
    }

    /**
     * Finds the UserAddress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserAddress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAddressModel($id)
    {
        if (($model = UserAddress::find()->where(['id' => $id, 'user_id' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested address does not exist.');
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrderModel($id)
    {
        if (($model = Order::find()->where(['id' => $id, 'id_user' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested order does not exist.');
        }
    }
}