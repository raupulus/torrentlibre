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
            [['torrent_id'], 'required'],
            [['torrent_id'], 'default', 'value' => null],
            [['torrent_id'], 'integer'],
            [['registered_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['torrent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torrents::className(), 'targetAttribute' => ['torrent_id' => 'id']],
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
            'torrent_id' => 'Torrent',
            'registered_at' => 'Registered At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrentId()
    {
        return $this->hasOne(Torrents::className(), ['id' => 'torrent']);
    }
}
