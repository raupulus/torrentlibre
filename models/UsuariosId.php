<?php

namespace app\models;

use Yii;

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
            [['rol_id'], 'default', 'value' => null],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rol_id' => 'Rol ID',
            'ip' => 'Ip',
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
