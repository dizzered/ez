<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "states".
 *
 * @property string $state
 * @property string $state_code
 */
class State extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'state_code'], 'required'],
            [['state'], 'string', 'max' => 22],
            [['state_code'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state' => 'State',
            'state_code' => 'State Code',
        ];
    }
}
