<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/
namespace app\models;

use Yii;

/**
 * This is the model class for table "demandas".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $titulo
 * @property string $descripcion
 * @property bool $atendido
 *
 * @property Usuarios $usuario
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
            [['usuario_id', 'titulo', 'descripcion'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['allfields'], 'safe'],
            [['usuario_id'], 'integer'],
            [['atendido'], 'boolean'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['titulo'], 'unique'],
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
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'atendido' => 'Atendido',
            'allfields' => 'Buscar por todos los campos'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosDatos::className(), ['id' => 'usuario_id']);
    }
}
