<?php
namespace app\actions;

use yii\base\Action;

class PageAction extends Action
{
    public function run()
    {
        return $this->controller->render(trim(\Yii::$app->request->url, '/'));
    }
}