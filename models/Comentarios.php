<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $torrent_id
 * @property string $contenido
 * @property int $comentario_id
 * @property string $created_at
 * @property string $updated_at
 * @property bool $deleted
 *
 * @property Comentarios $comentario
 * @property Comentarios[] $comentarios
 * @property Torrents $torrent
 * @property Usuarios $usuario
 * @property PuntuacionComentarios[] $puntuacionComentarios
 * @property ReportesComentarios[] $reportesComentarios
 * @property Usuarios[] $usuarios
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'torrent_id', 'contenido'], 'required'],
            [['usuario_id', 'torrent_id', 'comentario_id'], 'default', 'value' => null],
            [['usuario_id', 'torrent_id', 'comentario_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['deleted'], 'boolean'],
            [['contenido'], 'string', 'max' => 500],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::className(), 'targetAttribute' => ['comentario_id' => 'id']],
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
            'contenido' => 'Contenido',
            'comentario_id' => 'Comentario ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentarios::className(), ['id' => 'comentario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['comentario_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionComentarios()
    {
        return $this->hasMany(PuntuacionComentarios::className(), ['comentario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportesComentarios()
    {
        return $this->hasMany(ReportesComentarios::className(), ['comentario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('reportes_comentarios', ['comentario_id' => 'id']);
    }
}
