<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "promo".
 *
 * @property integer $promo_id
 * @property string $code
 * @property string $type
 * @property integer $number
 * @property string $expiration_date
 * @property string $group
 * @property string $items
 */
class Promo extends \yii\db\ActiveRecord
{
    public $itemsArray = [];

    const PROMO_TYPE_PERCENTAGE = 'percent';
    const PROMO_TYPE_DEVICE = 'number';

    public static $promoTypeLabels = [
        self::PROMO_TYPE_PERCENTAGE => 'Percent',
        self::PROMO_TYPE_DEVICE => 'Per Device'
    ];

    const PROMO_GROUP_ALL = 'all';
    const PROMO_GROUP_FIRM = 'firm';
    const PROMO_GROUP_DEVICE = 'device';

    public static $promoGroupLabels = [
        self::PROMO_GROUP_ALL => 'All devices',
        self::PROMO_GROUP_FIRM => 'Firms',
        self::PROMO_GROUP_DEVICE => 'Devices'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'number', 'group'], 'required'],
            [['number'], 'integer'],
            [['expiration_date'], 'date', 'format' => 'yyyy-mm-dd'],
            [['items'], 'string'],
            [['code'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 16],
            [['group'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'promo_id' => 'Promo ID',
            'code' => 'Code',
            'type' => 'Type',
            'number' => 'Amount',
            'expiration_date' => 'Expiration Date',
            'group' => 'Group',
            'items' => 'Items',
        ];
    }

    public function afterFind()
    {
        if ($this->items) {
            $this->itemsArray = Json::decode($this->items, true);
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->group != Promo::PROMO_GROUP_ALL) {
                $this->itemsArray = Yii::$app->request->post($this->group);
                $this->items = Json::encode($this->itemsArray);
            }

            return true;
        }
        return false;
    }

    /** @param Cart $cart */
    public static function isPromoAvailable($cart)
    {
        $result = false;
        $active = self::getActive();

        /** @var Promo $promo */
        foreach ($active as $promo)
        {
            if ($promo->group == self::PROMO_GROUP_ALL) {
                $result = true;
                break;
            } else {
                /** @var CartItem $position */
                foreach ($cart->positions as $position)
                {
                    switch ($promo->group) {
                        case self::PROMO_GROUP_DEVICE: $result = in_array($position->id_item, $promo->itemsArray); break;
                        case self::PROMO_GROUP_FIRM: $result = in_array($position->item->firm->id, $promo->itemsArray); break;
                    }
                }

                if ($result) break;
            }
        }

        return $result;
    }

    public static function getActive()
    {
        return self::find()->where('expiration_date IS NULL OR expiration_date >= NOW()')->all();
    }

    public static function findPromoByCode($code)
    {
        return self::find()->where("code = '".$code."' AND expiration_date IS NULL OR expiration_date >= NOW()")->one();
    }

    /**
     * @param Cart $cart
     * @return integer
     */
    public function calculatePromoTotal($cart)
    {
        if ($this->type == self::PROMO_TYPE_PERCENTAGE) {
            return round($cart->totalCost() * (100 + $this->number) / 100);
        } else {
            return $cart->totalQuantity() * $this->number;
        }
    }
}
