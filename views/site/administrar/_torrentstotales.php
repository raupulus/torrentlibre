<?php
use app\models\Torrents;
use CpChart\Chart\Pie;
use CpChart\Image;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

$query = Torrents::find()
    ->select('categorias.nombre, count(*) as cantidad')
    ->leftJoin('categorias', 'torrents.categoria_id = categorias.id')
    ->groupBy('categorias.nombre')
    ->orderBy('categorias.nombre ASC')
    ->asArray()
    ->all();

$categorias = [];
$cantidades = [];

foreach ($query as $data) {
    array_push($categorias, $data['nombre']);
    array_push($cantidades, $data['cantidad']);
}

/* Create and populate the Data object */
$data = new \CpChart\Data();
$data->addPoints($cantidades, "Cantidades");
$data->setSerieDescription("Cantidades", "Application A");

/* Define the absissa serie */
$data->addPoints($categorias, "Etiquetas");
$data->setAbscissa("Etiquetas");

/* Create the Image object */
$image = new Image(800, 400, $data);

/* Set the default font properties */
$image->setFontProperties([
    "FontName" => "Forgotte.ttf",
    "FontSize" => 12,
    "R" => 80,
    "G" => 80,
    "B" => 80
]);

/* Enable shadow computing */
$image->setShadow(true, ["X" => 2, "Y" => 2, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 50]);

/* Create the pPie object */
$pieChart = new Pie($image, $data);

/* Draw an AA pie chart */
$pieChart->draw3DRing(200, 200, ["DrawLabels" => true, "LabelStacked" => true, "Border" => true]);

$pieChart->drawPieLegend(80, 360, ["Mode" => LEGEND_HORIZONTAL, "Style" => LEGEND_NOBORDER, "Alpha" => 20]);

/* Render the picture (choose the best way) */
$image->render("tmp/torrentstotales.png");
?>

<img id="torrentstotales" class="graficos" src="/tmp/torrentstotales.png" />
