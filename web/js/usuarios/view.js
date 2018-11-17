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

        return abrirVentana(origen, titulo, 500, 350);
    }

    function actualizarPreferenciasAjax() {
        console.log('Actualizar preferencias');
    }

    /**
     * Actualiza los valores en el DOM para las preferencias.
     */
    function actualizarPreferencias(ventana) {
        var cerrar = false;
        var guardar = false;

        var comprobar = setInterval(() => {
            cerrar = ventana.document.getElementById('btn-guardar').dataset.cerrar;
            //guardar =
            // ventana.document.getElementById('btn-cerrar').dataset.cerrar;
            guardar = $(ventana).find('btn-cerrar').data('cerrar');



            console.log(cerrar);
            console.log(guardar);
            if (cerrar == true) {
                ventana.close();
                comprobar.stop();
            } else if (guardar == true) {
                actualizarPreferenciasAjax();
                ventana.close();
                comprobar.stop();
            }
        }, 2000);
    }

    /**
     * Contiene la lógica para abrir la ventana con las preferencias.
     */
    function modificarPreferencias() {
        var preferencias = document.getElementById('tabla-preferencias');
        var btn = $('#btn-modificar-preferencias');
        var rutaAbsoluta = obtenerDominio();
        var ventana = crearVentanaPreferencias();

        // Agrego nodo con la tabla en la nueva ventana.
        var hojaCss = document.createElement('link');
        var hojaCss1 = document.createElement('link');
        var hojaJs = document.createElement('script');
        var hojaJs1 = document.createElement('script');
        var hojaJs2 = document.createElement('script');
        hojaCss.href = rutaAbsoluta + '/css/usuarios/preferencias.css';
        hojaCss.rel = 'stylesheet';
        hojaCss1.href = 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css';
        hojaCss1.rel = 'stylesheet';
        hojaJs.src = rutaAbsoluta + '/js/usuarios/preferencias.js';
        hojaJs1.src = 'https://code.jquery.com/jquery-3.3.1.min.js';
        hojaJs2.src = 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js';

        ventana.document.head.appendChild(hojaCss);
        ventana.document.head.appendChild(hojaCss1);
        ventana.document.head.appendChild(hojaJs);
        ventana.document.head.appendChild(hojaJs1);
        ventana.document.head.appendChild(hojaJs2);
        ventana.document.body.appendChild(preferencias.cloneNode(true));
        ventana.focus();

        // Cada 2 segundos se comprueba si ha pulsado guardar
        actualizarPreferencias(ventana);
    }

    /*
     * Agrego evento para mostrar una ventana flotante con las preferencias.
     */
    $('#btn-modificar-preferencias').click(modificarPreferencias);
});
