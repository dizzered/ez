<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shipping".
 *
 * @property integer $id
 * @property string $name
 * @property string $descr
 * @property double $price
 * @property string $image
 * @property integer $svisibility
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['descr'], 'string'],
            [['price'], 'number'],
            [['svisibility'], 'integer'],
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
            'price' => 'Price',
            'image' => 'Image',
            'file' => 'Image',
            'svisibility' => 'Visible',
        ];
    }
}
