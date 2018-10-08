<?php

use app\assets\UsuariosIndexAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

// Registro assets para esta vista
UsuariosIndexAsset::register($this);

// Variables
if (!Yii::$app->user->isGuest) {
    $rol = Yii::$app->user->identity->rol;
}
?>

<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h3>Usuarios Registrados</h3>

    <!-- Esta vista solo la puede ver el administrador -->
    <?php if (isset($rol) && ($rol === 'admin')): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
                    'attribute' => 'nombre',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->nombre, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],
                [
                    'attribute' => 'nick',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->nick, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],
                'usuariosId.rol.tipo',  // Tipo de rol
                'email:email',
                'lastlogin_at',
                'usuariosId.ip',
                'web',
                'biografia',
                'twitter',
                'facebook',
                'googleplus',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?php else: ?>
        <!-- Esta vista la puede ver cualquier usuario registrado -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
                    'attribute' => 'avatar',
                    'format' => 'raw',
                    'value' => function($model, $key, $index) {
                        $img = $model->avatar;
                        $ruta = yii::getAlias('@r_avatar').'/';

                        if ((! isset($img)) || (! file_exists($ruta.$img))) {
                            $img = 'default.png';
                        }

                        return '<img src="'.$ruta.$img.'" />';
                    }
                ],

                [
                    'attribute' => 'nick',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->nick, [
                            Url::to('usuarios/view'),
                            'id' => $model->id
                        ]);
                    }
                ],

                'nombre',
                'web',
                'biografia',
                'email:email',
                'twitter',
                'facebook',
                'googleplus',
            ],
        ]); ?>
    <?php endif; ?>
</div>
