<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "payments".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $payment_date
 * @property double $payment_sum
 * @property integer $id_order
 *
 * @property User $user
 * @property Order $order
 */
class Payment extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'payment_date',
                'updatedAtAttribute' => 'payment_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'payment_sum', 'id_order'], 'required'],
            [['id_user', 'id_order'], 'integer'],
            [['payment_date'], 'safe'],
            [['payment_sum'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'payment_date' => 'Payment Date',
            'payment_sum' => 'Payment Sum',
            'id_order' => 'Id Order',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'id_order']);
    }
}
