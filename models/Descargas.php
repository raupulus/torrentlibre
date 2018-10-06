<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descargas".
 *
 * @property int $id
 * @property string $ip
 * @property int $torrent
 * @property string $registered_at
 *
 * @property Torrents $torrent0
 */
class Descargas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'descargas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torrent'], 'required'],
            [['torrent'], 'default', 'value' => null],
            [['torrent'], 'integer'],
            [['registered_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['torrent'], 'exist', 'skipOnError' => true, 'targetClass' => Torrents::className(), 'targetAttribute' => ['torrent' => 'id']],
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
            'torrent' => 'Torrent',
            'registered_at' => 'Registered At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrent0()
    {
        return $this->hasOne(Torrents::className(), ['id' => 'torrent']);
    }
}
