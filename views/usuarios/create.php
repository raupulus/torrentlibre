<?php

/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use app\assets\UsuariosCreateAsset;
use app\models\Usuarios;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = Yii::t('usuarios-create', 'title');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('usuarios-create', 'breadcrumbs'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;

// Registro assets para esta vista
UsuariosCreateAsset::register($this);

?>
<div class="usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
