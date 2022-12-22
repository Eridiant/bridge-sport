<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%error_log}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $error
 * @property int $created_at
 */
class ErrorLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%error_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['error'], 'string'],
            [['created_at'], 'required'],
            [['created_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Вид ошибки',
            'error' => 'Описание',
            'created_at' => 'Время',
        ];
    }
}
