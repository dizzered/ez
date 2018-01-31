<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $line_1
 * @property string $line_2
 * @property string $city
 * @property string $state
 * @property string $zip
 *
 * @property User $user
 * @property State $stateFull
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'line_1', 'city', 'state', 'zip'], 'required'],
            [['user_id'], 'integer'],
            [['line_1', 'line_2'], 'string'],
            [['city'], 'string', 'max' => 255],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'line_1' => 'Address  1',
            'line_2' => 'Address  2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function setUser($user)
    {
        $this->user = $user;
        $this->user_id = $user->id;
    }

    public function getStateFull()
    {
        return $this->hasOne(State::class, ['state_code' => 'state']);
    }

    public function getFullAddress($withName = true, $separator = ', ', $stateFull = false)
    {
        $result = [];
        if ($withName) {
            $result[] = $this->user->getFullName();
        }

        $result[] = $this->line_1;
        if ($this->line_2) {
            $result[] = $this->line_2;
        }

        $result[] = $this->city.' '.($stateFull ? $this->stateFull->state : $this->state).' '.$this->zip;

        return implode($separator, $result);
    }
}
