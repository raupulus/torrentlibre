<?php

namespace app\models;

use function array_sum;
use DateTime;
use function var_dump;
use Yii;
use yii\db\Expression;
use yii\db\Query;

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
 * @property string $hash
 * @property int $size
 * @property string $n_piezas
 * @property string $size_piezas
 * @property string $archivos
 * @property string $archivos_hash
 * @property string $archivos_size
 * @property string $trackers
 * @property string $name
 * @property string $password
 * @property string $created_at
 * @property string $torrentcreate_at
 * @property string $updated_at
 *
 * @property Comentarios[] $comentarios
 * @property Descargas[] $descargas
 * @property PuntuacionTorrents[] $puntuacionTorrents
 * @property Usuarios[] $usuarios
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
     * Elemento que representa a todas las celdas para buscar en ellas
     * @var String
     */
    public $allfields;

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
            [['licencia_id', 'categoria_id', 'usuario_id', 'titulo', 'resumen'],
                'required'],
            [['licencia_id', 'categoria_id', 'usuario_id', 'size'], 'default', 'value' => null],
            [['licencia_id', 'categoria_id', 'usuario_id', 'size'], 'integer'],
            [['n_piezas', 'size_piezas'], 'number'],
            [['archivos', 'archivos_hash', 'archivos_size', 'trackers', 'name'], 'string'],
            [['created_at', 'torrentcreate_at', 'updated_at'], 'safe'],
            [['titulo', 'resumen', 'imagen', 'hash', 'password'], 'string', 'max' => 255],
            [['descripcion'], 'string', 'max' => 500],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['licencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Licencias::className(), 'targetAttribute' => ['licencia_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' =>
                Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['u_img'], 'file', 'extensions' => 'png, jpg'],
            [['u_torrent'], 'file', 'extensions' => 'torrent'],
            [
                ['u_torrent'], 'required', 'on' => self::ESCENARIO_CREATE,
                'message' => 'Es obligatorio agregar un Torrent válido'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'licencia_id' => 'Licencia',
            'categoria_id' => 'Categoría',
            'usuario' => 'Uploader',
            'titulo' => 'Título',
            'resumen' => 'Resumen',
            'descripcion' => 'Descripción',
            'imagen' => 'Imagen',
            'hash' => 'Hash',
            'size' => 'Tamaño',
            'n_piezas' => 'Cantidad de Piezas',
            'size_piezas' => 'Tamaño de Piezas',
            'archivos' => 'Archivos del Torrent',
            'archivos_hash' => 'Archivos Hash',
            'archivos_size' => 'Archivos Size',
            'trackers' => 'Trackers',
            'name' => 'Nombre Original',
            'password' => 'Password',
            'created_at' => 'Fecha de subida',
            'torrentcreate_at' => 'Fecha de creación',
            'updated_at' => 'Actualizado en',
            'u_img' => 'Imagen Portada',
            'u_torrent' => 'Archivo Torrent',
            'descargas' => 'Veces descargado',
        ];
    }

    /**
     * Sobreescribe el método personalizando la configuración
     * @return array Devuelve la configuración
     */
    public function behaviors()
    {
        return [
            // Creo un timestamp cada vez que salta el evento create
            // o update asignando el timestamp actual
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * Acciones llevadas a cabo antes de insertar un torrent
     * @param bool $insert Acción a realizar, si existe está insertando
     * @return bool Devuelve un booleano, si se lleva a cabo es true.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if ($this->scenario === self::ESCENARIO_UPDATE) {
                    return true;
                }
            }
            return true;
        }
        return false;
    }

    public function getVisitas()
    {
        return true;
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
        return $this->hasMany(Descargas::className(), ['torrent_id' => 'id'])
            ->count();
    }

    /**
     * Devuelve la puntuación media de las votaciones para el torrent.
     * @param string $id Recibe el id o se aplica al modelo actual.
     *
     * @return float|int Devuelve la puntuación media.
     */
    public function getPuntos($id = '')
    {
        if (empty($id)) {
            $id = $this->id;
        }

        $p = PuntuacionTorrents::find()
            ->select('puntuacion')
            ->where(['torrent_id' => $id])
            ->column();

        $total = array_sum($p);
        $votos = count($p);

        if ($votos == 0) {
            return 0;
        }

        return $total / $votos;
    }
    
    public function getMisPuntos()
    {
        $torrent = $this->id;
        $usuario = Yii::$app->user->id;
        
        $puntuacion = PuntuacionTorrents::find()
            ->select('puntuacion')
            ->where(['torrent_id' => $torrent])
            ->andWhere(['usuario_id' => $usuario])
            ->scalar();

        return $puntuacion ?: 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuadores()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('puntuacion_torrents', ['torrent_id' => 'id']);
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

    public function getEstareportado()
    {
        $usuario = Yii::$app->user->id;
        $model = ReportesTorrents::find()->where([
            'torrent_id' => $this->id,
            'usuario_id' => $usuario,
        ])->one();

        if (empty($model)) {
            return false;
        }

        return true;
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

    /**
     * Obtiene todos los torrents subidos este mes.
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function subidasEsteMes()
    {
        $date = new DateTime('now');
        $year = $date->format('Y');
        $mes = $date->format('m');
        $date = $date->setDate($year, $mes, 1)->setTime(0, 0)->format('Y-m-d H:i:s');

        return Torrents::find()
            ->select(['date(created_at) as date, count(*) as cantidad'])
            ->where(['>=', 'created_at', $date])
            ->groupBy('date')
            ->orderBy('date DESC')
            ->asArray()
            ->all();
    }

    /**
     * Obtiene la cantidad de torrents por cada categoría y los devuelve en
     * un array.
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function cantidadTorrentsPorCategoria()
    {
        return Torrents::find()
            ->select('categorias.nombre, count(*) as cantidad')
            ->leftJoin('categorias', 'torrents.categoria_id = categorias.id')
            ->groupBy('categorias.nombre')
            ->orderBy('categorias.nombre ASC')
            ->asArray()
            ->all();
    }

    /**
     * Devuelve el objeto con todos los torrents junto a su puntuación
     *
     * @return \yii\db\ActiveQuery
     */
    public static function obtenerPuntuacion($config)
    {
        $query = new Query();

        $query->select('*, t.id as torrent_id')
            ->from('torrents t')
            ->leftJoin(
                'puntuacion_torrents p',
                'p.torrent_id = t.id'
            )
            ->leftJoin('usuarios u', 'u.id = t.usuario_id')
            ->leftJoin('usuarios_datos ud', 'ud.id = u.datos_id')
            ->leftJoin('categorias c', 'c.id = t.categoria_id');

        if ($config['categoria'] !== 'todas') {
            $query->where([
                'c.nombre' => $config['categoria'],
            ]);
        }

        if ($config['tipo'] == 'ultimos') {
            $query->orderBy('p.created_at DESC');
        } else if ($config['tipo'] == 'votados') {
            $query->orderBy('p.puntuacion DESC');
        }

        return $query->limit($config['cantidad'])->all();
    }
}
