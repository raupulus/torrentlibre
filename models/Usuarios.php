<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $nick
 * @property string $web
 * @property string $biografia
 * @property string $email
 * @property string $twitter
 * @property string $facebook
 * @property string $googleplus
 * @property string $avatar
 * @property string $password
 * @property string $auth_key
 * @property string $token
 * @property string $lastlogin_at
 * @property int $preferencias_id
 *
 * @property Accesos[] $accesos
 * @property Comentarios[] $comentarios
 * @property Demandas[] $demandas
 * @property Puntos[] $puntos
 * @property Torrents[] $torrents
 * @property PuntuacionComentarios[] $puntuacionComentarios
 * @property PuntuacionTorrents[] $puntuacionTorrents
 * @property ReportesComentarios[] $reportesComentarios
 * @property Comentarios[] $comentarios0
 * @property ReportesTorrents[] $reportesTorrents
 * @property Torrents[] $torrents0
 * @property Torrents[] $torrents1
 * @property Preferencias $preferencias
 * @property UsuariosId $id0
 * @property UsuariosBloqueados $usuariosBloqueados
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nick', 'email', 'password'], 'required'],
            [['id', 'preferencias_id'], 'default', 'value' => null],
            [['id', 'preferencias_id'], 'integer'],
            [['lastlogin_at'], 'safe'],
            [['nombre', 'nick', 'web', 'biografia', 'email', 'twitter', 'facebook', 'googleplus', 'avatar', 'password', 'auth_key', 'token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['nick'], 'unique'],
            [['token'], 'unique'],
            [['id'], 'unique'],
            [['preferencias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preferencias::className(), 'targetAttribute' => ['preferencias_id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'nick' => 'Nick',
            'web' => 'Web',
            'biografia' => 'Biografia',
            'email' => 'Email',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'googleplus' => 'Googleplus',
            'avatar' => 'Avatar',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'token' => 'Token',
            'lastlogin_at' => 'Lastlogin At',
            'preferencias_id' => 'Preferencias ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesos()
    {
        return $this->hasMany(Accesos::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDemandas()
    {
        return $this->hasMany(Demandas::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntos()
    {
        return $this->hasMany(Puntos::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents()
    {
        return $this->hasMany(Torrents::className(), ['id' => 'torrent_id'])->viaTable('puntos', ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionComentarios()
    {
        return $this->hasMany(PuntuacionComentarios::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionTorrents()
    {
        return $this->hasMany(PuntuacionTorrents::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportesComentarios()
    {
        return $this->hasMany(ReportesComentarios::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios0()
    {
        return $this->hasMany(Comentarios::className(), ['id' => 'comentario_id'])->viaTable('reportes_comentarios', ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportesTorrents()
    {
        return $this->hasMany(ReportesTorrents::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents0()
    {
        return $this->hasMany(Torrents::className(), ['id' => 'torrent_id'])->viaTable('reportes_torrents', ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrents1()
    {
        return $this->hasMany(Torrents::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferencias()
    {
        return $this->hasOne(Preferencias::className(), ['id' => 'preferencias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosBloqueados()
    {
        return $this->hasOne(UsuariosBloqueados::className(), ['usuario_id' => 'id']);
    }
}
