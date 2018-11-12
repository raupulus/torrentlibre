/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {
    /**
     * Muestra la ventana de preferencias y devuelve los valores capturados.
     */
    function mostrarVentanaPreferencias() {
        return [true, true, true]
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
        var btn = $('#btn-modificar-preferencias');
        mostrarVentanaPreferencias();
        actualizarPreferencias();
    }

    /*
     * Agrego evento para mostrar una ventana flotante con las preferencias.
     */
    $('#btn-modificar-preferencias').click(modificarPreferencias);
});
