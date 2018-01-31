<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 30.11.2015
 * Time: 17:54
 */

namespace app\models;

/**
 * @property string $id
 * @property integer $id_item
 * @property integer $id_carrier
 * @property integer $condition
 * @property integer $cost
 * @property integer $quantity
 *
 * @property Item $item
 * @property Carrier $carrier
 */
class CartItem
{
    public $id;
    public $id_item;
    public $id_carrier;
    public $condition;
    public $cost;
    public $quantity;

    public function setId()
    {
        $this->id = self::createId($this->id_item, $this->id_carrier, $this->condition);
    }

    public static function createId($phoneId, $carrierId, $condition)
    {
        return md5($phoneId.':'.$carrierId.':'.$condition);
    }

    public function getItem()
    {
        return Item::findOne($this->id_item);
    }

    public function getCarrier()
    {
        return Carrier::findOne($this->id_carrier);
    }

    public function increaseQuantity()
    {
        ++$this->quantity;
    }
}