<?php

namespace app\models;

use Yii;
use yii\db\Expression;


/**
 * This is the model class for table "usuarios_id".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $rol_id
 * @property string $ip
 *
 * @property Usuarios $usuarios
 * @property Roles $rol
 */
class UsuariosId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_id';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['rol_id'], 'default', 'value' => '4'],
            [['rol_id'], 'integer'],
            [['ip'], 'string', 'max' => 15],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('attributelabels', 'created_at'),
            'updated_at' => Yii::t('attributelabels', 'updated_at'),
            'rol_id' => 'Rol ID',
            'ip' => Yii::t('attributelabels', 'ip'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Roles::className(), ['id' => 'rol_id']);
    }
}
