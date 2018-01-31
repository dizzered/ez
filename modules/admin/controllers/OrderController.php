<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends DefaultController
{
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model for print.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = false;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setExpirationDate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $send = Yii::$app->request->post('order_send');
            if ($send) {
                $model->sendEmail();
            }
            return $this->redirect(['/admin/order/update?id='.$model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/order']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendMessage()
    {
        $subject = Yii::$app->request->post('subject');
        $message = Yii::$app->request->post('message');
        $recipient = Yii::$app->request->post('recipient');

        $mail = Yii::$app->mailer->compose('simple', ['message' => $message]);

        $mail->setFrom(Yii::$app->params['adminEmail'])->setTo($recipient)->setSubject($subject);

        if ($mail->send()) {
            echo 'Message was successfuly sended.';
        } else {
            echo 'Error occured while sending e-mail.';
        }
    }

    public function actionSetBoxMailed()
    {
        $id = Yii::$app->request->post('id');

        $model = $this->findModel($id);
        $model->order_status = Order::ORDER_STATUS_BOX_MAILED;

        if ($model->save()) {
            $model->sendEmail();
        }
    }
}
