<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

use \rudissaar\cookieconsent\widgets\CookieWidget;
use yii\helpers\Url;

$politicaCookies = Url::to(['site/politicacookies']);
?>


<?= CookieWidget::widget([
    'message' => 'Este sitio web no utiliza cookies pero hemos puesto el cartel para molestar como todo el mundo.',
    'dismiss' => 'Consentir',
    'learnMore' => 'Más Información',
    'link' => $politicaCookies,
    'theme' => 'dark-bottom',
    'expiryDays' => 365,
    'target' => '_blank',
]); ?>
