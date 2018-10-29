<?php

use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DemandasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Demandas';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();
$isGuest = Yii::$app->user->isGuest;

$columns = [
    //['class' => 'yii\grid\SerialColumn'],
    [
        'format' => 'raw',
        'value' => function($model) {
            $nombre = $model->solicitante->avatar;
            $ruta = yii::getAlias('@r_avatar');
            $imagen = $ruta.'/'.$nombre;

            if (empty($nombre) || (! file_exists($imagen))) {
                $imagen = $ruta.'/'.'default.png';
            }
            return '<img src="/'.$imagen.'" />';
        }
    ],
    'solicitante.nick:text:Solicitante',
    'titulo',
    'descripcion',
];

if ($isAdmin){
    //array_push($columns, 'id'),
    array_push($columns, ['class' => 'yii\grid\ActionColumn']);
}

?>
<div class="demandas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Demanda', ['create'], ['class' => 'btn 
        btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
</div>
