<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "torrents".
 *
 * @property int $id
 * @property int $licencia_id
 * @property int $categoria_id
 * @property int $usuario_id
 * @property string $titulo
 * @property string $resumen
 * @property string $descripcion
 * @property string $imagen
 * @property string $file
 * @property int $size
 * @property string $magnet
 * @property string $password
 * @property string $md5
 * @property int $n_descargas
 * @property int $n_visitas
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comentarios[] $comentarios
 * @property Descargas[] $descargas
 * @property Puntos[] $puntos
 * @property Usuarios[] $usuarios
 * @property PuntuacionTorrents[] $puntuacionTorrents
 * @property ReportesTorrents[] $reportesTorrents
 * @property Usuarios[] $usuarios0
 * @property Categorias $categoria
 * @property Licencias $licencia
 * @property Usuarios $usuario
 */
class Torrents extends \yii\db\ActiveRecord
{
    /**
     * Imagen subida mediante el formulario.
     * @var \yii\web\UploadedFile
     */
    public $u_img;

    /**
     * Archivo torrent subido mediante el formulario.
     * @var \yii\web\UploadedFile
     *
     */
    public $u_torrent;

    /**
     * @const ESCENARIO_CREATE Constante para cuando estamos insertando
     */
    const ESCENARIO_CREATE = 'create';

    /**
     * @const ESCENARIO_UPDATE Constante para cuando estamos actualizando
     */
    const ESCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'torrents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['licencia_id', 'categoria_id', 'usuario_id', 'titulo', 'resumen'], 'required'],
            [['licencia_id', 'categoria_id', 'usuario_id', 'size', 'n_descargas', 'n_visitas'], 'default', 'value' => null],
            [['licencia_id', 'categoria_id', 'usuario_id', 'size', 'n_descargas', 'n_visitas'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['titulo', 'resumen', 'imagen', 'file', 'magnet', 'password', 'md5'], 'string', 'max' => 255],
            [['descripcion'], 'string', 'max' => 500],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['licencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Licencias::className(), 'targetAttribute' => ['licencia_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'u_img',
            'u_torrent',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'licencia_id' => 'Licencia',
            'categoria_id' => 'Categoria',
            'usuario_id' => 'Uploader',
            'titulo' => 'Título',
            'resumen' => 'Resumen',
            'descripcion' => 'Descripción',
            'imagen' => 'Imagen',
            'file' => 'File',
            'size' => 'Size',
            'magnet' => 'Magnet',
            'password' => 'Password',
            'md5' => 'Md5',
            'n_descargas' => 'N Descargas',
            'n_visitas' => 'N Visitas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'u_img' => 'Imagen Portada',
            'u_torrent' => 'Archivo Torrent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescargas()
    {
        return $this->hasMany(Descargas::className(), ['torrent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntos()
    {
        return $this->hasMany(Puntos::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuadores()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('puntos', ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacion()
    {
        return $this->hasMany(PuntuacionTorrents::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportes()
    {
        return $this->hasMany(ReportesTorrents::className(), ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportadores()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('reportes_torrents', ['torrent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicencia()
    {
        return $this->hasOne(Licencias::className(), ['id' => 'licencia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
