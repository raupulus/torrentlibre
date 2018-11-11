/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

/************************************
            FORMULARIOS
*************************************/

function formValueClear() {
    $('#form-btn-clear').click(() => {
        $('form input, form select, form textarea').val('');
    });
}

/**
 * Pinta los errores existente en el elemento de la clase recibida.
 * @param clase Nombre de la clase donde mostrar los errores.
 * @param errores Array con los errores de validación a pintar.
 */
function pintarErrores(clase, errores) {
    var box = $('.'+clase);
    box.empty();

    errores.forEach((error) => {
        box.append(error+'<br />');
    });
}

/**
 * Valida una url.
 * @param web Cadena a comprobar.
 * @returns {boolean}
 */
function validarWeb(web) {
    if (web != '') {
        var patron = new RegExp("^(http(s)?:\/\/)+([w]{3}[\.])+[a-z0-9]+[\.][a-z]{2,3}$");
        return patron.test(web);
    }

    return true;
}

/**
 * Valida una contraseña recibida obligando a tener carácteres válidos.
 * @param password Contraseña a validar.
 * @returns Array Contiene los errores
 */
function validarPassword(password) {
    var numeros = new RegExp("[0-9]+");
    var caracteres = new RegExp("[a-zA-Z\,\._-]+");
    var errores = [];

    if (! numeros.test(password)) {
        errores.push('La contraseña debe contener un número (0-9)');
    }

    if (! caracteres.test(password)) {
        errores.push('La contraseña debe contener un carácter (a-zA-Z,._-)');
    }

    if (password.length <= 4) {
        errores.push('La contraseña no puede ser menor de 5 carácteres');
    }

    return (errores.length === 0) ? true : errores;
}

/**
 * Valida el correo electrónico recibido.
 * @param email Cadena con el correo electrónico
 * @returns {boolean}
 */
function validarEmail(email) {
    var patron = new RegExp("^(http(s)?:\/\/)?([w]{3}[\.])?[a-z0-9]+[\.][a-z]{2,3}$");
    return patron.test(email);
}

/**
 * Limpia el campo de twitter en un input asignado.
 * @returns String
 */
function limpiarTwitter() {
    var twitter = $(this).val();
    return twitter;
}

/**
 * Limpia el campo de facebook en un input asignado.
 * @returns String
 */
function limpiarFacebook() {
    var facebook = $(this).val();
    return facebook;
}

/**
 * Limpia el campo de Google Plus.
 * @returns String
 */
function limpiarGoogleplus() {
    var facebook = $(this).val();
    return facebook;
}
