<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "item_firm".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $svisibility
 * @property string $slug
 *
 * @property Item[] $items
 */
class Firm extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => false,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_firm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['svisibility'], 'integer'],
            [['name', 'image', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'file' => 'Image',
            'svisibility' => 'Visible',
        ];
    }

    public function getItems()
    {
        return $this->hasMany(Item::class, ['id_firm' => 'id']);
    }

    public function findItems()
    {
        return (new \yii\db\Query())
            ->select('items.*, carrier.name AS carrier_name, carrier.id AS id_carrier, item_prices.price_good')
            ->from('items')
            ->join('INNER JOIN', 'item_prices', 'item_prices.id_item = items.id')
            ->join('INNER JOIN', 'carrier', 'carrier.id = item_prices.id_carrier')
            ->andWhere(['items.id_firm' => $this->id])
            ->andWhere(['items.svisibility' => 1])
            ->orderBy(['item_prices.price_good' => SORT_DESC])
            ->all();
    }

    public static function findModels()
    {
        return self::find()->where(['svisibility' => 1])->orderBy(['name' => SORT_ASC])->all();
    }
}
