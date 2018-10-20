<?php

namespace app\models;

use function var_dump;
use Yii;
use yii\web\IdentityInterface;
use juliardi\captcha\CaptchaValidator;
use yii\helpers\Url;

/**
 * This is the model class for table "usuarios_datos".
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
 * @property Usuarios[] $usuarios
 * @property UsuariosBloqueados $usuariosBloqueados
 * @property Preferencias $preferencias
 */
class UsuariosDatos extends \yii\db\ActiveRecord implements IdentityInterface
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
     * @const CAPTCHA_ACTIVE Constante para cuando se debe validar el captcha
     */
    const CAPTCHA_ACTIVE = 'captcha';

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
        return 'usuarios_datos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nick', 'email'], 'required'],
            [['preferencias_id'], 'default', 'value' => null],
            [['id', 'preferencias_id'], 'integer'],
            [['lastlogin_at'], 'safe'],
            [['nombre', 'nick', 'web', 'biografia', 'email', 'twitter', 'facebook', 'googleplus', 'avatar', 'password', 'auth_key', 'token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['nick'], 'unique'],
            [['token'], 'unique'],
            [['id'], 'unique'],
            [['preferencias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preferencias::className(), 'targetAttribute' => ['preferencias_id' => 'id']],
            [
                ['captcha'],
                'required', 'on' => self::CAPTCHA_ACTIVE
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

                if ($this->avatar == '') {
                    $this->avatar = 'default.png';
                }

                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);

                    // Creo Preferencias
                    $preferencias = new Preferencias(['tema_id' => 1]);
                    $preferencias->save();

                    // Creo usuario_id
                    $usuario_id = new Usuarios([
                        'rol_id' => 5,
                        'datos_id' => 2,
                    ]);
                    if (!$usuario_id->save()) {
                        return false;
                    }

                    // Asigno Preferencias y usuario_id a este usuario
                    $this->preferencias_id = $preferencias->id;
                    $this->id = $usuario_id->id;
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
        $nombre = Yii::getAlias('@r_avatar') . '/' . $this->avatar;
        if (file_exists($nombre)) {
            return Url::to('/r_avatar/') . $this->avatar;
        }
        return Url::to('/r_avatar/') . 'default.png';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioId()
    {
        return $this->hasOne(Usuarios::className(), ['datos_id' => 'id']);
    }

    /**
     * Devuelve el rol del usuario o borrado
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        if ($this->usuarioId != null) {
            return $this->usuarioId->rol->tipo;
        }

        return 'borrado';
    }

    /**
     * Devuelve el id del rol o borrado
     * @return \yii\db\ActiveQuery
     */
    public function getRolId()
    {
        if ($this->usuarioId != null) {
            return $this->usuarioId->rol->id;
        }

        return 2;
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
    public function getPreferencias()
    {
        return $this->hasOne(Preferencias::className(), ['id' => 'preferencias_id']);
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
        // COMPROBAR SI ESTÁ BLOQUEADO
        if (! $this->usuarioBloqueado) {
            return $this->auth_key === $authKey;
        }

        return false;
    }

    /**
     * Compara si la cadena pasada como parámetro coincide con la
     * contraseña de este usuario.
     * @param  string $password La contraseña a validar.
     * @return bool             Devuelve true si es válida.
     */
    public function validatePassword($password)
    {
        if (! $this->usuarioBloqueado) {
            return Yii::$app->security->validatePassword(
                $password,
                $this->password
            );
        }

        return false;
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
}
