<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ip_bloqueadas".
 *
 * @property int $id
 * @property string $ip
 * @property string $created_at
 */
class IpBloqueadas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip_bloqueadas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['created_at'], 'safe'],
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
            'created_at' => 'Created At',
        ];
    }
}
