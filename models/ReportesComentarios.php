<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reportes_comentarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $comentario_id
 * @property string $ip
 * @property string $titulo
 * @property string $resumen
 * @property bool $comunicado
 * @property string $created_at
 *
 * @property Comentarios $comentario
 * @property Usuarios $usuario
 */
class ReportesComentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reportes_comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'comentario_id', 'titulo', 'resumen'], 'required'],
            [['usuario_id', 'comentario_id'], 'default', 'value' => null],
            [['usuario_id', 'comentario_id'], 'integer'],
            [['comunicado'], 'boolean'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['titulo'], 'string', 'max' => 120],
            [['resumen'], 'string', 'max' => 300],
            [['usuario_id', 'comentario_id'], 'unique', 'targetAttribute' => ['usuario_id', 'comentario_id']],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::className(), 'targetAttribute' => ['comentario_id' => 'id']],
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
            'usuario_id' => 'Usuario ID',
            'comentario_id' => 'Comentario ID',
            'ip' => 'Ip',
            'titulo' => 'Titulo',
            'resumen' => 'Resumen',
            'comunicado' => 'Comunicado',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentarios::className(), ['id' => 'comentario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
