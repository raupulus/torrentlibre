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
