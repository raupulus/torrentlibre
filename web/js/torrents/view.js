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
        var id = $('#btn-torrent-download').data('torrent_id');

        setTimeout(function() {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: "/torrents/obtenerdescargas",
                async: false,
                data: { 'id': id },
                timeout:5000,  // Tiempo a esperar antes de dar error
                success: function(data) {
                    $('#torrents-veces-descargado').text(data);
                },
            });
        }, 3000);
    }

    // Añado evento al pulsar sobre el botón descargas para actualizar valor.
    $('#btn-torrent-download').click(recargarDescargas);


    function modificarPuntuacion(puntuacion, torrent) {
        $.ajax({
            type: 'GET',
            url: "/puntuacion-torrents/modificar",
            async: false,
            data: {
                'puntuacion': puntuacion,
                'torrent' : torrent,
            },
            timeout:5000,
        });
    }

    // Llamada al plugin de votación "star-rating"
    $('.rating').starRating({
        minus: true // step minus button
    });

    // Al pulsar un valor se actualiza en la DB.
    $('.rating').click(function() {
        var puntuacion = $('.rating').attr('data-val');
        var torrent = $('.rating').attr('data-torrent');
        modificarPuntuacion(puntuacion, torrent);
        window.location = '/torrents/view?id='+torrent;
    });

    /**
     * Muestra el formulario para reportar torrent.
     */
    function mostrarFormReportar() {
        $('#box-reportes').toggle(1000);
    }

    // Añade evento para mostrar u ocultar formulario de reportes.
    $('#btn-reportar').click(mostrarFormReportar);

    /**
     * Reporta el torrent actual.
     */
    function enviarReporte() {
        $('.errorReporte').remove();  // Limpia errores anteriores.
        var titulo = $('#reportar-titulo').val();
        var descripcion = $('#reportar-descripcion').val();
        var torrent = $('#box-reportes').attr('data-torrent');
        var errores = [];

        if (titulo == '') {
            errores.push('El título no puede estar vacío');
        }

        if (descripcion == '') {
            errores.push('La descripción no puede estar vacía');
        }

        if (errores.length == 0) {
            $.ajax({
                type: 'GET',
                url: "/reportes-torrents/reportar",
                async: true,
                data: {
                    'torrent' : torrent,
                    'titulo': titulo,
                    'descripcion' : descripcion,
                },
                success: function() {
                    $('#box-reportes').hide();
                    $('#btn-reportar').hide();
                    $('#reportar-terminado').show();
                },
                timeout: 5000,
            });
        } else {
            errores.forEach(function(ele) {
                $('#box-reportes').append(
                    '<div class="errorReporte">' + ele + '</div>'
                );
            });
        }
    }

    // Evento al botón que envía el reporte.
    $('#btn-enviar-reporte').click(enviarReporte);

    /************************************************
     **           Reportar Comentarios             **
     ************************************************/

    /**
     * Muestra el formulario para reportar comentarios.
     */
    function mostrarFormReporteComentario(id) {
        $('#comment-' + id + ' .box-reportes-comentarios').toggle();
    }

    /**
     * Valida y envía los campos para reportar formulario.
     */
    function reportarComentario(id, titulo, resumen) {

        $.ajax({
            type: 'POST',
            url: "/reportar-comentarios/reportar",
            data:{
                'id': id,
                'titulo': titulo,
                'resumen': resumen,
            },
            timeout: 5000,
        });
    }

    function prepararBotonSubmit(id) {
        var box = $('#comment-' + id + ' .box-reportes-comentarios');
        var btnSubmit = box.find('.btn-enviar-reporte-comentario');

        btnSubmit.click(function() {
            var titulo = box.find('.reportar-titulo').val();
            var resumen = box.find('.reportar-descripcion').val();

            console.log(id, titulo, resumen);
            reportarComentario(id, titulo, resumen);
            mostrarFormReporteComentario(id);
        })


    }

    $('.btn-reportar-comentario').click(function() {
        var id = $(this).attr('data-comment-content-id');
        var titulo = $(this).attr('data-comment-content-id');
        var resumen = $(this).attr('data-comment-content-id');

        mostrarFormReporteComentario(id);
        prepararBotonSubmit(id);
    });




});
