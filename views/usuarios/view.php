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

$this->title = $model->datos->nick;
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

    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'labelColOptions' => ['hidden' => true],
                    'captionOptions' => ['class' => 'labelhidden'],
                    'contentOptions' => [
                        'class' => [
                            'text-center',
                            'imagenportada',
                            'col-sm-6'
                        ],
                        'colspan' => 2,
                    ],
                    'value' => function($model) {
                        $nombre = $model->datos->avatar;
                        $ruta = yii::getAlias('@r_avatar');
                        $imagen = $ruta.'/'.$nombre;

                        if (empty($nombre) || (! file_exists($imagen))) {
                            $imagen = $ruta.'/'.'default.png';
                        }

                        return '<img src="/'.$imagen.'" />';
                    }
                ],
                'datos.nick',
                'n_torrents',
                [
                    'attribute' => 'datos.biografia',
                    'visible' => (!empty($model->datos->biografia)),
                ],
                [
                    'attribute' => 'datos.web',
                    'visible' => (!empty($model->datos->web)),
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->datos->web, $model->datos->web,
                        [
                            'class' => 'btn'
                        ]);
                    }
                ],
                [
                    'attribute' => 'datos.twitter',
                    'visible' => (!empty($model->datos->twitter)),
                    'format' => 'raw',
                    'value' => function($model) {
                        $link = 'https://twitter.com/' .
                                $model->datos->twitter;
                        return Html::a($link, $link,[
                            'class' => 'btn'
                        ]);
                    }
                ],
                [
                    'attribute' => 'datos.facebook',
                    'visible' => (!empty($model->datos->facebook)),
                    'format' => 'raw',
                    'value' => function($model) {
                        $link = 'https://facebook.com/' .
                                 $model->datos->facebook;

                        return Html::a($link, $link,[
                            'class' => 'btn'
                        ]);
                    }
                ],
                [
                    'attribute' => 'datos.googleplus',
                    'visible' => (!empty($model->datos->googleplus)),
                    'format' => 'raw',
                    'value' => function($model) {
                        $link = 'https://plus.google.com/' .
                                 $model->datos->googleplus;

                        return Html::a($link, $link,[
                            'class' => 'btn'
                        ]);
                    }
                ],
            ],
        ])
    ?>

    <!-- Si es el autor o el administrador -->
    <?php if ($isAutor || $isAdmin): ?>
        <h3>Datos del perfil</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'datos.nombre',
                'rol.tipo',
                'datos.email:email',
                'datos.avatar',
                'datos.lastlogin_at:datetime',
            ],
        ])
        ?>

    <?php function btnOnOff($bool, $name) {
        $active = $bool ? 'active' : '';

        return '
        <div class="col-sm-5">
            <button type="button" 
                id="btn-onOff-'.$name.'"
                class="btn btn-lg btn-toggle btn-no-interactive '.$active.'"
                data-toggle="button"
                aria-pressed="'.$bool.'"
                data-activado="'.$bool.'" 
                data-name="'.$name.'" 
                autocomplete="off">
                <div class="handle"></div>
            </button>
        </div>
        ';
    } ?>

        <h3>Preferencias del usuario</h3>
        <button id="btn-modificar-preferencias" class="btn btn-warning btn-xs">
            Modificar preferencias
        </button>
        <?= DetailView::widget([
            'model' => $model,
            'id' => 'tabla-preferencias',
            'options' => [
                'class' => 'table table-striped table-bordered detail-view',
                'data-id' => $model->datos->preferencias->id,
            ],
            'attributes' => [
                'datos.preferencias.tema.nombre:text:Nombre del Tema',
                'datos.preferencias.tema.descripcion:text:Descripción del Tema',
                [
                    'attribute' => 'datos.preferencias.promociones',
                    'format' => 'raw',
                    'value' => btnOnOff(
                        $model->datos->preferencias->promociones,
                        'promociones'
                    ),
                ],
                [
                    'attribute' => 'datos.preferencias.noticias',
                    'format' => 'raw',
                    'value' => btnOnOff(
                        $model->datos->preferencias->noticias,
                        'noticias'
                    ),
                ],
                [
                    'attribute' => 'datos.preferencias.resumen',
                    'format' => 'raw',
                    'value' => btnOnOff(
                        $model->datos->preferencias->resumen,
                        'resumen'
                    ),
                ],
                [
                    'attribute' => 'datos.preferencias.tour',
                    'format' => 'raw',
                    'value' => btnOnOff(
                        $model->datos->preferencias->tour,
                        'tour'
                    ),
                ],
                [
                    'format' => 'raw',
                    'label' => '',
                    'value' => function($model) {
                        return Html::button('Guardar Preferencias',
                            [
                                'id' => 'btn-guardar',
                                'class' => 'btn btn-primary hidden',
                                'data-cerrar' => '0',
                                'disabled' => true,
                            ]
                        ) .
                        Html::button('Cerrar',
                            [
                                'id' => 'btn-cerrar',
                                'class' => 'btn btn-warning hidden',
                                'data-cerrar' => '0',
                            ]
                        );
                    }
                ],
            ],
        ]) ?>
    <?php endif ?>

    <p>
        <?php if ($isAutor || $isAdmin): ?>
            <?= Html::a('Modificar',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>

            <?= Html::a('Eliminar cuenta', [
                'delete',
                'id' => $model->id
            ], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro que quieres eliminar el usuario?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </p>
</div>
