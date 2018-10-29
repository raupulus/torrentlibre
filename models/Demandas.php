<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "demandas".
 *
 * @property int $id
 * @property int $solicitante_id
 * @property int $atendedor_id
 * @property string $titulo
 * @property string $descripcion
 * @property string $created_at
 *
 * @property Usuarios $solicitante
 * @property Usuarios $atendedor
 */
class Demandas extends \yii\db\ActiveRecord
{
    /**
     * @var Atributo seguro para buscar en todos los campos a la vez.
     */
    public $allfields;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demandas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitante_id', 'titulo', 'descripcion'], 'required'],
            [['solicitante_id', 'atendedor_id'], 'default', 'value' => null],
            [['solicitante_id', 'atendedor_id'], 'integer'],
            [['created_at', 'allfields'], 'safe'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['titulo'], 'unique'],
            [['solicitante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['solicitante_id' => 'id']],
            [['atendedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['atendedor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'solicitante_id' => 'Solicitante',
            'atendedor_id' => 'Atendedor',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'created_at' => 'Creado por',
            'allfields' => 'Buscar en todos los campos'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitante()
    {
        return $this->hasOne(UsuariosDatos::className(), ['id' => 'solicitante_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtendedor()
    {
        return $this->hasOne(UsuariosDatos::className(), ['id' => 'atendedor_id']);
    }
}
