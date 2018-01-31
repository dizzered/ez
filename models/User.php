<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $phone
 * @property string $addition_info
 * @property string $created
 * @property string $type
 *
 * @property Order[] $orders
 * @property UserAddress[] $addresses
 * @property Payment[]  $payments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    protected static $cache = [];
    protected static $roles = [];

    public $username;
    public $confirm;
    public $rememberMe;
    public $terms;
    private $salt = 'a30it1';

    public $newPassword;
    public $confirmNewPassword;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'created',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'safe', 'on' => ['restore', 'profile']],
            // username and password are both required
            [['email', 'password'], 'required'],
            [['phone', 'first_name', 'last_name', 'addition_info', 'type', 'newPassword'], 'safe'],
            // compare passwords
            ['confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords don\'t match', 'on' => 'register'],
            // email is validated by email rule
            ['email', 'email'],
            // email is validated by unique rule
            ['email', 'unique', 'on' => 'register'],
            // phone is requred on register
            [['phone', 'first_name', 'last_name', 'confirm'], 'required', 'on' => 'register'],
            ['terms', 'compare', 'compareValue' => true, 'message' => 'You should accept Terms & Conditions', 'on' => 'register'],
            [['phone', 'first_name', 'last_name'], 'required', 'on' => 'profile'],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Passwords don\'t match', 'on' => 'profile'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::getUser($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @param $uid
     * @return self
     */
    public static function getUser($uid)
    {
        if (!isset(self::$cache[$uid])) {
            self::$cache[$uid] = self::getUserInternal($uid);
        }
        return self::$cache[$uid];
    }

    /**
     * @param $uid
     * @return User|array|null|\yii\db\ActiveRecord
     */
    protected static function getUserInternal($uid)
    {
        $query = self::find();
        $user = $query->where(['id' => $uid])->one();

        if (!$user) {
            $user = new self();
            $user->id = -1;
        }

        return $user;
    }

    /**
     * Finds user by username
     *
     * @param  string      $email
     * @return static|null
     */
    public static function findByUsername($email)
    {
        $user = self::find()->where(['email' => $email])->one();
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password.'.'.$this->salt);
    }

    public function generatePassword()
    {
        $pswd = Yii::$app->security->generateRandomString(8);
        $this->password = md5($pswd.'.'.$this->salt);

        return $pswd;
    }

    public function securePassword()
    {
        return $this->password = md5($this->password.'.'.$this->salt);
    }

    public function resetPassword($password = null)
    {
        $hash = $password ? $password : Yii::$app->security->generateRandomString(8);
        $this->password = $hash;
        $this->securePassword();

        if ($this->save()) {
            $text = '<table><tr><td><br /><br /><br />' .
                '<strong>This e-mail is notification of the following recent change to your ' . Yii::$app->name . ' account:</strong><br /><br /><br />' .
                'Your new password is: ' . $hash . '<br /><br /><br /><br /><br />' .
                'If you did not make this change or authorize someone else to make the change, contact ' . Yii::$app->name . ' immediately<br><br />' .
                'This email was automatically generated by ' . Yii::$app->name . '. Please do not reply to this message.' .
                '</td></tr></table>';
            $this->sendEmail($text);
            return true;
        }

        return false;
    }

    public static function tableName()
    {
        return 'users';
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findByUsername($this->email);

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Incorrect username or password.');
                return false;
            }
            return \Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function register()
    {
        $this->scenario = Model::SCENARIO_DEFAULT;

        return \Yii::$app->user->login($this, 0);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id_user' => 'id'])->orderBy(['order_date' => SORT_DESC]);
    }

    public function getAddresses()
    {
        return $this->hasMany(UserAddress::class, ['user_id' => 'id']);
    }

    public function getAddressesList()
    {
        $result = [];
        foreach ($this->addresses as $address)
        {
            /** @var UserAddress $address */
            $result[$address->id] = $address->getFullAddress(false, ', ', true);
        }

        return $result;
    }

    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['id_user' => 'id'])->orderBy(['payment_date' => SORT_DESC]);
    }

    public function getFullName()
    {
        $result = trim($this->first_name . ' ' . $this->last_name);
        if ($result) {
            return $result;
        }

        return '';
    }

    public function sendEmail($text)
    {
        Yii::$app->mailer->compose('simple', ['message' => $text])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name.' - Reset Password')
            ->send();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($insert) {
                $this->securePassword();
            }

            return true;
        }
        return false;
    }
}
