<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "testimonials".
 *
 * @property integer $id
 * @property string $created
 * @property string $modified
 * @property string $text
 * @property string $signature
 */
class Testimonial extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'modified',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testimonials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'signature'], 'required'],
            [['created', 'modified'], 'safe'],
            [['text'], 'string'],
            [['signature'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'modified' => 'Modified',
            'text' => 'Text',
            'signature' => 'Signature',
        ];
    }

    public static function findModels($random = true, $limit = null)
    {
        $query = self::find();
        $query->orderBy($random ? 'RAND()' : ['created' => SORT_DESC]);
        if ($limit) {
            $query->limit($limit);
        }
        return $query->all();
    }
}
