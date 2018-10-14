/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(function() {
    /**
     * Esta función copia al portapapeles el enlace magnet
     */
    function copyMagnetToClipboard() {
        var magnet = $('#magnet').text();
        var $temp = $("<input>");

        $("body").append($temp);
        $temp.val(magnet).select();
        document.execCommand("copy");
        $temp.remove();
    }

    // Asigno evento para copiar al pulsar el icono de magnet
    $('#copymagnet').click(copyMagnetToClipboard);
});
