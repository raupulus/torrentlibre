/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(function() {
    var defaultTrackers = [
        "http://tracker.tfile.me/announce",
        "udp://tracker.openbittorrent.com:80/announce",
        "udp://tracker.internetwarriors.net:1337/announce",
        "udp://tracker.sktorrent.net:6969/announce",
        "udp://tracker.opentrackr.org:1337/announce",
        "udp://tracker.coppersurfer.tk:6969/announce",
        "udp://tracker.leechers-paradise.org:6969/announce",
        "udp://tracker.zer0day.to:1337/announce",
        "udp://explodie.org:6969/announce",
        "udp://exodus.desync.com:6969/announce",
        "udp://tracker.pirateparty.gr:6969/announce",
        "udp://public.popcorn-tracker.org:6969/announce",
        "udp://tracker1.wasabii.com.tw:6969/announce",
        "udp://tracker2.wasabii.com.tw:6969/announce"
    ];

    var magnet = $('#magnet').text();

    var trackers = Array.from(document.querySelectorAll(".trackers dl a"))
                  .map(node => node.textContent.trim()).concat(defaultTrackers);

    var trackersCmps = trackers.reduce((result, uri) => result + "&tr=" + encodeURIComponent(uri), "");

    var uri = `${magnet}${trackersCmps}`;

    $('#magnet').attr('href', uri);

    /**
     * Esta función copia al portapapeles el enlace magnet
     */
    function copyMagnetToClipboard() {
        var magnet = $('#magnet').attr('href');
        var $temp = $("<input>");

        $("body").append($temp);
        $temp.val(magnet).select();
        document.execCommand("copy");
        $temp.remove();
    }

    // Asigno evento para copiar al pulsar el icono de magnet
    $('#copymagnet').click(copyMagnetToClipboard);

    /**
     * Esta función refresca las descargas al pulsar el botón "Descargar"
     */
    function recargarDescargas() {
        var btn = $('.magnet .btn');
        //var campoDescargadso = $('?????');
        // TODO → formatear detailview y cazar veces descargados
    }
});
