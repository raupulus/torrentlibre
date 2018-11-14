<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p style="background-color: #fff; padding: 10px 5px">
        Ha ocurrido un error buscando la página que has solicitado.
        <br />
        Si crees que hay algún problema en el sitio web contáctanos para
        solucionarlo.
    </p>
</div>
