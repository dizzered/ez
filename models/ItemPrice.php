<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Inflector;

/**
 * This is the model class for table "item_prices".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $id_carrier
 * @property double $price_excellent
 * @property double $price_good
 * @property double $price_fair
 * @property double $price_poor
 * @property double $price_broken
 * @property string $slug
 *
 * @property Item $item
 * @property Carrier $carrier
 */
class ItemPrice extends \yii\db\ActiveRecord
{
    const ITEM_CONDITION_BROKEN = 1;
    const ITEM_CONDITION_FAIR = 2;
    const ITEM_CONDITION_GOOD = 3;
    const ITEM_CONDITION_PERFECT = 4;
    const ITEM_CONDITION_EXCELLENT = 5;

    const ITEM_CONDITION_TABLE_PREFIX = 'price_';

    public static $itemConditionLabels = [
        self::ITEM_CONDITION_BROKEN => 'Broken',
        self::ITEM_CONDITION_FAIR => 'Fair',
        self::ITEM_CONDITION_GOOD => 'Good',
        self::ITEM_CONDITION_PERFECT => 'Perfect',
        self::ITEM_CONDITION_EXCELLENT => 'Excellent'
    ];

    public static $itemConditionTableLabels = [
        self::ITEM_CONDITION_BROKEN => 'price_broken',
        self::ITEM_CONDITION_FAIR => 'price_poor',
        self::ITEM_CONDITION_GOOD => 'price_fair',
        self::ITEM_CONDITION_PERFECT => 'price_good',
        self::ITEM_CONDITION_EXCELLENT => 'price_excellent'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'id_carrier'], 'required'],
            [['id_item', 'id_carrier'], 'integer'],
            [['price_excellent', 'price_good', 'price_fair', 'price_poor', 'price_broken'], 'number'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_item' => 'Item',
            'id_carrier' => 'Carrier',
            'price_excellent' => 'Price Excellent',
            'price_good' => 'Price Good',
            'price_fair' => 'Price Fair',
            'price_poor' => 'Price Poor',
            'price_broken' => 'Price Broken',
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'id_item']);
    }

    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'id_carrier']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->slug = Inflector::slug($this->item->name.'-'.$this->carrier->name);
            return true;
        }
        return false;
    }

    public static function findPriceByItem($item, $carrier)
    {
        return self::find()->where(['id_item' => $item, 'id_carrier' => $carrier])->one();
    }
}
