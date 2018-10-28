/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

(function($) {
    $(document).ready(function() {
        /* Oculto formularios al comenzar */
        $('.usuarios-form .form-dividido').hide();

        /* Muestro solo la primera parte del formulario */
        $('.usuarios-form .form-dividido').first().show();



        /**
         * Añade evento a cada avatar para marcarse al ser pulsado y además
         * toma su nombre para el campo del formulario "avatar"
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
                    $('#usuariosdatos-avatar').val(nombre);
                    console.log(nombre);
                });
            });
        })();

        /**
         * Oculta todas las secciones del formulario.
         */
        function ocultarSecciones() {
            $('.usuarios-form .form-dividido').hide();
            var secciones = $('.nav-form-usuario ul li');
            secciones.removeClass('seccionactual');
        }

        /**
         * Muestra la sección del formulario sobre la que se ha pulsado.
         * @param seccion Recibe el elemento que se marcará activo y mostrará.
         */
        function mostrarSeccion(seccion) {
            ocultarSecciones();
            seccion.addClass('seccionactual');

            /* Muestro solo la primera parte del formulario */
            $('#' + seccion.data('seccion')).show();
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
            var secciones = obtenerSecciones().toArray();
            var seccionActual = $('.seccionactual').data('seccion');

            var esperado = false;
            for (let ele in secciones) {
                if (ele == secciones.length) {
                    break;
                } else if (esperado == true) {
                    ocultarSecciones();
                    mostrarSeccion(
                        $('.nav-form-usuario ul li[data-seccion=' + secciones[ele] + ']')
                    );
                    break;
                } else if (secciones[ele] == seccionActual) {
                    esperado = true;
                }
            };
        }

        function seccionAnterior() {
            var secciones = obtenerSecciones().toArray();
            var seccionActual = $('.seccionactual').data('seccion');

            var esperado = false;
            for (let ele = secciones.length; ele >= 0; ele--) {
                if (esperado == true) {
                    ocultarSecciones();
                    mostrarSeccion(
                        $('.nav-form-usuario ul li[data-seccion=' + secciones[ele] + ']')
                    );
                    break;
                } else if (secciones[ele] == seccionActual) {
                    esperado = true;
                    continue;
                }
            }
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

        /**
         * Añade funcionalidades a las flechas de navegación.
         */
        (function () {
            var anterior = $('#btn-form-usuarios-anterior').click(seccionAnterior);
            var proximo = $('#btn-form-usuarios-siguiente').click(seccionProxima);
        })();
    });
})(jQuery);

