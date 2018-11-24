<?php
use app\models\Usuarios;
use CpChart\Chart\Pie;
use CpChart\Image;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

$query = Usuarios::find()
    ->select(['EXTRACT(YEAR FROM created_at) as year, count(*) as cantidad'])
    ->groupBy('year')
    ->orderBy('year ASC')
    ->asArray()
    ->all();

$years = [];
$cantidades = [];
$totalUsuarios = 0;

foreach ($query as $data) {
    array_push($years, $data['year']);
    array_push($cantidades, $data['cantidad']);
    $totalUsuarios += $data['cantidad'];
}

/* Create and populate the Data object */
$data = new \CpChart\Data();
$data->addPoints($cantidades, "ScoreA");
$data->setSerieDescription("ScoreA", "Application A");

/* Define the absissa serie */
$data->addPoints($years, "Labels");
$data->setAbscissa("Labels");

/* Create the Image object */
$image = new Image(700, 230, $data, true);

/* Write the picture title */
$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 12]);
$image->drawText(10, 13, "pPie - Draw 3D pie charts", ["R" => 255, "G" => 255,
    "B" => 255]);

/* Set the default font properties */
$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 10,
    "R" => 80, "G" => 80, "B" => 80]);

/* Create the pPie object */
$pieChart = new Pie($image, $data);

/* Define the slice color */
$pieChart->setSliceColor(0, ["R" => 143, "G" => 197, "B" => 0]);
$pieChart->setSliceColor(1, ["R" => 97, "G" => 77, "B" => 63]);
$pieChart->setSliceColor(2, ["R" => 97, "G" => 113, "B" => 63]);

/* Draw a simple pie chart */
$pieChart->draw3DPie(120, 125, ["SecondPass" => false]);

/* Draw an AA pie chart */
$pieChart->draw3DPie(340, 125, ["DrawLabels" => true, "Border" => true]);

/* Enable shadow computing */
$image->setShadow(true, ["X" => 3, "Y" => 3, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10]);

/* Draw a splitted pie chart */
$pieChart->draw3DPie(560, 125, ["WriteValues" => true, "DataGapAngle" => 10, "DataGapRadius" => 6, "Border" => true]);

/* Write the legend */
$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 12]);
$image->setShadow(true, ["X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 20]);

/* Write the legend box */
$image->setFontProperties([
    "FontName" => "Forgotte.ttf",
    "FontSize" => 12,
    "R" => 255,
    "G" => 255,
    "B" => 255
]);
$pieChart->drawPieLegend(600, 8, ["Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL]);

/* Render the picture */
$image->render("tmp/usuariostotales.png");
?>

<div class="col-md-12 text-center container">
    <div class="row">
        <div class="col-md-12">
            <h3>Usuarios por Año</h3>
        </div>
    </div>

    <table class="table table-responsive text-center">
        <tr>
            <th class="text-center bg-primary">Año</th>
            <th class="text-center bg-primary">Cantidad de Usuarios</th>
        </tr>
        <?php foreach ($years as $idx => $year): ?>
            <tr>
                <td class="text-center ">
                    <?= $year ?>
                </td>

                <td class="text-center">
                            <span class="text-danger">
                                <?= $cantidades[$idx] ?>
                            </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="col-sm-6 container">
    <div class="row">
        <div class="col-md-12">
            <h3>Cantidad de Usuarios totales</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>
                Total de Usuarios:
                <span class="text-warning"><?= $totalUsuarios ?></span>
            </h4>
            <img id="usuariostotales"
                 class="graficos"
                 src="/tmp/usuariostotales.png"
                 title="Gráfica de usuarios creados por año"
                 alt="Gráfica de usuarios creados por año" />
        </div>
    </div>
</div>
