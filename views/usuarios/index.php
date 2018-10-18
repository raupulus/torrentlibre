<?php

/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use app\assets\UsuariosIndexAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\helpers\Roles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

// Registro assets para esta vista
UsuariosIndexAsset::register($this);

// Variables
$isAdmin = Roles::isAdmin();
?>

<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Esta vista solo la puede ver el administrador -->
    <?php if ($isAdmin): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'class' => 'grid-view',
            'tableOptions' => [
                'class' => 'tablaUsuariosIndex'
            ],
            'filterRowOptions' => [
                'class' => 'trSearch'
            ],
            'columns' => [
                'id',
                [
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->datos->nombre, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],
                [
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->datos->nick, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],
                'rol.tipo',  // Tipo de rol
                'datos.email:email',
                'datos.lastlogin_at:datetime',
                'datos.web',
                'datos.biografia',
                'datos.twitter',
                'datos.facebook',
                'datos.googleplus',
                [
                    'attribute' => 'bloquear',
                    'format' => 'raw',
                    'value' => function($model) {
                        if (isset($model->usuariosBloqueados->usuario)) {
                            return Html::a('Desbloquear', [
                                Url::to('usuarios-bloqueados/desbloquear'),
                                'id' => $model->usuariosBloqueados->id
                            ],
                                [
                                    'class' => 'btn btn-success',
                                    'data' => [
                                        'method' => 'post',
                                    ],

                                ]
                            );
                        } else {
                            return Html::a('Bloquear', [
                                Url::to('usuarios-bloqueados/bloquear'),
                                'id' => $model->id,

                            ],
                                [
                                    'class' => 'btn btn-danger',
                                ]
                            );
                        }
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?php else: ?>
        <!-- Esta vista la puede ver cualquier usuario registrado -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'class' => 'grid-view',
            'tableOptions' => [
                'class' => 'tablaUsuariosIndex'
            ],
            'filterRowOptions' => [
                'class' => 'trSearch'
            ],
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

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

                [
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->datos->nick, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],

                'datos.nombre',
                'datos.web',
                'datos.biografia',
                'datos.email:email',
                'datos.twitter',
                'datos.facebook',
                'datos.googleplus',
            ],
        ]); ?>
    <?php endif; ?>
</div>
