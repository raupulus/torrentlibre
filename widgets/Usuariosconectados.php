<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

namespace app\widgets;

use app\models\Accesos;
use app\models\UsuariosDatos;

/**
 * Class Usuariosconectados
 * Muestra un resumen de los usuarios conectados a la aplicación.
 *
 * @package app\widgets
 */
class Usuariosconectados extends \yii\bootstrap\Widget
{
    /**
     * @var Contiene la cantidad total de usuarios registrados.
     */
    public $usuarios_totales;

    /**
     * @var Contiene la cantidad de usuarios que han entrado en los últimos 30m.
     */
    public $usuarios_30min;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->usuarios_totales = UsuariosDatos::find()->count();

        $rango = new \DateTime('now');
        $rango->modify('-30 min');
        $this->usuarios_30min = Accesos::find()->where([
            '>=', 'registered_at', $rango->format('Y-m-d H:i:s'),
        ])->count('DISTINCT(usuario_id)');
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $res = '<p class="cantidad-usuarios">';
        $res .= "$this->usuarios_30min Usuarios recientes.";
        $res .= '<br />';
        $res .= "Hay $this->usuarios_totales usuarios registrados.</p>";
        $res .= '</p>';

        return $res;
    }
}
