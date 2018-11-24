<?php
use app\models\Descargas;
use CpChart\Image;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

$date = new DateTime('now');
$year = $date->format('Y');
$mes = $date->format('m');
$date = $date->setDate($year, $mes, 1)->setTime(0, 0)->format('Y-m-d H:i:s');

/**
 * Obtengo usuarios creados este mes
 */
$query = Descargas::find()
    ->select(['date(registered_at) as date, count(*) as cantidad'])
    ->where(['>=', 'registered_at', $date])
    ->groupBy('date')
    ->orderBy('date ASC')
    ->asArray()
    ->all();

$fechas = [];
$n_descargas = [];
$totalDescargas = 0;
$totalDescargasMes = Descargas::find()->count();

foreach ($query as $data) {
    $tmp = (new DateTime($data['date']))->format('d/m/Y');
    array_push($fechas, $tmp);
    array_push($n_descargas, $data['cantidad']);
    $totalDescargas += $data['cantidad'];
}

/* Create and populate the Data object */
$data = new \CpChart\Data();

//$data->addPoints($n_usuarios, "Probe 1");
//$data->addPoints($fechas, "Probe 2");

$data->addPoints(0, "Descargas");
$data->addPoints(0, "Descargas");
$data->addPoints($n_descargas, "Descargas");

$data->setAxisName(0, "Descargas");

/* Create the Image object */
$image = new Image(700, 230, $data);

/* Turn off Antialiasing */
$image->Antialias = true;

/* Write the chart title */
$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 12]);
$image->drawText(150, 35, 'Usuarios por día este mes', [
    "FontSize" => 20, "Align" => TEXT_ALIGN_BOTTOMMIDDLE
]);

/* Set the default font */
$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 12]);

/* Define the chart area */
$image->setGraphArea(60, 40, 650, 200);

/* Draw the scale */
$scaleSettings = [
    "XMargin" => 10,
    "YMargin" => 10,
    "Floating" => true,
    "GridR" => 200,
    "GridG" => 200,
    "GridB" => 200,
    "DrawSubTicks" => true,
    "CycleBackground" => true
];
$image->drawScale($scaleSettings);

/* Turn on Antialiasing */
$image->Antialias = true;

/* Draw the line of best fit */
$image->drawBestFit();

/* Turn on shadows */
$image->setShadow(true, ["X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10]);

/* Draw the line chart */
$image->drawPlotChart();

/* Write the chart legend */
$image->drawLegend(580, 20, ["Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL]);

/* Render the picture (choose the best way) */
$image->render("tmp/descargasmensual.png");
?>


<div class="row">
    <div class="col-md-12">
        <h4>
            Total de Descargas:
            <span class="text-warning"><?= $totalDescargas ?></span>
        </h4>
    </div>

    <div class="col-md-12">
        <h4>
            Total de Descargas este mes:
            <span class="text-warning"><?= $totalDescargasMes ?></span>
        </h4>

        <img id="descargasmensual"
             class="graficos"
             src="/tmp/descargasmensual.png"
             title="Gráfica de las descargas realizadas este mes"
             alt="Gráfica de las descargas realizadas este mes" />
    </div>

    <div class="col-md-12 text-center">
        <table class="table table-responsive text-center">
            <tr>
                <th class="text-center bg-primary">Día</th>
                <th class="text-center bg-primary">Cantidad de Descargas</th>
            </tr>
        <?php foreach ($fechas as $idx => $fecha): ?>
            <tr>
                <td class="text-center ">
                    <?= (DateTime::createFromFormat('d/m/Y', $fecha))
                            ->format('d/m/Y'); ?>
                </td>

                <td class="text-center">
                    <span class="text-danger">
                        <?= $n_descargas[$idx] ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>
