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

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?= Html::a('Aviso Legal', ['site/avisolegal']) ?>
            </div>

            <div class="col-sm-4">
                <?= Html::a('Política de Cookies', ['site/politicacookies']) ?>
            </div>
        </div>

        <div class="row">
            <p class="pull-left">&copy; <?= $params['sitename']; ?> 2018-<?= date
                ('Y')
                ?></p>

            <p class="pull-right">
                <a href="http://www.fryntiz.es" alt="web de Raúl Caro Pastorino">
                    Raúl Caro Pastorino
                </a>
            </p>
        </div>
    </div>
</footer>
