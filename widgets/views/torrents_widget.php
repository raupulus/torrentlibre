<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

use app\assets\ComentariosWidgetAsset;

ComentariosWidgetAsset::register($this);
?>

<div class="box-torrent-widget col-sm-12 row container">
    <?php foreach ($model as $torrent): ?>
        <?php
            $id = $torrent['id'];
            $titulo = $torrent['nombre'];
        ?>
    <div class="torrent-widget row center-block">
        <div class="w-torrent-titulo col-sm-12">
            <a href="/torrent/view?id=<?= $id ?>">
                <?= $titulo ?>
            </a>
        </div>
    </div>
    <?php endforeach; ?>

    <?php var_dump($model); ?>

</div>

