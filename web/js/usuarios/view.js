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

    function actualizarPreferenciasAjax(ventana) {
        var id = $('#tabla-preferencias').data('id');

        var promociones = ventana.document.getElementById('btn-onOff-promociones');
        var noticias = ventana.document.getElementById('btn-onOff-noticias');
        var resumen = ventana.document.getElementById('btn-onOff-resumen');
        var tour = ventana.document.getElementById('btn-onOff-tour');

        promociones = promociones.dataset.activado;
        noticias = noticias.dataset.activado;
        resumen = resumen.dataset.activado;
        tour = tour.dataset.activado;

        $.ajax({
            type: 'POST',
            url: '/preferencias/update',
            async: false,
            data: {
                'id': id,
                'promociones': promociones,
                'noticias': noticias,
                'resumen': resumen,
                'tour': tour
            },
            success: (data) => {
                if (promociones == 0) {
                    $('#btn-onOff-promociones').removeClass('active');
                    $('#btn-onOff-promociones').data('activado', 0);
                } else {
                    $('#btn-onOff-promociones').addClass('active');
                    $('#btn-onOff-promociones').data('activado', 1);
                }

                if (noticias == 0) {
                    $('#btn-onOff-noticias').removeClass('active');
                    $('#btn-onOff-noticias').data('activado', 0);
                } else {
                    $('#btn-onOff-noticias').addClass('active');
                    $('#btn-onOff-noticias').data('activado', 1);
                }

                if (resumen == 0) {
                    $('#btn-onOff-resumen').removeClass('active');
                    $('#btn-onOff-resumen').data('activado', 0);
                } else {
                    $('#btn-onOff-resumen').addClass('active');
                    $('#btn-onOff-resumen').data('activado', 1);
                }

                if (tour == 0) {
                    $('#btn-onOff-tour').removeClass('active');
                    $('#btn-onOff-tour').data('activado', 0);
                } else {
                    $('#btn-onOff-tour').addClass('active');
                    $('#btn-onOff-tour').data('activado', 1);
                }
            }
        });
    }

    /**
     * Actualiza los valores en el DOM para las preferencias.
     */
    function actualizarPreferencias(ventana) {
        var cerrar = false;
        var guardar = false;

        var comprobar = setInterval(() => {
            cerrar = ventana.document.getElementById('btn-cerrar').dataset.cerrar;
            guardar = ventana.document.getElementById('btn-guardar').dataset.cerrar;

            if (cerrar == 1) {
                ventana.close();
                clearInterval(comprobar);
            } else if (guardar == 1) {
                actualizarPreferenciasAjax(ventana);
                ventana.close();
                clearInterval(comprobar);
            }
        }, 1000);
    }

    /**
     * Contiene la lógica para abrir la ventana con las preferencias.
     */
    function modificarPreferencias() {
        var preferencias = document.getElementById('tabla-preferencias');
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
        hojaCss1.href = 'https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
        hojaCss1.rel = 'stylesheet';
        hojaJs.src = rutaAbsoluta + '/js/usuarios/preferencias.js';
        hojaJs1.src = 'https://code.jquery.com/jquery-3.3.1.min.js';
        hojaJs2.src = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';

        ventana.document.head.appendChild(hojaCss);
        ventana.document.head.appendChild(hojaCss1);
        ventana.document.head.appendChild(hojaJs);
        ventana.document.head.appendChild(hojaJs1);
        ventana.document.head.appendChild(hojaJs2);
        ventana.document.body.appendChild(preferencias.cloneNode(true));

        var buttons = ventana.document.getElementsByTagName('button');
        Array.prototype.slice.call(buttons).forEach((ele) => {
            ele.classList.remove('btn-no-interactive');
            ele.onclick = () => {
                if (ele.dataset.activado == 0) {
                    ele.dataset.activado = 1;
                } else {
                    ele.dataset.activado = 0;
                }
            };
        });

        ventana.document.getElementById('btn-guardar').classList
            .remove('hidden');

        ventana.document.getElementById('btn-cerrar').classList
            .remove('hidden');

        ventana.document.getElementById('btn-guardar').onclick = function() {
            ventana.document.getElementById('btn-guardar').dataset.cerrar = 1;
        };

        ventana.document.getElementById('btn-cerrar').onclick = function() {
            ventana.document.getElementById('btn-cerrar').dataset.cerrar = 1;
        };

        ventana.focus();

        // Cada 2 segundos se comprueba si ha pulsado guardar
        actualizarPreferencias(ventana);
    }

    /*
     * Agrego evento para mostrar una ventana flotante con las preferencias.
     */
    $('#btn-modificar-preferencias').click(modificarPreferencias);
});
