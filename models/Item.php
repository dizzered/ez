<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property string $descr
 * @property string $image
 * @property integer $id_firm
 * @property integer $svisibility
 *
 * @property Firm $firm
 * @property ItemPrice[] $prices
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    public static function getInstance()
    {
        return new self();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_firm'], 'required'],
            [['descr'], 'string'],
            [['id_firm', 'svisibility'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255]
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
            'descr' => 'Description',
            'image' => 'Image',
            'file' => 'Image',
            'id_firm' => 'Firm',
            'svisibility' => 'Visible',
        ];
    }

    public function getFirm()
    {
        return $this->hasOne(Firm::class, ['id' => 'id_firm']);
    }

    public function getPrices()
    {
        return $this->hasMany(ItemPrice::class, ['id_item' => 'id'])
            ->andWhere(['>', 'price_good', 0])
            ->andWhere(['>', 'price_fair', 0])
            ->andWhere(['>', 'price_poor', 0]);
    }

    public function setPrices($prices)
    {
        $currentPrices = $this->mapPrices();
        if ($prices) {
            foreach ($prices as $carrierId => $itemPrices)
            {
                if (ArrayHelper::getValue($currentPrices, $carrierId)) {
                    $price = $this->findItemPriceByCarrier($carrierId);
                } else {
                    $price = new ItemPrice();
                    $price->id_item = $this->id;
                    $price->id_carrier = $carrierId;
                }

                $save = false;
                $delete = [];
                foreach (ItemPrice::$itemConditionTableLabels as $val)
                {
                    if ($itemPrices[$val] > 0 && $itemPrices[$val] != $price->$val) {
                        $save = true;
                        $price->$val = $itemPrices[$val];
                    } else if ($itemPrices[$val] == 0) {
                        $delete[] = 1;
                    }
                }

                if (count($delete) == count(ItemPrice::$itemConditionTableLabels)) {
                    $price->delete();
                } else if ($save) {
                    $price->save();
                }
            }
        }
    }

    public function mapPrices()
    {
        $result = [];
        foreach ($this->prices as $price)
        {
            /** @var ItemPrice $price */
            foreach (ItemPrice::$itemConditionTableLabels as $val)
            {
                $result[$price->id_carrier][$val] = $price->$val;
            }
        }
        return $result;
    }

    public function findItemPriceByCarrier($carrierId)
    {
        foreach ($this->prices as $price)
        {
            /** @var ItemPrice $price */
            if ($price->id_carrier == $carrierId) return $price;
        }
        return null;
    }

    public static function getPrettyLink($carrierName, $firmName, $itemNAme)
    {
        return self::getInstance()->prettyLink($carrierName, $firmName, $itemNAme);
    }

    /** @param string $firmName */
    /** @param Item|string $itemName */
    /** @param Carrier|string $carrier */
    public function prettyLink($carrier = null, $firmName = null, $item = null)
    {
        $result = Yii::$app->getHomeUrl().'phone/';

        $firmName = $firmName ? $firmName : $this->firm->name;
        $result .= Inflector::slug($firmName).'/';

        $itemName = $item ? $item : $this->name;
        $carrierName = is_a($carrier, Carrier::className()) ? $carrier->name : $carrier;
        $result .= Inflector::slug($itemName).'-'.Inflector::slug($carrierName);

        return $result;
    }
}
