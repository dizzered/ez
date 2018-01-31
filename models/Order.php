<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_address
 * @property integer $id_shipping
 * @property integer $payment_type
 * @property string $payment_check
 * @property string $paypal
 * @property string $transaction_number
 * @property string $order_date
 * @property integer $order_status
 * @property integer $order_number
 * @property string $addition_info
 * @property double $final_sum
 * @property double $promo_sum
 * @property string $reprice_info
 *
 * @property User $user
 * @property OrderItem[] $items
 * @property UserAddress $address
 * @property Shipping $shipping
 * @property Payment $payment
 * @property OrderStatus $status
 * @property Log $log
 */
class Order extends ActiveRecord
{
    public $expirationDate;
    public $expired = false;

    const ORDER_STATUS_PENDING = 0;
    const ORDER_STATUS_PAID = 2;
    const ORDER_STATUS_REPRICE = 4;
    const ORDER_STATUS_BOX_MAILED = 7;
    const ORDER_STATUS_PAID_PAYPAL = 9;
    const ORDER_STATUS_PAID_CHECK = 10;

    const ORDER_PAYMENT_TYPE_PAYPAL = 0;
    const ORDER_PAYMENT_TYPE_CHECK = 1;

    public static $orderPaymentTypeLabels = [
        self::ORDER_PAYMENT_TYPE_PAYPAL => 'Paypal',
        self::ORDER_PAYMENT_TYPE_CHECK => 'Check'
    ];

    const ORDER_NUMBER_PREFIX = '3307';
    const ORDER_EMAIL_TEXT = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_address', 'id_shipping'], 'required'],
            [['id_user', 'id_address', 'id_shipping', 'payment_type', 'order_status'], 'integer'],
            [['payment_check', 'addition_info', 'reprice_info'], 'string'],
            [['final_sum', 'promo_sum'], 'number'],
            [['order_date', 'order_number'], 'safe'],
            [['paypal', 'transaction_number'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'User',
            'id_address' => 'Id Address',
            'id_shipping' => 'Id Shipping',
            'payment_type' => 'Payment Type',
            'payment_check' => 'Payment Check',
            'paypal' => 'Paypal',
            'transaction_number' => 'Transaction #',
            'order_date' => 'Date',
            'order_status' => 'Status',
            'order_number' => 'Number',
            'addition_info' => 'Additional Information',
            'reprice_info' => 'Re-Price Information',
            'final_sum' => 'Payout Amount',
            'promo_sum' => 'Promo Amount',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public function  getAddress()
    {
        return $this->hasOne(UserAddress::class, ['id' => 'id_address']);
    }

    public function getShipping()
    {
        return $this->hasOne(Shipping::class, ['id' => 'id_shipping']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id_order' => 'id']);
    }

    public function getStatus()
    {
        return $this->hasOne(OrderStatus::class, ['status_id' => 'order_status']);
    }

    public function getLog()
    {
        return Log::findLog('Order', $this->id, SORT_ASC);
    }

    public function setExpirationDate()
    {
        $this->expirationDate = date("Y-m-d", strtotime($this->order_date) + 60*60*24*14);
        if ($this->expirationDate < date("Y-m-d")) $this->expired = true;
    }

    public function getTotalPrice($withPromo = false)
    {
        $total = 0;
        foreach ($this->items as $item)
        {
            /** @var OrderItem $item */
            $total += $item->price * $item->count;
        }

        return $withPromo ? $total + $this->promo_sum : $total;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->order_status == self::ORDER_STATUS_PAID_CHECK || $this->order_status == self::ORDER_STATUS_PAID_PAYPAL) {
            if ($insert || is_null($this->payment)) {
                $payment = new Payment();
                $payment->id_order = $this->id;
                $payment->id_user = $this->id_user;
            } else {
                $payment = $this->payment;
            }
            $payment->payment_sum = $this->final_sum;

            $payment->save();
        }

        if (isset($changedAttributes['order_status'])) {
            Log::writeLog($this->status->status_name, 'Order', $this->id);
        }
    }

    public function sendEmail()
    {
        /** @var EmailText $emailText */
        $emailText = EmailText::findOne($this->status->email_text_id);

        if ($emailText) {
            $text = $emailText->replaceCodes($this);

            Yii::$app->mailer->compose('simple', ['message' => $text])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($this->user->email)
                ->setBcc(Yii::$app->params['adminEmail'])
                ->setSubject(Yii::$app->name.' - Order #'.$this->order_number)
                ->send();
        }
    }

    public function sendOrderEmail()
    {
        /** @var EmailText $emailText */
        $emailText = EmailText::findOne(self::ORDER_EMAIL_TEXT);

        if ($emailText) {
            $text = $emailText->replaceCodes($this);

            Yii::$app->mailer->compose('order_user', ['model' => $this, 'text' => $text])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($this->user->email)
                ->setSubject(Yii::$app->name.' - Order #'.$this->order_number)
                ->send();

            Yii::$app->mailer->compose('order_admin', ['model' => $this])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(Yii::$app->params['adminEmail'])
                ->setSubject(Yii::$app->name.' - Order #'.$this->order_number)
                ->send();
        }
    }
}
