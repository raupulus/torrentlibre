<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 21/10/18
 * Time: 17:22
 */

use app\assets\IpLockedAsset;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/* @var $this yii\web\View */

IpLockedAsset::register($this);

$this->title = 'IP Bloqueada';

?>
<div id="site-iplocked">
    <h1>IP Bloqueada</h1>
    <h2>Sitio temporal con el desarrollo</h2>

    <p>
        La IP desde la que intentas acceder ha sido bloqueada por demasiados
        intentos de conexión fallidos consecutivos.
    </p>

    <p class="alert-warning">
        Para cualquier consulta al respecto diríjase por favor a <?=
        Yii::getAlias('@adminEmail') ?>
    </p>
</div>
