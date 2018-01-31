<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordered_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $item_id
 * @property integer $carrier_id
 * @property integer $phone_condition
 * @property integer $price
 * @property integer $count
 *
 * @property Order $order
 * @property Item $item
 * @property Carrier $carrier
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ordered_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id', 'carrier_id', 'phone_condition'], 'required'],
            [['order_id', 'item_id', 'carrier_id', 'phone_condition', 'price', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order #',
            'item_id' => 'Item',
            'carrier_id' => 'Carrier',
            'phone_condition' => 'Quoted Condition',
            'price' => 'Price',
            'count' => 'Count',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'carrier_id']);
    }

    /** @param CartItem $position */
    public function copyFromCartPosition($position)
    {
        $this->item_id = $position->id_item;
        $this->carrier_id = $position->id_carrier;
        $this->phone_condition = $position->condition;
        $this->price = $position->cost;
        $this->count = $position->quantity;
    }
}
