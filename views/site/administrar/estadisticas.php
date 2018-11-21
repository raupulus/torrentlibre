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
            <h3>Categorías más subidas</h3>
            <div id="contenedor"></div>
            <?php
            $torrentsTotales = Torrents::find()->all();

            //nos creamos dos arrays para almacenar el tiempo y el valor numérico
            $valoresArray;
            $timeArray;
            //en un bucle for obtenemos en cada iteración el valor númerico y
            //el TIMESTAMP del tiempo y lo almacenamos en los arrays
            for($i = 0 ;$i<count($torrentsTotales);$i++){
                $valoresArray[$i]= $torrentsTotales[$i]['titulo'];
                //OBTENEMOS EL TIMESTAMP
                $time= $torrentsTotales[$i]['created_at'];
                $date = new DateTime($time);
                //ALMACENAMOS EL TIMESTAMP EN EL ARRAY
                $timeArray[$i] = $date->getTimestamp()*1000;
            }

            ?>
            <script>
                var datos = function() {
                    // generate an array of random data
                    var data = [];
                    <?php
                    for($i = 0 ;$i < count($torrentsTotales);$i++){
                    ?>
                    data.push(["<?php echo $timeArray[$i];?>", "<?php echo $valoresArray[$i];?>"]);
                    <?php } ?>
                    return data;
                }
            </script>

            <?php require_once '_torrentstotales.php'; ?>
        </div>

        <div class="col-sm-6">
            <h3>Cantidad de torrents de este mes</h3>
            <?php require_once '_torrentsmensual.php'; ?>
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
