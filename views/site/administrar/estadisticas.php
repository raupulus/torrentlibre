<?php
use app\assets\SiteEstadisticasAsset;
use app\models\Torrents;
use CpChart\Chart\Pie;
use CpChart\Image;

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
    <div id="box-download" class="row text-center">
        <div class="col-sm-12">
            <button class="btn btn-sm btn-success">
                <i class="fa fa-file-pdf-o text-danger"></i>
                Descargar en pdf
            </button>

            <button class="btn btn-sm btn-success">
                <i class="fa fa-file-excel-o text-warning"></i>
                Descargar en excel
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 container">
            <h3>Categorías más subidas</h3>
            <?php require_once '_torrentstotales.php'; ?>
        </div>

        <div class="col-sm-6 container">
            <h3>Cantidad de torrents de este mes</h3>
            <?php require_once '_torrentsmensual.php'; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 container">
            <h3>Cantidad de Usuarios totales</h3>
            <?php require_once '_usuariostotales.php'; ?>
        </div>

        <div class="col-sm-6 container">
            <h3>Cantidad de Usuarios nuevos este mes</h3>
            <?php require_once '_usuariosmensual.php'; ?>
        </div>
    </div>
</div>
