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

<div class="box-comentario-widget col-sm-12 row container">
    <?php foreach ($model as $comentario): ?>
        <?php
            $usuario_id = $comentario['updatedBy'];
            $torrent_id = $comentario['entityId'];
        ?>
    <div class="comentario-widget row center-block">
        <div class="col-sm-12">
            El usuario
            <a href="/usuarios/view?id=<?= $usuario_id ?>">
                <?= $comentario['nick'] ?>
            </a>
            comentó:
        </div>

        <div class="col-sm-12">
            <a href="/torrents/view?id=<?= $torrent_id ?>">
                <?= $comentario['content'] ?>
            </a>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="row">
        <!--
        <?= var_dump($model); ?>
        -->
    </div>
</div>

