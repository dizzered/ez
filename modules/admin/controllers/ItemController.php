<?php

namespace app\modules\admin\controllers;

use app\models\ItemPrice;
use Yii;
use app\models\Item;
use app\models\ItemSearch;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends DefaultController
{

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveImage($model, 'phone');
            $model->setPrices(Yii::$app->request->post('ItemPrice'));
            return $this->redirect(['/admin/item']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveImage($model, 'phone');
            $model->setPrices(Yii::$app->request->post('ItemPrice'));
            return $this->redirect(['/admin/item']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/item']);
    }

    public function actionExport()
    {
        $sql = "
            SELECT
                f.id AS firm_id,
                c.id AS carrier_id,
                i.id AS item_id,
                f.name AS firm_name,
                c.name AS carrier_name,
                i.name AS item_name,
                ip.price_good AS price_perfect,
                ip.price_fair AS price_good,
                ip.price_poor AS price_fair
            FROM item_prices ip
            JOIN items i ON i.id = ip.id_item AND i.svisibility = 1
            JOIN item_firm f ON f.id = i.id_firm
            JOIN carrier c ON c.id = ip.id_carrier
            WHERE ip.price_poor > 0 AND ip.price_good > 0 AND ip.price_fair > 0
            ORDER BY f.name  ASC, c.name ASC, i.name ASC
        ";

        $result = Yii::$app->db->createCommand($sql)->queryAll();

        $filename = "website_data_" . date('Ymd') . ".xls";
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header("Content-Type: application/vnd.ms-excel");

        $data = [];
        foreach ($result as $row)
        {
            $dd = explode("- ", $row['carrier_name']);
            if (isset($dd[1]))
            {
                $carr_name = $dd[1];
            }
            else
            {
                $carr_name = $row['carrier_name'];
            }
            $carr_name = preg_replace("/[^0-9a-z]/i", "", $carr_name);

            $generate_link = $row['firm_name']."_".$carr_name."_".$row['item_name'].".html";
            $generate_link = str_replace(" ", "_", $generate_link);
            $generate_link = urlencode($generate_link);

            $data[] = array(
                'model_name' => $row['firm_name'].' '.$row['item_name'].' '.$row['carrier_name'],
                'price_perfect' => $row['price_perfect'],
                'price_good' => $row['price_good'],
                'price_fair' => $row['price_fair'],
                'link' => \Yii::$app->request->getHostInfo().'/phones/'.$row['item_id'].'/'.$row['carrier_id'].'/'.$generate_link
            );
        }

        $flag = false;
        $file_output = '';
        foreach ($data as $item)
        {
            if(!$flag) {
                // display field/column names as first row
                $file_output .= implode("\t", array_keys($item)) . "\r\n";
                $flag = true;
            }
            array_walk($item, [$this, 'cleanData']);
            $file_output .= implode("\t", array_values($item)) . "\r\n";
        }

        echo $file_output;
    }

    private function cleanData(&$str)
    {
        // escape tab characters
        $str = preg_replace("/\t/", "\\t", $str);

        // escape new lines
        $str = preg_replace("/\r?\n/", "\\n", $str);

        // convert 't' and 'f' to boolean values
        if($str == 't') $str = 'TRUE';
        if($str == 'f') $str = 'FALSE';

        // force certain number/date formats to be imported as strings
        if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
            $str = "'$str";
        }

        // escape fields that include double quotes
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSlugPrice()
    {
        set_time_limit(0);
        $prices = ItemPrice::find()->all();
        $deleteed = $updated = 0;
        foreach ($prices as $price)
        {
            /** @var ItemPrice $price */

            $delete = [];
            foreach (ItemPrice::$itemConditionTableLabels as $val)
            {
                if ($price->$val == 0) {
                    $delete[] = 1;
                }
            }

            if (count($delete) == count(ItemPrice::$itemConditionTableLabels)) {
                $price->delete();
                ++$deleteed;
            } else {
                if ($price->item && $price->carrier) {
                    $price->save();
                    ++$updated;
                } else {
                    $price->delete();
                    ++$deleteed;
                }
            }
        }
        echo '<p>Deleted: '.$deleteed.'</p>';
        echo '<p>Updated: '.$updated.'</p>';
    }
}
