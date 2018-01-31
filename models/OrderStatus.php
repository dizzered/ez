<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order_status".
 *
 * @property integer $id
 * @property integer $status_id
 * @property string $status_name
 * @property integer $email_text_id
 * @property string $status_label
 * @property integer $visibility
 *
 * @property OrderEmail $orderEmail
 */
class OrderStatus extends \yii\db\ActiveRecord
{

    const ORDER_STATUS_DEFAULT = 'default';
    const ORDER_STATUS_WARNING = 'warning';
    const ORDER_STATUS_SUCCESS = 'success';
    const ORDER_STATUS_DANGER = 'danger';
    const ORDER_STATUS_INFO = 'info';
    const ORDER_STATUS_PRIMARY = 'primary';

    public static $orderStatusesClasses = [
        self::ORDER_STATUS_DEFAULT => self::ORDER_STATUS_DEFAULT,
        self::ORDER_STATUS_WARNING => self::ORDER_STATUS_WARNING,
        self::ORDER_STATUS_SUCCESS => self::ORDER_STATUS_SUCCESS,
        self::ORDER_STATUS_DANGER => self::ORDER_STATUS_DANGER,
        self::ORDER_STATUS_INFO => self::ORDER_STATUS_INFO,
        self::ORDER_STATUS_PRIMARY => self::ORDER_STATUS_PRIMARY,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'status_name', 'status_label'], 'required'],
            [['status_id', 'email_text_id'], 'integer'],
            [['visibility'], 'safe'],
            [['status_name', 'status_label'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Status ID',
            'status_name' => 'Status Name',
            'email_text_id' => 'Email Text ID',
        ];
    }

    public function getOrderEmail()
    {
        return $this->hasOne(OrderEmail::class, ['id' => 'email_text_id']);
    }

    public static function asArray($onlyVisible = false)
    {
        $query = self::find();
        if ($onlyVisible) {
            $query->where(['visibility' => 1]);
        }
        return ArrayHelper::map($query->orderBy(['status_name' => SORT_ASC])->all(), 'status_id', 'status_name');
    }
}
