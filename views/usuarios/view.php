<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use app\assets\UsuariosViewAsset;
use app\helpers\Roles;
use app\helpers\Access;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->datos->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Registro assets para esta vista
UsuariosViewAsset::register($this);

// Variables
$isAdmin = Roles::isAdmin();
$isAutor = Access::isAutor($model->id);
?>

<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Si es el administrador -->
    <?php if ($isAdmin): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'datos.nombre',
                'datos.nick',
                'rol.tipo',
                'datos.web',
                'datos.biografia',
                'datos.email:email',
                'datos.twitter',
                'datos.facebook',
                'datos.googleplus',
                'datos.avatar',
                'datos.lastlogin_at',
                [
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'value' => function($model) {
                        $img = $model->datos->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],
            ],
        ])
        ?>

        <!-- Si es el usuario al que corresponde la información -->
    <?php elseif ($isAutor): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'format' => 'raw',
                    'value' => function($model, $key, $index) {
                        $img = $model->datos->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],
                'datos.nombre',
                'datos.nick',
                'datos.web',
                'datos.biografia',
                'datos.email:email',
                'datos.twitter',
                'datos.facebook',
                'datos.googleplus',
                'datos.lastlogin_at',
                'rol.tipo',
            ],
        ])
        ?>

        <h3>Preferencias del usuario</h3>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'datos.preferencias.tema.nombre',
                'datos.preferencias.tema.descripcion',
                'datos.preferencias.promociones:boolean',
                'datos.preferencias.noticias:boolean',
                'datos.preferencias.resumen:boolean',
                'datos.preferencias.tour:boolean',
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
        <?php if ($isAutor || $isAdmin): ?>
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
