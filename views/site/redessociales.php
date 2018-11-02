<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 21/10/18
 * Time: 17:22
 */

use app\assets\RedesSocialesAsset;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

RedesSocialesAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Redes Sociales';

?>
<div class="site-iplocked container">
    <h1>Redes sociales</h1>
    <h2>Sigue esta web desde tus Redes Sociales favoritas</h2>

    <div class="row box-content-white">
        <p>
            Compartimos periódicamente novedades, recopilaciones de mejores
            torrents y todas las novedades mediante las siguientes Redes Sociales:
        </p>

        <ul id="lista-redes-sociales">
            <li><a href="#"><i class="fa fa-telegram"></i>https://????</a></li>
            <li><a href="#"><i class="fa fa-twitter"></i>https://????</a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i>https://????</a></li>
            <li><a href="#"><i class="fa fa-facebook"></i>https://????</a></li>
        </ul>
    </div>
</div>
