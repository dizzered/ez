<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $order;

    public function __construct()
    {
        parent::__construct();

        if (!Yii::$app->user->isGuest) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $this->name = $user->getFullName();
            $this->email = $user->email;
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'body'], 'required'],
            ['email', 'email'],
            ['order', 'safe'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Your Email',
            'name' => 'Your Name',
            'body' => 'Question',
            'verifyCode' => 'Verification Code',
            'order' => 'Order Number'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($email)
    {
        if ($this->validate()) {
            $text = '<table>'.($this->order ? '<tr><td>Order #</td><td>'.$this->order.'</td></tr>' : '').
                '<tr><td>Email</td><td>'.$this->email.'</td></tr>'.
                '<tr><td>Name</td><td>'.$this->name.'</td></tr>'.
                '<tr><td>Message</td><td>'.$this->body.'</td></tr>'.
                '</table>';

            Yii::$app->mailer->compose('simple', ['message' => $text])
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject(Yii::$app->name.' - Contact Inquiry')
                ->send();

            return true;
        }
        return false;
    }
}
