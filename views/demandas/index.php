<?php

use app\assets\DemandasIndexAsset;
use app\helpers\Roles;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DemandasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Registro assets para esta vista
DemandasIndexAsset::register($this);

$this->title = 'Demandas';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = Roles::isAdmin();
$isGuest = Yii::$app->user->isGuest;

$columns = [
    //['class' => 'yii\grid\SerialColumn'],
    [
        'format' => 'raw',
        //'headerOptions' => ['class' => 'text-center']
        'contentOptions' => ['class' => 'box-demandas-index-avatar'],
        'value' => function($model) {
            $nombre = $model->solicitante->avatar;
            $ruta = yii::getAlias('@r_avatar');
            $imagen = $ruta.'/'.$nombre;

            if (empty($nombre) || (! file_exists($imagen))) {
                $imagen = $ruta.'/'.'default.png';
            }
            return '<img class="demandas-index-avatar" src="/'.$imagen.'" />';
        }
    ],
    [
        'attribute' => 'solicitante.nick',
        'label' => 'Solicitante',
        'contentOptions' => ['class' => 'box-demandas-nick'],
    ],
    [
        'attribute' => 'titulo',
        'contentOptions' => ['class' => 'box-demandas-titulo'],
    ],
    'descripcion',
    [
        'format' => 'raw',
        'contentOptions' => ['class' => 'box-demandas-btn'],
        'value' => function($model) {
            $solicitante = $model->solicitante_id;
            $atendedor = $model->atendedor_id;
            $usuario = Yii::$app->user->id;

            if (($usuario != $solicitante) && ($atendedor == null)) {
                return '<span class="btn-subir-demanda btn btn-xs btn-warning"' .
                    'data-demandaid="' . $model->id . '">' .
                    'Yo lo subo' .
                    '</span>';
            }

            if ($atendedor != null) {
                return 'Demanda atendida por: <br />' . $model->atendedor->nick;
            }

            return 'Esta demanda es tuya';
        }
    ],
];

if ($isAdmin){
    //array_push($columns, 'id'),
    array_push($columns, ['class' => 'yii\grid\ActionColumn']);
}

?>
<div class="demandas-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div id="demandas-info" class="row col-xs-8 col-xs-offset-2">
        <p>
            Aquí puedes solicitar contenido para que otros usuarios puedan
            subirlo y/o conocer lo que otros usuarios demandan.
        </p>

        <p>
            Permanecerá cada demanda activa durante 30 días y luego será
            automáticamente excluida si nadie promete subir ese contenido.
        </p>
    </div>

    <div class="row col-xs-12 text-center">
        <p>
            <?= Html::a('Nueva Demanda', ['create'], ['class' => 'btn 
        btn-success']) ?>
        </p>
    </div>


    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Demandas Activas -->
    <div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'id' => 'demandas-index-gridview',
            'class' => 'demandas-index-class',
            'summary' => false,  // Oculto total de elementos
            'showHeader' => false,
            //'showFooter' => false,
            'emptyCell' => 'N/D',
            'tableOptions' => [
                'class' => 'tablaDemandasIndex',
            ],
            'pager' => [
                'class' => \kop\y2sp\ScrollPager::className(),
                'container' => '#demandas-index-gridview tbody',
                'item' => 'tr',
                'noneLeftText' => '',  // No muestra mensaje final
                'triggerOffset' => 1000,
                'negativeMargin' => 100,
                'delay' => 0,
                'spinnerSrc'=> yii::getAlias('@r_img').'/load-torrent.gif',
                'paginationSelector' => '.grid-view .pagination',
                'enabledExtensions'=> [
                    \kop\y2sp\ScrollPager::EXTENSION_TRIGGER,
                    \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
                    \kop\y2sp\ScrollPager::EXTENSION_NONE_LEFT,
                    \kop\y2sp\ScrollPager::EXTENSION_PAGING
                ],
            ],
            'columns' => $columns,
        ]); ?>
    </div>

</div>
