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
$totalTorrents = 0;

foreach ($query as $data) {
    array_push($categorias, $data['nombre']);
    array_push($cantidades, $data['cantidad']);
    $totalTorrents += $data['cantidad'];
}

/* Create and populate the Data object */
$data = new \CpChart\Data();
$data->addPoints($cantidades, "Cantidades");
$data->setSerieDescription("Cantidades", "Application A");

/* Define the absissa serie */
$data->addPoints($categorias, "Etiquetas");
$data->setAbscissa("Etiquetas");

/* Create the Image object */
$image = new Image(500, 400, $data);

/* Set the default font properties */
$image->setFontProperties([
    "FontName" => "Forgotte.ttf",
    "FontSize" => 12,
    "R" => 80,
    "G" => 80,
    "B" => 80
]);

/* Enable shadow computing */
$image->setShadow(true, ["X" => 5, "Y" => 5, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 50]);

/* Create the pPie object */
$pieChart = new Pie($image, $data);

/* Draw an AA pie chart */
$pieChart->draw3DRing(200, 200, ["DrawLabels" => true, "LabelStacked" => true, "Border" => true]);

$pieChart->drawPieLegend(80, 360, ["Mode" => LEGEND_HORIZONTAL, "Style" => LEGEND_NOBORDER, "Alpha" => 20]);

/* Render the picture (choose the best way) */
$image->render("tmp/torrentstotales.png");
?>

<div class="row">
    <div class="col-md-12">
        <h4>
            Total de torrents:
            <span class="text-warning"><?= $totalTorrents ?></span>
        </h4>
        <img id="torrentstotales"
             class="graficos"
             src="/tmp/torrentstotales.png"
             title="Gráfica de torrents subidos en total"
             alt="Gráfica de torrents subidos en total" />
    </div>

    <?php foreach ($categorias as $idx => $categoria): ?>
    <div class="col-md-12">
        <?= $categoria ?>:
        <span class="text-danger"><?= $cantidades[$idx] ?></span>
    </div>
    <?php endforeach; ?>
</div>
