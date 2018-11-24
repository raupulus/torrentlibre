<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accesos".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $ip
 * @property string $registered_at
 *
 * @property Usuarios $usuario
 */
class Accesos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accesos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['registered_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
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
            'ip' => 'Ip',
            'usuario_id' => 'Usuario ID',
            'registered_at' => 'Registered At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }

    public static function conectados30min()
    {
        $rango = new \DateTime('now');
        $rango->modify('-30 min');

        return Accesos::find()->where([
            '>=', 'registered_at', $rango->format('Y-m-d H:i:s'),
        ])->count('DISTINCT(usuario_id)');
    }
}
