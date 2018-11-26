<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:40
 */

use app\assets\SiteIndexAsset;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

SiteIndexAsset::register($this);

/* @var $this yii\web\View */

$this->title = Yii::getAlias('@sitename');
?>

<div class="site-index container">
    <div id="index-box-title" class="row">
        <h1>Torrent Libre</h1>
        <h2>Descarga y comparte material libre y redistribuible.</h2>
    </div>

    <div id="index-box-slide" class="row">
        <?php require_once '_slide-index.php' ?>
    </div>

    <div id="index-box-all" class="row">
        <div id="index-box-content" class="col-sm-9 container">
            <div id="index-content" class="top-left col-xs-11">
                <h3>Últimos Torrents</h3>
                <?= \app\widgets\Torrents_widget::widget([
                    'cantidad' => 5,
                    'tipo' => 'ultimos',
                    //'tipo' => 'votados',
                ]) ?>
            </div>

            <div id="index-options" class="text-center col-xs-1">
                <div class="index-option"><i class="fa fa-ambulance"></i></div>
                <div class="index-option"><i class="fa fa-youtube"></i></div>
                <div class="index-option"><i class="fa fa-backward"></i></div>
                <div class="index-option"><i class="fa fa-bell-slash"></i></div>
            </div>
        </div>

        <div id="index-box-aside" class="col-sm-3">
            <?= \app\widgets\Usuariosconectados::widget() ?>

            <h3>Últimos Comentarios</h3>
            <?= \app\widgets\Comentarios_widget::widget([
                'cantidad' => 5,
                'tipo' => 'ultimos',
                //'tipo' => 'votados',
            ]) ?>

            <h3>Comentarios mejor valorados</h3>
            <?= \app\widgets\Comentarios_widget::widget([
                'cantidad' => 5,
                'tipo' => 'votados',
            ]) ?>
        </div>
    </div>
</div>
