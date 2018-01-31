<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 30.11.2015
 * Time: 17:43
 */

namespace app\controllers;

use app\models\Cart;
use app\models\ItemPrice;
use app\models\Order;
use app\models\OrderItem;
use app\models\Promo;
use app\models\Shipping;
use app\models\User;
use app\models\UserAddress;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

/** @property Cart $cart */

class CartController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'complete-order' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $shipping = Shipping::find()->where(['svisibility' => 1])->all();

        return $this->render('index', [
            'shipping' => $shipping
        ]);
    }

    public function actionAddItem()
    {
        $phoneId = Yii::$app->request->post('phoneId');
        $carrierId = Yii::$app->request->post('carrierId');
        $condition = Yii::$app->request->post('condition');
        $cost = Yii::$app->request->post('cost');

        $this->cart->add($phoneId, $carrierId, $condition, $cost);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'totalPositions' => $this->cart->totalPositions(),
            'totalCost' => $this->cart->totalCost()
        ];
    }

    public function actionUpdateItemQty()
    {
        $positionId = Yii::$app->request->post('positionId');
        $value = Yii::$app->request->post('value');

        $this->cart->updatePosition($positionId, ['quantity' => $value]);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'totalPositions' => $this->cart->totalPositions(),
            'totalCost' => $this->cart->totalCost()
        ];
    }

    public function actionApplyPromo()
    {
        $code = Yii::$app->request->post('code');

        Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var Promo $model */
        if ($model = Promo::findPromoByCode($code)) {
            $promoTotal = $model->calculatePromoTotal($this->cart);
            return [
                'totalPositions' => $this->cart->totalPositions(),
                'totalCost' => $this->cart->totalCost() + $promoTotal,
                'promoType' => $model->type,
                'promoTotal' => $promoTotal,
                'promoCost' => $model->number,
                'error' => ''
            ];
        } else {
            return [
                'totalPositions' => $this->cart->totalPositions(),
                'totalCost' => $this->cart->totalCost(),
                'error' => 'Promo code was not found.'
            ];
        }
    }

    public function actionRemove($item)
    {
        $this->cart->remove($item);

        return $this->redirect('/cart');
    }

    public function actionUpdateItem()
    {
        $positionId = Yii::$app->request->post('positionId');
        $condition = Yii::$app->request->post('condition');

        $position = $this->cart->getPosition($positionId);
        if ($position) {
            /** @var ItemPrice $price */
            $price = ItemPrice::findPriceByItem($position->id_item, $position->id_carrier);
            if ($price) {
                $this->cart->updatePosition($positionId, ['condition' => $condition, 'cost' => $price->{ItemPrice::$itemConditionTableLabels[$condition]}]);
            }
        }
    }

    public function actionLoginUser()
    {
        $this->user = new User();

        if ($this->user->load(Yii::$app->request->post()) && $this->user->login()) {
            echo '1';
        } else {
            echo json_encode($this->user->getErrors());
        }
    }

    public function actionRegisterUser()
    {
        $registration = new User();
        $address = new UserAddress();

        $registration->scenario = 'register';
        $address->load(Yii::$app->request->post());

        if ($registration->load(Yii::$app->request->post()) && $registration->save()) {
            $address->user_id = $registration->id;
            $address->save();

            if ($registration->register()) {
                echo $address->id;
                exit;
            }
        }

        echo json_encode($registration->getErrors());
    }

    public function actionCompleteOrder()
    {
        $order = new Order();

        $order->id_user = $this->user->id;
        $order->id_shipping = Yii::$app->request->post('shipping');
        $order->order_status = Order::ORDER_STATUS_PENDING;
        $order->payment_type = Yii::$app->request->post('payment_type');
        $order->paypal = Yii::$app->request->post('emailPaypal');
        $order->payment_check = Yii::$app->request->post('check');
        $order->promo_sum = Yii::$app->request->post('promo_price');
        $order->order_date = date('Y-m-d H:i:s');

        if ($address = Yii::$app->request->post('address')) {
            $order->id_address = $address;
        } else {
            foreach ($this->user->addresses as $address)
            {
                $order->id_address = $address->id;
                break;
            }
        }

        /** @var Shipping $shipping */
        $shipping = Shipping::findOne($order->id_shipping);
        $order->final_sum = $this->cart->totalCost() + $shipping->price;

        $transaction = Yii::$app->db->beginTransaction();

        $orderItemsErrors = false;

        if ($order->save()) {
            $order->order_number = Order::ORDER_NUMBER_PREFIX.$order->id;
            $order->save();

            foreach ($this->cart->positions as $position)
            {
                $orderItem = new OrderItem();
                $orderItem->copyFromCartPosition($position);
                $orderItem->order_id = $order->id;

                if ($orderItem->save()) {
                    unset($orderItem);
                } else {
                    $orderItemsErrors = true;
                }
            }
        }

        if ($order->hasErrors() || $orderItemsErrors) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('orderNotSaved');

            return $this->redirect('/cart');
        }

        $transaction->commit();
        $this->cart->clear();
        $order->sendOrderEmail();

        return $this->redirect('/cart/complete/'.$order->id);
    }

    public function actionComplete($id)
    {
        $model = Order::findOne($id);
        return $this->render('complete', ['model' => $model]);
    }
}