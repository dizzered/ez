<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_text".
 *
 * @property integer $id
 * @property string $email_text
 */
class EmailText extends \yii\db\ActiveRecord
{
    public $code = [
        "[first_name]",
        "[last_name]",
        "[email]",
        "[order]",
        "[description]",
        "[payment_amount]"
    ];

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
            [['email_text'], 'required'],
            [['email_text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_text' => 'Email Text',
        ];
    }

    /** @var Order $order */
    public function replaceCodes($order)
    {
        if ($order->order_status == Order::ORDER_STATUS_REPRICE) {
            $info = $order->reprice_info;
        } else {
            $info = '';
        }

        $values = [
            $order->user->first_name,
            $order->user->last_name,
            $order->user->email,
            $order->order_number,
            $info,
            $order->final_sum
        ];

        return str_replace($this->code, $values, $this->email_text);
    }
}
