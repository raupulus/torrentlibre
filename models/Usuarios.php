<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use juliardi\captcha\CaptchaValidator;
use yii\helpers\Url;

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
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @const ESCENARIO_CREATE Constante para cuando estamos insertando
     */
    const ESCENARIO_CREATE = 'create';

    /**
     * @const ESCENARIO_UPDATE Constante para cuando estamos actualizando
     */
    const ESCENARIO_UPDATE = 'update';

    /**
     * Atributo usado para guardar el campo de "confirmar contraseña" del
     * formulario de creación de usuarios.
     * @var string
     */
    public $password_repeat;

    /**
     * Atributo usado para guardar el captcha
     */
    public $captcha;

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
            [['id', 'nick', 'email'], 'required'],
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
            [
                ['captcha'],
                'required', 'on' => self::ESCENARIO_CREATE
            ],
            ['captcha', CaptchaValidator::className()],  // Validación captcha
            [['password'], 'string', 'max' => 255],
            [['password_repeat'], 'string', 'max' => 255],
            [
                ['password', 'password_repeat'],
                'required', 'on' => self::ESCENARIO_CREATE
            ],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::ESCENARIO_CREATE, self::ESCENARIO_UPDATE],
                'message' => 'Deben coincidir las contraseñas.',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'password_repeat',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => \Yii::t('attributelabels', 'nombre'),
            'nick' => \Yii::t('attributelabels', 'nick'),
            'web' => Yii::t('attributelabels', 'web'),
            'biografia' => Yii::t('attributelabels', 'bio'),
            'email' => Yii::t('attributelabels', 'email'),
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'googleplus' => 'Google Plus',
            'avatar' => Yii::t('attributelabels', 'avatar'),
            'password' => Yii::t('attributelabels', 'password'),
            'password_repeat' => Yii::t('attributelabels', 'password_repeat'),
            'auth_key' => 'auth_key',
            'token' => 'Token',
            'lastlogin_at' => Yii::t('attributelabels', 'lastlogin_at'),
            'preferencias_id' => 'Preferencias ID',
            'captcha' => Yii::t('attributelabels', 'captcha'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosId()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'id']);
    }

    /**
     * Devuelve el rol del usuario
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->usuariosId->rol->tipo;
    }

    /**
     * Acciones llevadas a cabo antes de insertar un usuario
     * @param bool $insert Acción a realizar, si existe está insertando
     * @return bool Devuelve un booleano, si se lleva a cabo es true.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->token = Yii::$app->security->generateRandomString();
                $this->auth_key = Yii::$app->security->generateRandomString();

                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);
                }
            } elseif ($this->scenario === self::ESCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);
                }
            }
            return true;
        }
        return false;
    }

    /*
     * Devuelve la ruta del avatar para el usuario actual.
     * return String Ruta del avatar
     */
    public function getRutaImagen()
    {
        $nombre = Yii::getAlias('@r_avatar/') . $this->avatar;
        if (file_exists($nombre)) {
            return Url::to('/r_avatar/') . $this->avatar;
        }
        return Url::to('/r_avatar/') . 'default.png';
    }

    /* AUTENTICACIÓN DE USUARIOS */

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*
        foreach (self::$users as $user) {
            if ($user['token'] === $token) {
                return new static($user);
            }
        }
        return null;
        */
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Compara si la cadena pasada como parámetro coincide con la
     * contraseña de este usuario.
     * @param  string $password La contraseña a validar.
     * @return bool             Devuelve true si es válida.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password
        );
    }
}
