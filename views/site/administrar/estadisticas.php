<?php
use app\assets\SiteEstadisticasAsset;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

SiteEstadisticasAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'Estadísticas';
?>

<div id="site-estadisticas" class="container">
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-success">
                <i class="fa fa-file-pdf-o">Descargar en pdf
            </button>

            <button class="btn btn-success">
                <i class="fa fa-file-excel-o"></i> Descargar en excel
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Cantidad de torrents totales</h3>
        </div>

        <div class="col-sm-6">
            <h3>Cantidad de torrents de este mes</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Cantidad de Usuarios totales</h3>
        </div>

        <div class="col-sm-6">
            <h3>Cantidad de Usuarios nuevos este mes</h3>
        </div>
    </div>
</div>
