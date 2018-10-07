/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

(function($) {
    $(document).ready(function() {
        /**
         * Añade evento a cada avatar para marcarse al ser seleccionado y además
         * toma su numbre para el campo del formulario "avatar"
         */
        (function() {
            var images = $('#avatar-selector img');

            images.each(function() {
                $(this).click(function() {
                    // Limpio todas las imágenes
                    images.css('border-color', 'transparent');
                    images.css('box-shadow', 'none');

                    // Asigno borde de color
                    $(this).css('border-color', '#832561');
                    $(this).css('box-shadow', '3px 3px 3px #000');

                    // Añado el valor de cada imagen al campo "avatar" del form
                    let nombre = $(this).data('name');
                    $('#usuarios-avatar').val(nombre);
                });
            });
        })();

        /**
         * Muestra la sección del formulario sobre la que se ha pulsado.
         * @param seccion Recibe el elemento que se marcará activo y mostrará.
         */
        function mostrarSeccion(seccion) {
            ocultarSecciones();
            seccion.addClass('seccionactual');
        }

        /**
         * Oculta todas las secciones del formulario.
         */
        function ocultarSecciones() {
            var secciones = $('.nav-form-usuario ul li');

            secciones.removeClass('seccionactual');
        }

        /**
         * Devuelvo un array con todos los id de las secciones listadas en el
         * menú superior
         * @returns Array Con el valor de "data-seccion".
         */
        function obtenerSecciones() {
            return $('.nav-form-usuario ul li').map(function() {
                    return $(this).data('seccion');
            });
        }

        function seccionProxima() {
            var secciones = obtenerSecciones();

            ocultarSecciones();

            var seccion = $('.seccionactual').data('seccion');

            var nuevaseccionkey = secciones.each(function(idx) {
                if ($(this).data('seccion') = seccion) {
                    //return secciones.keys(idx + 1);
                    console.log(secciones.keys(idx + 1).data('seccion'));
                }
            })

            mostrarSeccion(x);
        }

        function seccionAnterior() {
            var secciones = obtenerSecciones();
        }

        /**
         * Añade funcionalidades al menú de navegación superior.
         */
        (function () {
            var secciones = $('.nav-form-usuario ul li');

            secciones.each(function() {
                $(this).click(function() {


                    mostrarSeccion($(this));
                });
            });
        })();
    });
})(jQuery);

