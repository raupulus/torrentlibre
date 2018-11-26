<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

use app\assets\TorrentsWidgetAsset;
use \yii\helpers\Html;
use \yii\helpers\Url;

TorrentsWidgetAsset::register($this);

if (empty($model)) {
    return;
}
?>

<div class="box-torrent-widget col-sm-12 row container">
    <h3><?= $titulo ?></h3>

    <table class="table-torrent-widget table table-responsive table-bordered">
        <tr>
            <th><i class="fa fa-download"></i></th>
            <th>Archivo Torrent</th>
            <th>Categoría</th>
            <th>Subido</th>
            <th>Tamaño</th>
            <th>Uploader</th>
        </tr>

        <?php foreach ($model as $torrent): ?>
            <?php
                $id = $torrent['id'];
                $titulo = $torrent['titulo'];
                $categoria = $torrent['nombre'];
                $fecha = Yii::$app->formatter->asRelativeTime($torrent['created_at']);
                $size = Yii::$app->formatter->asShortSize($torrent['size']);
                $uploader = $torrent['nick'];
                $uploaderId = $torrent['datos_id'];
            ?>

        <tr>
            <td>
                <?= Html::a('↓', Url::to([
                        'torrents/descargar',
                        'id' => $id,
                    ]),
                [
                    'title' => 'Descargar '.$titulo,
                    'alt' => 'Descargar '.$titulo,
                    'class' => 'btn-torrent-download btn btn-success col-sm-12',
                    'data-torrent_id' => $id,
                    'download'
                ]); ?>
            </td>

            <td>
                <a href="/torrents/view?id=<?= $id ?>"><?= $titulo ?></a>
            </td>

            <td>
                <?= $categoria ?>
            </td>

            <td>
                <?= $fecha ?>
            </td>

            <td>
                <?= $size ?>
            </td>

            <td>
                <a href="/usuarios/view?id=<?= $uploaderId ?>">
                    <?= $uploader ?>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

