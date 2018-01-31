<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_text".
 *
 * @property integer $id
 * @property string $email_name
 * @property string $email_text
 */
class OrderEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_text', 'email_name'], 'required'],
            [['email_text', 'email_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_name' => 'Email Name',
            'email_text' => 'Email Text',
        ];
    }
}
