

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
 * @param clase La clase donde mostrar los errores.
 */
function pintarErrores(clase) {

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
 * @returns {boolean}
 */
function validarPassword(password) {
    var patron = new RegExp("^[0-9a-zA-Z\,\._-]+$");
    return patron.test(password);
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
