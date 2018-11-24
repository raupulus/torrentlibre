<?php

namespace app\models;

use DateTime;
use Yii;
use juliardi\captcha\CaptchaValidator;
use yii\helpers\Url;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property int $datos_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $rol_id
 *
 * @property Accesos[] $accesos
 * @property Comentarios[] $comentarios
 * @property Demandas[] $demandas
 * @property PuntuacionComentarios[] $puntuacionComentarios
 * @property Comentarios[] $comentarios0
 * @property PuntuacionTorrents[] $puntuacionTorrents
 * @property Torrents[] $torrents
 * @property ReportesComentarios[] $reportesComentarios
 * @property Comentarios[] $comentarios1
 * @property ReportesTorrents[] $reportesTorrents
 * @property Torrents[] $torrents0
 * @property Torrents[] $torrents1
 * @property Roles $rol
 * @property UsuariosDatos $datos
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
            [['datos_id'], 'default', 'value' => null],
            [['rol_id'], 'default', 'value' => 5],
            [['datos_id', 'rol_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol_id' => 'id']],
            [['datos_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosDatos::className(), 'targetAttribute' => ['datos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datos_id' => 'Datos',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rol_id' => 'Rol ID',
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
        //return $this->hasMany(Comentarios::className(), ['usuario_id' =>'id']);
        return $this->hasMany(Comment::className(), ['usuario_id' => 'id']);
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
    public function getPuntuacionComentarios()
    {
        return $this->hasMany(PuntuacionComentarios::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios0()
    {
        return $this->hasMany(Comentarios::className(), ['id' => 'comentario_id'])->viaTable('puntuacion_comentarios', ['usuario_id' => 'id']);
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
    public function getTorrents()
    {
        return $this->hasMany(Torrents::className(), ['id' => 'torrent_id'])->viaTable('puntuacion_torrents', ['usuario_id' => 'id']);
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
    public function getComentarios1()
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
    public function getRol()
    {
        return $this->hasOne(Roles::className(), ['id' => 'rol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatos()
    {
        return $this->hasOne(UsuariosDatos::className(), ['id' => 'datos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosBloqueados()
    {
        return $this->hasOne(UsuariosBloqueados::className(), ['usuario_id' => 'id']);
    }

    /**
     * Comprueba si el usuario está bloqueado.
     *
     * @return bool Será true si está bloqueado.
     */
    public function getUsuarioBloqueado()
    {
        return UsuariosBloqueados::findOne([
            'usuario_id' => $this->id,
        ]) ? true : false;
    }

    /**
     * Devuelve el número de torrents para este usuario.
     *
     * @return int|string
     */
    public function getN_torrents()
    {
        $usuario = Yii::$app->user->id;

        return Torrents::find()->where([
            'usuario_id' => $this->id,
        ])->count();
    }

    /**
     * Obtiene los usuarios creados en total devolviendo el año en el que se
     * han creado y la cantidad de usuarios para ese año.
     * Será devuelto en un array.
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function creadosEntotal()
    {
        return Usuarios::find()
            ->select(['EXTRACT(YEAR FROM created_at) as year, count(*) as cantidad'])
            ->groupBy('year')
            ->orderBy('year ASC')
            ->asArray()
            ->all();
    }

    /**
     * Obtiene los usuarios creados este mismo mes y los devuelve como array
     * por día de registro y cantidad para es cada día.
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function creadosEsteMes()
    {
        $date = new DateTime('now');
        $year = $date->format('Y');
        $mes = $date->format('m');
        $date = $date->setDate($year, $mes, 1)
                ->setTime(0, 0)
                ->format('Y-m-d H:i:s');

        return Usuarios::find()
            ->select(['date(created_at) as date, count(*) as cantidad'])
            ->where(['>=', 'created_at', $date])
            ->groupBy('date')
            ->orderBy('date ASC')
            ->asArray()
            ->all();
    }
}
