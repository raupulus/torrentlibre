/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {
    /**
     * Inicializo Plugins Propios
     */
    $.leftbar({},
        /*
        {
            back1: 'rgba(0, 11, 255,1)',   // Degradado → 0%
            back2: 'rgba(255, 164, 0,1)',  // Degradado → 20%
            back3: 'rgba(255, 0, 109,1)',  // Degradado → 45%
            back4: 'rgba(255, 164, 0,1)',  // Degradado → 100%
            letras_color: '#FFD500',       // Color de letras título
            letras_background: '#cc6633',  // Color de fondo letras
            letras_borde: '#000BFF',       // Color del borde para de letras
        },
        */
        [
            ['Torrents','./images/1.jpg','/torrents/index'],
            ['Demandas','./images/2.jpg','/demandas/index'],
            ['Redes Sociales','./images/3.jpg','/site/social'],
        ]);

    /**
     * Inicializo Plugins Extras
     */
});
