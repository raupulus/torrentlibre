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

$redesSociales = [
    'label' => '',
    'format' => 'raw',
    'value' => function($model) {
        $web = $model->datos->web;
        $facebook = 'https://facebook.com/' .
            $model->datos->facebook;
        $twitter = 'https://twitter.com/' .
            $model->datos->twitter;
        $gplus = 'https://plus.google.com/' .
            $model->datos->googleplus;
        $dir_iconos = yii::getAlias('@r_iconos');

        $imgs = '<a href="'.$facebook.'" class="user-social">';
        $imgs .= '<img src="/'.$dir_iconos.'/facebook.png"/></a>';

        $imgs .= '<a href="'.$twitter.'" class="user-social">';
        $imgs .= '<img src="/'.$dir_iconos.'/twitter.png"/></a>';

        $imgs .= '<a href="'.$gplus.'" class="user-social">';
        $imgs .= '<img src="/'.$dir_iconos.'/gplus.png"/></a>';

        return $imgs;
    }
];

$columns = [
    [
        'format' => 'raw',
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
    [
        'label' => 'Nick',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a($model->datos->nick, [
                Url::to('usuarios/view'),
                'id' => $model->id
            ]);
        }
    ],
    'datos.biografia',
    [
        'attribute' => 'datos.web',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a($model->datos->web, $model->datos->web,
                [
                    'class' => 'btn'
                ]);
        }
    ],
    $redesSociales,
];

$columnsAdmin = [
    'id',
    [
        'label' => 'Nombre',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a($model->datos->nombre, [
                Url::to('usuarios/view'),
                'id' => $model->id
            ]);
        }
    ],
    'rol.tipo:text:Rol',  // Tipo de rol
    'datos.email:email',
    'datos.lastlogin_at:datetime',
    [
        'attribute' => '',
        'format' => 'raw',
        'value' => function($model) {
            $buttons = '';
            if (isset($model->usuariosBloqueados->usuario)) {
                $buttons .=  Html::a('Desbloquear', [
                    Url::to('usuarios-bloqueados/desbloquear'),
                    'id' => $model->usuariosBloqueados->id
                ],
                    [
                        'class' => 'btn btn-warning btn-admin',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]
                );
            } else {
                $buttons .=  Html::a('Bloquear', [
                    Url::to('usuarios-bloqueados/bloquear'),
                    'id' => $model->id,
                ],
                    [
                        'class' => 'btn btn-danger btn-admin',
                    ]
                );
            }
            $buttons .=  Html::a('Ver', [
                Url::to('usuarios/view'),
                'id' => $model->id,
            ],
                [
                    'class' => 'btn btn-success btn-admin',
                ]
            );
            if ($model->rol->tipo == 'tmp') {
                $buttons .=  Html::a('Aprobar', [
                    Url::to('usuarios/aprobar'),
                    'id' => $model->id
                ],
                    [
                        'class' => 'btn btn-warning btn-admin',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]
                );
            }
            $buttons .=  Html::a('Modificar', [
                Url::to('usuarios/update'),
                'id' => $model->id,
            ],
                [
                    'class' => 'btn btn-primary btn-admin',
                ]
            );
            $buttons .=  Html::a('Eliminar', [
                Url::to('usuarios/delete'),
                'id' => $model->id,
            ],
                [
                    'class' => 'btn btn-danger btn-admin',
                    'data' => [
                        'confirm' => '¿Estás seguro que quieres eliminar el usuario?',
                        'method' => 'post',
                    ],
                ]
            );

            return $buttons;
        }
    ],
];

if ($isAdmin) {
    foreach ($columnsAdmin as $col) {
        array_push($columns, $col);
    }
}
?>

<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

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
        'columns' => $columns,
    ]); ?>
</div>
