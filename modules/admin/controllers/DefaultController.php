<?php

namespace app\modules\admin\controllers;

use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect('admin/order');
    }

    /**
     * @param ActiveRecord $model
     * @param string $path
     * @param boolean $save
     */
    protected function saveImage($model, $path, $save = true)
    {
        $model->file = UploadedFile::getInstance($model, 'file');
        if ($model->file) {
            $model->file->saveAs('uploads/'.$path.'/thumb_' . $model->id . '.' . $model->file->extension);
            $model->image = $model->id . '.' . $model->file->extension;
            if ($save) {
                $model->save();
            }
        }
    }
}
