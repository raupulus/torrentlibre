<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

//var_dump($model);

?>

<div id="box-comentario-widget" class="col-sm-12 row container">
    <?php foreach ($model as $comentario): ?>
    <div class="comentario-widget row">
        <div class="col-sm-12">
            El usuario <?= $comentario['nick'] ?> comentó:
        </div>

        <div class="col-sm-12">
            <?= $comentario['content'] ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
