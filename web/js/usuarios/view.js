/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {
    /**
     * Muestra la ventana de preferencias y devuelve los valores capturados.
     */
    function crearVentanaPreferencias() {
        var origen = '';
        var titulo = 'Preferencias de usuario';

        return abrirVentana(origen, titulo, 300, 200);
    }

    /**
     * Actualiza los valores en el DOM para las preferencias.
     */
    function actualizarPreferencias(objetoPreferencias) {

    }

    /**
     * Contiene la lógica para abrir la ventana con las preferencias.
     */
    function modificarPreferencias() {
        var preferencias = document.getElementById('tabla-preferencias');
        var btn = $('#btn-modificar-preferencias');
        var ventana = crearVentanaPreferencias();
        var rutaAbsoluta = obtenerDominio();

        // Agrego nodo con la tabla en la nueva ventana.
        var hojaCss = document.createElement('link');
        var hojaJs = document.createElement('script');
        hojaCss.href = rutaAbsoluta + '/css/usuarios/preferencias.css';
        hojaCss.rel = 'stylesheet';
        hojaJs.src = rutaAbsoluta + '/js/usuarios/preferencias.js';

        ventana.document.head.appendChild(hojaCss);
        ventana.document.head.appendChild(hojaJs);
        ventana.document.body.appendChild(preferencias.cloneNode(true));
        ventana.focus();


        actualizarPreferencias();
    }

    /*
     * Agrego evento para mostrar una ventana flotante con las preferencias.
     */
    $('#btn-modificar-preferencias').click(modificarPreferencias);
});
