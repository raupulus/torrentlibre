<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 23/10/18
 * Time: 15:05
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Aviso Legal';

?>
<div class="site-avisolegal container">
    <h1>Políticas de Cookies <span>TorrentLibre</span></h1>

    <div class="nav navbar-link">
        <ul>
            <li><?= Html::a('Aviso Legal', ['site/avisolegal']) ?></li>
            <li><?= Html::a('Política de Privacidad',
                    ['site/politicaprivacidad']) ?></li>
        </ul>
    </div>

    <section class="row col-sm-12">
        <h2>POLÍTICA DE COOKIES</h2>
        <div>
            <p>
                Deseamos informarte que Sitio Web utiliza cookies para medir y analizar la navegación de nuestros usuarios.
            </p>

            <p>
                Las cookies son unos archivos que se instalan en el equipo desde el que accedes a Sitio Web con las finalidades que se describen en esta página.
            </p>

            <p>
                Las aplicaciones que utilizamos para obtener información de la navegación, medir y analizar la audiencia son:
                <ul>
                    <li>Google Analytics http://www.google.com/policies/technologies/cookies/</li>
                </ul>
            </p>

            <p>
                Estas aplicaciones han sido desarrolladas por Google que nos prestan el servicio de medición y análisis de la audiencia de nuestras páginas. Asimismo ellas mismas pueden utilizar estos datos para mejorar sus propios servicios y para ofrecer servicios a otras empresas. Puedes conocer esos otros usos desde los enlaces indicados.
            </p>

            <p>
                Estas herramientas no obtienen datos sobre tu nombre o apellidos ni de la dirección postal desde donde te conectas. La información que obtienen está relacionada con el número de páginas visitas, el idioma, red social en la que se publican nuestras noticias, la ciudad a la que está asignada la dirección IP desde la que accedes, el número de nuevos usuarios, la frecuencia y reincidencia de las visitas, el tiempo de visita, el navegador y el operador o tipo de terminal desde el que se realiza la visita.
            </p>

            <p>
                Esta información la utilizamos para mejorar nuestras páginas, detectar nuevas necesidades y valorar las mejoras a introducir con la finalidad de prestar un mejor servicio a los usuarios que nos visitan adaptándolas por ejemplo a los navegadores o terminales más utilizados.
            </p>

            <p>
                Para permitir, conocer, bloquear o eliminar las cookies instaladas en tu equipo puedes hacerlo mediante la configuración de las opciones del navegador instalado en tu ordenador.
                Puedes encontrar información sobre cómo hacerlo en el caso que uses como navegador:
                <ul>
                    <li>
                        Firefox https://support.mozilla.org/es/kb/cookies-informacion-que-los-sitios-web-guardan-en-?esab=a&s=politic+cookies&r=0&as=s
                    </li>

                    <li>
                        Chrome https://support.google.com/chrome/bin/answer.py?hl=es&answer=95647
                    </li>

                    <li>
                        Explorer https://support.microsoft.com/es-es/help/278835/how-to-delete-cookie-files-in-internet-explorer
                    </li>

                    <li>
                        Edge https://privacy.microsoft.com/es-es/windows-10-microsoft-edge-and-privacy
                    </li>

                    <li>
                        Safari https://support.apple.com/kb/PH21411?viewlocale=es_ES&locale=es_ES
                    </li>
                </ul>
            </p>
        </div>
    </section>
</div>
