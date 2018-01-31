<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $text
 * @property string $date
 * @property string $model
 * @property integer $model_id
 */
class Log extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'model', 'model_id'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['model_id'], 'integer'],
            [['model'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'date' => 'Date',
            'model' => 'Model',
            'model_id' => 'Model ID',
        ];
    }

    public static function writeLog($text, $model, $id)
    {
        $log = new self;
        $log->text = $text;
        $log->model = $model;
        $log->model_id = $id;
        $log->save();
    }

    public static function findLog($model, $id, $sort = SORT_DESC)
    {
        return self::find()->where(['model' => $model, 'model_id' => $id])->orderBy(['date' => $sort])->all();
    }

}
