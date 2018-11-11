/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

/**
 * Validaciones de campos al crear usuario.
 */

$(document).ready(() => {
    $('#usuariosdatos-password').focusout(() => {
        var valor = $('#usuariosdatos-password').val();
        var valida = validarPassword(valor);

        if (valida !== true) {
            $('.btn-confirmar').attr('disabled', 'true');
        } else {
            $('.btn-confirmar').removeAttr('disabled');
        }

        pintarErrores('error-password', valida);
    });
});
