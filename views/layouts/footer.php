<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:39
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use \yii\helpers\Html;
?>
<footer id="boxfooter" class="row">
    <section id="boxcontact" class="col-md-12">
        <a href="'/site/contact'"
           title="'Contactar"
           class="">Contactar</a>

    <hr />
    </section>


    <div class="col-sm-4">
        <?= Html::a('Aviso Legal', ['site/avisolegal']) ?>
    </div>

    <div class="col-sm-4">
        <?= Html::a('Política de Cookies', ['site/politicacookies']) ?>
    </div>

    <div class="col-sm-4">
        <?= Html::a('Política de Privacidad', ['site/politicaprivacidad']) ?>
    </div>

    <section class="col-md-12">
        <hr />
        <a href="https://fryntiz.es" alt="web de Raúl Caro Pastorino"
           target="_blank">
            Raúl Caro Pastorino
        </a>
    </section>

    <section id="footer-sitename" class="col-md-12">
        <a href="/"
           title="config.licence">
            <?= $params['sitename']; ?> 2018-<?= date('Y') ?>
        </a>
    </section>
</footer>
