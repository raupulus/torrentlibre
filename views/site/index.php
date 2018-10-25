<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:40
 */

use app\helpers\Amazons3;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/* @var $this yii\web\View */

$this->title = Yii::getAlias('@sitename');


$amazon = new Amazons3();
$amazon->uploadImage('/images/torrent-image/default.png', '/');



?>
<div class="site-index">
    <h1>Torrent Libre</h1>
    <h2>Sitio temporal con el desarrollo</h2>
    <p>
        Esta aplicación web está en desarrollo y es mi proyecto
        integrado para final de DAW.
    </p>

    <p>
        Los datos introducidos no son reales y se perderán en cualquier momento.
    </p>

    <p class="alert-warning">
        No uses esta aplicación hasta que entre en una fase beta más avanzada.
    </p>
</div>
