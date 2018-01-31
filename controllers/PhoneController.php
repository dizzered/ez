<?php

namespace app\controllers;

use app\models\Carrier;
use app\models\Firm;
use app\models\Item;
use app\models\ItemPrice;
use app\models\ItemSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PhoneController extends BaseController
{
    public function actionFirm($firm)
    {
        /** @var Firm $model */
        $model = Firm::find()->where(['slug' => $firm])->one();
        if ($model) {
            $carriers = Carrier::find()->all();
            $items = $model->findItems();
            return $this->render('firm', ['model' => $model, 'carriers' => $carriers, 'items' => $items]);
        } else {
            throw new NotFoundHttpException('Sorry, we were unable to find manufacturer you are looking for.');
        }
    }

    public function actionDetails($phone)
    {
        /** @var Item $model */
        if ($model = $this->findModelBySlug($phone)) {
            return $this->render('phone', ['model' => $model['item'], 'price' => $model['price']]);
        } else {
            throw new NotFoundHttpException('Sorry, we were unable to find model you are looking for.');
        }
    }

    public function actionGetPhone()
    {
        $phoneId = Yii::$app->request->post('phoneId');
        $carrierId = Yii::$app->request->post('carrierId');

        if ($model = $this->findModelById($phoneId, $carrierId)) {
            $model['firm'] = $model['item']->firm;
            $model['carrier'] = $model['price']->carrier;
        } else {
            $model = ['item' => null, 'price' => null, 'firm' => null, 'carrier' => null];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model;

    }

    public function actionRedirect($phone, $carrier)
    {
        if ($model = $this->findModelById($phone, $carrier)) {
            return $this->redirect('/phone/'.$model['item']->firm->slug.'/'.$model['price']->slug);
        } else {
            throw new NotFoundHttpException('Sorry, we were unable to find model you are looking for.');
        }
    }

    public function actionRedirectFirm($firm)
    {
        /** @var Firm $model */
        if ($model = Firm::findOne($firm)) {
            return $this->redirect('/phone/'.$model->slug);
        } else {
            throw new NotFoundHttpException('Sorry, we were unable to find manufacturer you are looking for.');
        }
    }

    public function actionSearch()
    {
        $query = Yii::$app->request->post('query');
        $items = ItemSearch::findItems($query);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('../_items', ['carriers' => null, 'items' => $items]);
        } else {
            $carriers = Carrier::find()->all();
            return $this->render('../search', ['carriers' => $carriers, 'items' => $items, 'query' => $query]);
        }
    }

    protected function findModelBySlug($slug)
    {
        /** @var ItemPrice $price */
        $price = ItemPrice::find()->where(['slug' => $slug])->one();
        if ($price) {
            return ['item' => $price->item, 'price' => $price];
        }

        return null;
    }

    protected function findModelById($id, $carrier)
    {
        /** @var ItemPrice $price */
        $price = ItemPrice::findPriceByItem($id, $carrier);
        if ($price) {
            return ['item' => $price->item, 'price' => $price];
        }

        return null;
    }
}
