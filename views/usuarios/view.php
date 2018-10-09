<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use app\assets\UsuariosViewAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Registro assets para esta vista
UsuariosViewAsset::register($this);

// Variables
if (!Yii::$app->user->isGuest) {
    $rol = Yii::$app->user->identity->rol;
}

?>

<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Si es el administrador -->
    <?php if ($rol === 'admin'): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nombre',
                'nick',
                'usuariosId.rol.tipo',
                'web',
                'biografia',
                'email:email',
                'twitter',
                'facebook',
                'googleplus',
                'avatar',
                'lastlogin_at',
                [
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'value' => function($model) {
                        $img = $model->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],
                'usuariosId.ip',
            ],
        ])
    ?>

    <!-- Si es el usuario al que corresponde la información -->
    <?php elseif (Yii::$app->user->id === $model->id): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'value' => function($model) {
                        $img = $model->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],
                'nombre',
                'nick',
                'web',
                'biografia',
                'email:email',
                'twitter',
                'facebook',
                'googleplus',
                'lastlogin_at',
                'usuariosId.rol.tipo',
                'usuariosId.ip',
            ],
        ])
    ?>

    <h3>Preferencias del usuario</h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'preferencias.tema.nombre',
            'preferencias.tema.descripcion',
            'preferencias.promociones:boolean',
            'preferencias.noticias:boolean',
            'preferencias.resumen:boolean',
            'preferencias.tour:boolean',
        ],
    ]) ?>

    <?php else: ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'value' => function($model) {
                        $img = $model->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],
                'nick',
                'web',
                'biografia',
                'email:email',
                'twitter',
                'facebook',
                'googleplus',
                'usuariosId.rol.tipo',
            ],
        ]) ?>
    <?php endif ?>

    <p>
        <?php if ((Yii::$app->user->id === $model->id) || ($rol === 'admin')): ?>
            <?= Html::a('Modificar',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>

            <?= Html::a('Eliminar cuenta', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro que quieres eliminar el usuario?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </p>

</div>
