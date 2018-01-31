<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\OrderEmail;
use app\models\OrderEmailSearch;
use yii\web\NotFoundHttpException;

/**
 * OrderEmailController implements the CRUD actions for OrderEmail model.
 */
class OrderEmailController extends DefaultController
{
    /**
     * Lists all OrderEmail models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset($_POST['OrderEmail'])) {
            $model = $this->findModel($_POST['OrderEmail']['id']);
            $model->load($_POST);
            $model->save();
            return $this->redirect(['/admin/order-email']);
        }

        $searchModel = new OrderEmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/order/email/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OrderEmail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderEmail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/order-email']);
        } else {
            return $this->render('/order/email/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrderEmail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/order-email']);
    }

    /**
     * Finds the OrderEmail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderEmail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderEmail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
