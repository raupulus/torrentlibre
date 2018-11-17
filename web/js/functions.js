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

    if($.isArray(errores)) {
        errores.forEach((error) => {
            box.append(error+'<br />');
        });
    }
}

/**
 * Valida una url.
 * @param web Cadena a comprobar.
 * @returns true|Array Contiene los errores
 */
function validarWeb(web) {
    var patron = new RegExp(
        "^(http(s)?:\/\/)+([w]{3}[\.])?[a-z0-9]+[\.][a-z]{2,4}$"
    );

    if ((web !== '') && (patron.test(web) === false)){
        return [
            'La url debe tener un formáto válido',
            'Ejemplo de formato: http://fryntiz.es | https://www.fryntiz.es'
        ];
    }

    return true;
}

/**
 * Valida una contraseña recibida obligando a tener carácteres válidos.
 * @param password Contraseña a validar.
 * @returns true|Array Contiene los errores
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
    var patron = new RegExp(
        "^(http(s)?:\/\/)?([w]{3}[\.])?[a-z0-9]+[\.][a-z]{2,3}$"
    );
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
    var googleplus = $(this).val();
    return googleplus;
}

/************************************
                DOM
 *************************************/

/**
 * Crea una nueva instancia de una ventana con los parámetros pasados
 * @param  {String}   origen  Ruta al documento HTML para abrir
 * @param  {String}   titulo  Nombre de la ventana
 * @param  {Integer}  ancho   Ancho de la ventana
 * @param  {Integer}  alto    Altura de la ventana
 * @param  {Integer}  top     Separación respecto la parte superior
 * @param  {Integer}  left    Separación respecto la parte izquierda
 * @return {window}           Devuelve la nueva ventana
 */
function abrirVentana(origen = '', titulo = 'New', ancho, alto, top, left) {
    return window.open(
        origen,
        titulo,
        'width='+ancho+
        ',height='+alto+
        ',top='+top+
        ',left='+left+
        ',menubar=no,resizable=yes,location=no,scrollbars=yes,status=no,toolbar=no');
}

/**
 * Devuelve la ruta absoluta del dominio, por ejemplo https://fryntiz.es/home/
 * @returns {string} Cadena con la ruta absoluta.
 */
function obtenerRutaAbsoluta() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);

    return loc.href.substring(0, loc.href.length - (
        (loc.pathname + loc.search + loc.hash).length - pathName.length)
    );
}

/**
 * Devuelve el dominio del servidor, por ejemplo https://fryntiz.es
 * @returns {string} Cadena con el dominio.
 */
function obtenerDominio() {
    return window.location.protocol + '//' + window.location.host;
}
