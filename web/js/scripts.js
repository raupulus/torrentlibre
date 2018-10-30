/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {
    /**
     * Inicializo Plugins Propios
     */
    $.leftbar(
        {
            letras_color: '#bfca02',       // Color de letras título
            letras_background: '#00334e',  // Color de fondo letras
            letras_borde: '#832561',       // Color del borde para de letras
        },
        [
            ['Torrents', '/images/leftbar/torrents.jpg', '/torrents/index'],
            ['Demandas', '/images/leftbar/demandas.jpg', '/demandas/index'],
            ['Social', '/images/leftbar/redes.jpg', '/site/social'],
        ]);

    /**
     * Inicializo Plugins Extras
     */
});
