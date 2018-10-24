<?php

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
