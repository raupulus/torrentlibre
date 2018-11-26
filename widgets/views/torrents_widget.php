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
?>

<div class="box-torrent-widget col-sm-12 row container">
    <table class="table table-responsive table-bordered table-torrent-widget">
        <tr>
            <th>↓</th>
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
                $fecha = $torrent['created_at'];
                $size = $torrent['size'];
                $uploader = $torrent['nick'];
                $uploaderId = $torrent['datos_id'];
            ?>

        <tr>
            <td>
                <?= Html::a('Descargar Torrent', Url::to([
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

