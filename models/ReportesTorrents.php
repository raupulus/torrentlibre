<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reportes_torrents".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $torrent_id
 * @property string $ip
 * @property string $titulo
 * @property string $resumen
 * @property bool $comunicado
 * @property string $created_at
 *
 * @property Torrents $torrent
 * @property Usuarios $usuario
 */
class ReportesTorrents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reportes_torrents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'torrent_id', 'titulo', 'resumen'], 'required'],
            [['usuario_id', 'torrent_id'], 'default', 'value' => null],
            [['usuario_id', 'torrent_id'], 'integer'],
            [['comunicado'], 'boolean'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['titulo'], 'string', 'max' => 120],
            [['resumen'], 'string', 'max' => 300],
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
            'ip' => 'Ip',
            'titulo' => 'Titulo',
            'resumen' => 'Resumen',
            'comunicado' => 'Comunicado',
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
