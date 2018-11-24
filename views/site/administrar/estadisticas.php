<?php
use app\assets\SiteEstadisticasAsset;
use Dompdf\Dompdf;
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
    <div id="box-download" class="row text-center no-print">
        <div class="col-sm-12">
            <button id="btn-print" class="btn btn-sm btn-success">
                <i class="fa fa-file-pdf-o text-danger"></i>
                Descargar en pdf
            </button>

            <!--
            <button class="btn btn-sm btn-success">
                <i class="fa fa-file-excel-o text-warning"></i>
                Descargar en excel
            </button>
            -->
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
        <?php require_once '_usuariostotales.php'; ?>

        <div class="col-sm-6 container">
            <div class="row">
                <div class="col-md-12">
                    <h3>Cantidad de Usuarios nuevos este mes</h3>
                </div>
            </div>

            <?php require_once '_usuariosmensual.php'; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Cantidad de descargas</h3>
                </div>
            </div>

            <?php require_once '_descargas.php'; ?>
        </div>
    </div>
</div>
