<?php
use app\models\Torrents;
use CpChart\Chart\Pie;
use CpChart\Image;
use CpChart\Data;

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

$query = Torrents::find()
    ->select(['date(created_at) as date, count(*) as cantidad'])
    ->where(['>=', 'created_at', $date])
    ->groupBy('date')
    ->orderBy('date DESC')
    ->asArray()
    ->all();

$fechas = [];
$n_torrents = [];
$totalSubidas = 0;
foreach ($query as $data) {
    $tmp = (new DateTime($data['date']))->format('d/m/Y');
    array_push($fechas, $tmp);
    array_push($n_torrents, $data['cantidad']);
    $totalSubidas += $data['cantidad'];
}

/* Create and populate the Data object */
$data = new Data();
$data->addPoints($n_torrents, "Hits");
$data->setAxisName(0, "Hits");
$data->addPoints($fechas, "Browsers");
$data->setSerieDescription("Browsers", "Browsers");
$data->setAbscissa("Browsers");

/* Create the Image object */
$image = new Image(500, 500, $data);

$image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 8]);

/* Draw the chart scale */
$image->setGraphArea(100, 30, 480, 480);
$image->drawScale([
    "CycleBackground" => true,
    "DrawSubTicks" => true,
    "GridR" => 0,
    "GridG" => 0,
    "GridB" => 0,
    "GridAlpha" => 10,
    "Pos" => SCALE_POS_TOPBOTTOM
]);

/* Turn on shadow computing */
$image->setShadow(true, ["X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10]);

/* Draw the chart */
$image->drawBarChart(["DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => true, "Rounded" => true, "Surrounding" => 30]);

/* Write the legend */
$image->drawLegend(570, 215, ["Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL]);

/* Render the picture (choose the best way) */
$image->render("tmp/torrentsmensual.png");
?>


<div class="row">
    <div class="col-md-12">
        <h4>
            Total de subidas este mes:
            <span class="text-warning"><?= $totalSubidas ?></span>
        </h4>
        <img id="torrentstotales"
             class="graficos"
             src="/tmp/torrentsmensual.png"
             title="Gráfica de torrents subidos este mes"
             alt="Gráfica de torrents subidos este mes" />
    </div>

    <?php foreach ($fechas as $idx => $fecha): ?>
        <div class="col-md-12 text-center">
            <?= (DateTime::createFromFormat('d/m/Y', $fecha))->format('d/m/Y'); ?>:
            <span class="text-danger">
                <?= $n_torrents[$idx] ?>
            </span>
        </div>
    <?php endforeach; ?>
</div>
