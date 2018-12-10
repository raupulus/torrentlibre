<?php header('Content-Type: text/html; charset=UTF-8');
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:42
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

use app\helpers\Roles;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

$isAdmin = Roles::isAdmin();
$isGuest = Yii::$app->user->isGuest;

$items =  [
    ['label' => \Yii::t('main', 'home'), 'url' => ['/site/index']],
    ['label' => \Yii::t('main', 'torrents'), 'url' => ['/torrents/index']],
    ['label' => 'Solicitudes', 'url' => ['/demandas/index']],
];

if ($isGuest) {
    $tags = ['label' => \Yii::t('main', 'login'), 'url' => ['/site/login']];
    array_push($items, $tags);
}

if (! $isGuest) {
    $nick = Html::encode(Yii::$app->user->identity->nick);
    $id = Yii::$app->user->identity->id;

    if (strlen($nick) >= 20) {
        $nick = substr($nick, 0, 20);
    }

    /**
     * Agrego el Avatar del usuario.
     */
    $userAvatar = Yii::$app->user->identity->rutaImagen;
    $userAvatar ='<img class="icon-avatar" src="'.$userAvatar.'" />';
    array_push($items, $userAvatar);

    $tags = ['label' => $nick,
        'items' => [
            (
            '<li class="text-center">
                <span id="text-paginas-visitadas">Páginas Vistas:</span> 
                <i class="fa fa-eye" id="paginasVisitadas"></i>
            </li>'
            ),
            ['label' => 'Mi Perfil', 'url' => [
                '/usuarios/view?id='.$id
            ]],
            ['label' => 'Ver Usuarios', 'url' => [
                '/usuarios/index'
            ]],
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    \Yii::t('main', 'logout').' (' .
                    Html::encode(Yii::$app->user->identity->nick) . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ];
    array_push($items, $tags);
}

if ($isAdmin) {
    $tags = ['label' => 'Administrar',
        'items' => [
            ['label' => 'Reportes Torrents', 'url' => [
                '/reportes-torrents/index'
            ]],
            ['label' => 'Reportes Comentarios', 'url' => [
                '/reportes-comentarios/index'
            ]],
            ['label' => 'Estadísticas', 'url' => [
                '/site/estadisticas'
            ]],
        ],
    ];
    array_push($items, $tags);
}


NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'brandImage' => '/images/brand.png',
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top no-print',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right no-print'],
    'items' => $items,
]);
NavBar::end();
?>
