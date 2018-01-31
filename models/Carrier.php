<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * This is the model class for table "carrier".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $svisibility
 * @property string $slug
 *
 */
class Carrier extends \yii\db\ActiveRecord
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
        return 'carrier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['svisibility'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255]
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
            'svisibility' => 'Visible',
        ];
    }

    public function getPrettyName()
    {
        return Inflector::slug($this->name);
    }
}
