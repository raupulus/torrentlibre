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
         * Añade funcionalidades a los botones para recorrer el formulario
         */
        function formNavegate() {

        };

        formNavegate();
    });
})(jQuery);

