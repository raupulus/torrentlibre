<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puntos".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $torrent_id
 * @property string $created_at
 *
 * @property Torrents $torrent
 * @property Usuarios $usuario
 */
class Puntos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puntos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'torrent_id'], 'required'],
            [['usuario_id', 'torrent_id'], 'default', 'value' => null],
            [['usuario_id', 'torrent_id'], 'integer'],
            [['created_at'], 'safe'],
            [['usuario_id', 'torrent_id'], 'unique', 'targetAttribute' => ['usuario_id', 'torrent_id']],
            [['torrent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torrents::className(), 'targetAttribute' => ['torrent_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'torrent_id' => 'Torrent ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrent()
    {
        return $this->hasOne(Torrents::className(), ['id' => 'torrent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
