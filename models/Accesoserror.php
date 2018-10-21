<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accesoserror".
 *
 * @property int $id
 * @property string $ip
 * @property string $registered_at
 */
class Accesoserror extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accesoserror';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registered_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'registered_at' => 'Registered At',
        ];
    }
}
