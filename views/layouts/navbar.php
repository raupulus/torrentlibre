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
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => \Yii::t('main', 'home'), 'url' => ['/site/index']],
        ['label' => \Yii::t('main', 'users'), 'url' => ['/usuarios/index']],
        ['label' => \Yii::t('main', 'torrents'), 'url' => ['/torrents/index']],
        ['label' => \Yii::t('main', 'about'), 'url' => ['/site/about']],
        ['label' => \Yii::t('main', 'contact'), 'url' => ['/site/contact']],
        Yii::$app->user->isGuest ? (
        ['label' => \Yii::t('main', 'login'), 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                \Yii::t('main', 'home').'(' .
                Yii::$app->user->identity->nick . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
?>
