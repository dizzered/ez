<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 27.11.2015
 * Time: 11:45
 */

namespace app\models;


use Yii;
use yii\base\Model;

class InquiryForm extends Model
{
    public $firstName;
    public $lastName;
    public $businessName;
    public $email;
    public $confirmEmail;
    public $phone;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;

    public $quantity;
    public $condition;
    public $additionalInfo;
    public $agree;

    public $quantityLabels = [
        0 => 'Select Quantity...',
        20 => '10-20',
        50 => '21-50',
        80 => '51-80',
        100 => '81-100',
        150 => '101-150',
        200 => '151-200',
        300 => '201-300',
        301 => '301+'
    ];

    public $conditionLabels = [
        0 => 'Select Condition..',
        'perfect' => 'Perfect',
        'good' => 'Good',
        'fair' => 'Fair'
    ];


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'businessName', 'email', 'confirmEmail', 'phone', 'address1', 'city', 'state', 'zip'], 'required'],
            ['quantity', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => 'Please select quantity'],
            ['condition', 'compare', 'compareValue' => 0, 'operator' => '!=', 'message' => 'Please select condition'],
            [['email', 'confirmEmail'], 'email'],
            ['confirmEmail', 'compare', 'compareAttribute' => 'email', 'message' => 'Emails don\'t match'],
            [['firstName', 'lastName', 'businessName', 'email', 'confirmEmail', 'phone', 'address1', 'city', 'state', 'zip', 'quantity', 'condition', 'additionalInfo', 'agree'], 'safe'],
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'You should agreed Terms & Conditions to use our service']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'zip' => 'Zip Code',
            'quantity' => 'Quantity of Devices',
            'condition' => 'Condition of Devices',
            'additionalInfo' => 'Additional Information'
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
            $text = '<table><tr><td>
                <p>First Name: '.$this->firstName.'</p>
                <p>Last Name: '.$this->lastName.'</p>
                <p>Business Name: '.$this->businessName.'</p>
                <p>Email: '.$this->email.'</p>
                <p>Phone: '.$this->phone.'</p>
                <p>Address Line 1: '.$this->address1.'</p>
                <p>Address Line 2: '.$this->address2.'</p>
                <p>City: '.$this->city.'</p>
                <p>State: '.$this->state.'</p>
                <p>Zip: '.$this->zip.'</p>
                <p>Total Devices: '.$this->quantityLabels[$this->quantity].'</p>
                <p>Condition: '.$this->conditionLabels[$this->condition].'</p>
                <p>Additional Info: '.$this->additionalInfo.'</p>
            </td></tr></table>';

            Yii::$app->mailer->compose('simple', ['message' => $text])
                ->setTo($email)
                ->setFrom([$this->email => $this->firstName.' '.$this->lastName])
                ->setSubject(Yii::$app->name.': Business Solutions Inquiry')
                ->send();

            return true;
        }
        return false;
    }
}