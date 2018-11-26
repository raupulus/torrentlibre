<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

namespace app\widgets;

use app\models\Comentarios;
use app\models\Torrents;

/**
 * Class Comentarios_widget
 * Genera una tabla con los últimos comentarios o por puntuación.
 *
 * @package app\widgets
 */
class Torrents_widget extends \yii\bootstrap\Widget
{
    /**
     * @var Representa la cantidad de Torrents.
     */
    public $cantidad;

    /**
     * @var Indica si contendrá los últimos Torrents o los más votados.
     *      Admite los valores 'ultimos' y 'votados'
     */
    public $tipo;

    /**
     * @var Contiene la categoría de los torrents a mostrar.
     */
    public $categoria;

    /**
     * @var Modelo con la consulta para los datos.
     */
    public $model;

    /**
     * @var Titulo de la sección actual.
     */
    public $titulo;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->cantidad === null) {
            $this->cantidad = 5;
        }

        if ($this->tipo == 'ultimos') {
            $this->tipo = 'ultimos';
            $this->titulo = 'Últimos Torrents';
        } else if ($this->tipo == 'votados') {
            $this->tipo = 'votados';
            $this->titulo = 'Torrents Más Votados';
        }

        if ($this->categoria == 'todas') {
            $this->categoria = 'todas';
        } else {
            $this->titulo = 'Mostrando categoría: ' . $this->categoria;
        }

        /**
         * Obtiene todos los Torrents unidos a los usuarios a los que pertenecen y
         * sus puntuaciones.
         * @return array
         */
        $this->model = Torrents::obtenerPuntuacion([
            'cantidad' => $this->cantidad,
            'tipo' => $this->tipo,
            'categoria' => $this->categoria,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('torrents_widget', [
            'model' => $this->model,
            'titulo' => $this->titulo,
        ]);
    }
}
