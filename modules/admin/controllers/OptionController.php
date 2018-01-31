<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Option;
use app\models\OptionSearch;
use yii\db\Schema;
use yii\web\NotFoundHttpException;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class OptionController extends DefaultController
{

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel(1);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/option', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Option model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Option the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Option::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
