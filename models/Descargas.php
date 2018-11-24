<?php

namespace app\models;

use DateTime;
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

    /**
     * Obtiene todas las descargas de este mes y devuelve el objeto
     * ActiveRecord en un Array.
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function descargasMes()
    {
        $date = new DateTime('now');
        $year = $date->format('Y');
        $mes = $date->format('m');
        $date = $date->setDate($year, $mes, 1)
                ->setTime(0, 0)
                ->format('Y-m-d H:i:s');

        return Descargas::find()
            ->select(['date(registered_at) as date, count(*) as cantidad'])
            ->where(['>=', 'registered_at', $date])
            ->groupBy('date')
            ->orderBy('date ASC')
            ->asArray()
            ->all();
    }
}
