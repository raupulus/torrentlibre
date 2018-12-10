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
            ['Inicio', '/images/leftbar/home.jpg', '/site/index'],
            ['Torrents', '/images/leftbar/torrents.jpg', '/torrents/index'],
            ['Demandas', '/images/leftbar/demandas.jpg', '/demandas/index'],
            ['Social', '/images/leftbar/redes.jpg', '/site/social'],
            ['Agregar', '/images/leftbar/agregar.jpg', '/torrents/create'],
        ]
    );

    /**
     * Cookie con cantidad de páginas visitadas en esta sesión.
     */
    function registrarPaginaVisitada() {
        // Si no existe cookie crearla y si existe sumo uno
        var visitas = getCookie('visitas');
        setCookie('visitas', ++visitas, null,'/');

        // Agregar el valor a la caja de páginas visitadas.
        $('#paginasVisitadas').text(++visitas);
    }

    registrarPaginaVisitada();
});
