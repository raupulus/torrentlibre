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

$items =  [
    ['label' => \Yii::t('main', 'home'), 'url' => ['/site/index']],
    ['label' => \Yii::t('main', 'users'), 'url' => ['/usuarios/index']],
    ['label' => \Yii::t('main', 'torrents'), 'url' => ['/torrents/index']],
    ['label' => 'Demandas', 'url' => ['/demandas/index']],
    Yii::$app->user->isGuest ? (
    ['label' => \Yii::t('main', 'login'), 'url' => ['/site/login']]
    ) : (
        '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            \Yii::t('main', 'logout').' (' .
            Yii::$app->user->identity->nick . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>'
    ),
    (
        '<li><i class="fa fa-eye" id="paginasVisitadas"></i></li>'
    ),
];

if ($isAdmin) {
    $tags = ['label' => 'Adminstrar',
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
