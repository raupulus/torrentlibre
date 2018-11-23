<?php
use app\assets\SiteEstadisticasAsset;
use app\models\Torrents;
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
    ->select(['date(created_at) as date, count(*) as cantidad'])
    //->leftJoin('categorias', 'torrents.categoria_id = categorias.id')
    ->groupBy('date')
    ->orderBy('date ASC')
    ->asArray()
    ->all();
