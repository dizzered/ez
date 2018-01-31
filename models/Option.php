<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property string $id
 * @property integer $share_bonus
 * @property string $share_type
 * @property string $share_url
 */
class Option extends \yii\db\ActiveRecord
{
    const OPTION_SHARE_TYPE_LIKE_BTN = 'like';
    const OPTION_SHARE_TYPE_SHARE_BTN = 'share';
    const OPTION_SHARE_TYPE_BUSINESS = 'business';

    public static $shareTypeLabels = [
        self::OPTION_SHARE_TYPE_LIKE_BTN => 'Like Button',
        self::OPTION_SHARE_TYPE_SHARE_BTN => 'Share Button',
        self::OPTION_SHARE_TYPE_BUSINESS => 'Business Solutions'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['share_bonus'], 'integer'],
            [['share_type', 'share_url'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_bonus' => 'Share Bonus',
            'share_type' => 'Share Type',
            'share_url' => 'Share Url',
        ];
    }
}
