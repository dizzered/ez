<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 30.11.2015
 * Time: 18:05
 */

namespace app\models;


/**
 * @property CartItem[] $positions
 */

class Cart
{
    /**
     * Shopping cart ID to support multiple carts
     * @var string
     */
    public $cartId = __CLASS__;

    public $positions = [];

    public function __construct()
    {
        $this->load();
    }

    private function load()
    {
        $cookie = $this->loadFromCookie();

        if ($cookie) {
            $this->getUnserialized($cookie);
        } else {
            $this->saveToCookie();
        }
    }

    public function clear()
    {
        setcookie($this->cartId, '', time(), '/');
    }

    private function loadFromCookie()
    {
        return isset($_COOKIE[$this->cartId]) ? $_COOKIE[$this->cartId] : null;
    }

    private function saveToCookie()
    {
        setcookie($this->cartId, $this->setSerialized(), time() + 604800, '/');
    }

    private function getUnserialized($serialized)
    {
        $this->positions = unserialize($serialized);
    }

    private function setSerialized()
    {
        return serialize($this->positions);
    }

    public function isEmpty()
    {
        return count($this->positions) > 0 ? false : true;
    }

    public function isPositionExists($positionId)
    {
        if ($this->isEmpty()) return false;

        return $this->getPosition($positionId) ? true : false;
    }

    public function add($phoneId, $carrierId, $condition, $cost)
    {
        $positionId = CartItem::createId($phoneId, $carrierId, $condition);

        if ($this->isPositionExists($positionId)) {
            $this->getPosition($positionId)->increaseQuantity();
        } else {
            $this->addPosition($phoneId, $carrierId, $condition, $cost);
        }

        $this->saveToCookie();
    }

    public function remove($positionId)
    {
        if ($this->isPositionExists($positionId)) {
            unset($this->positions[$positionId]);
            $this->saveToCookie();
        }
    }

    /** @return CartItem */
    public function getPosition($positionId)
    {
        return isset($this->positions[$positionId]) ? $this->positions[$positionId] : null;
    }

    public function addPosition($phoneId, $carrierId, $condition, $cost)
    {
        $positionId = CartItem::createId($phoneId, $carrierId, $condition);

        $position = new CartItem();
        $position->id_carrier = $carrierId;
        $position->id_item = $phoneId;
        $position->cost = $cost;
        $position->condition = $condition;
        $position->id = $positionId;
        $position->quantity = 1;

        $this->positions[$positionId] = $position;
    }

    public function updatePosition($positionId, $data)
    {
        $position = $this->getPosition($positionId);

        foreach ($data as $key => $value)
        {
            $position->{$key} = $value;
        }

        $this->saveToCookie();
    }

    public function totalPositions()
    {
        return count($this->positions);
    }

    public function totalQuantity()
    {
        $result = 0;

        /** @var CartItem $position */
        foreach ($this->positions as $position)
        {
            $result += $position->quantity;
        }

        return $result;
    }

    public function totalCost()
    {
        $total = 0;

        /** @var CartItem $position */
        foreach ($this->positions as $position)
        {
            $total += $position->cost * $position->quantity;
        }

        return $total;
    }
}