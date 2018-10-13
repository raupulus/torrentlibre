<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use yii\helpers\Html;
use app\assets\TorrentsCreateAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

// Registro assets para esta vista
TorrentsCreateAsset::register($this);

$this->title = 'Añadir nuevo Torrent';
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="torrents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'licencias' => $licencias,
        'categorias' => $categorias,
    ]) ?>

</div>
