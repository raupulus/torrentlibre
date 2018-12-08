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
        var magnet = $('#magnet').attr('href');
        var $temp = $("<input>");

        $("body").append($temp);
        $temp.val(magnet).select();
        document.execCommand("copy");
        $temp.remove();
    }

    // Asigno evento para copiar al pulsar el icono de magnet
    $('#copymagnet').click(copyMagnetToClipboard);

    /************************************************
     **               Botón Descargar              **
     ************************************************/

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
                }
            });
        }, 3000);
    }

    // Añado evento al pulsar sobre el botón descargas para actualizar valor.
    $('#btn-torrent-download').click(recargarDescargas);

    /************************************************
     **               Votar Torrent                **
     ************************************************/

    /**
     * Modifica la puntuación para un torrent.
     * @param puntuacion Recibe puntuación del 1-10.
     * @param torrent Recibe el "id" del torrent que se puntúa.
     */
    function modificarPuntuacion(puntuacion, torrent) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/puntuacion-torrents/modificar",
            async: false,
            data: {
                'puntuacion': puntuacion,
                'torrent' : torrent
            },
            success: function(data) {
                // Caja con la media de puntuación.
                var boxPuntos = $('#torrent-puntos');

                // Puntuación media.
                var media = data.media;

                // Agrego la nueva media calculada.
                boxPuntos.empty();
                boxPuntos.html(media);
            }
        });
    }

    // Llamada al plugin de votación "star-rating"
    $('.torrentRating').starRating({
        minus: true // step minus button
    });

    // Al pulsar un valor se actualiza en la DB.
    $('.torrentRating').click(function() {
        var puntuacion = $('.torrentRating').attr('data-val');
        var torrent = $('.torrentRating').attr('data-torrent');
        modificarPuntuacion(puntuacion, torrent);
    });

    /**
     * Comprueba los puntos que el usuario actual ha dado al torrent actual
     * y pintas tantas estrellas como puntuación.
     */
    function dibujarPuntuacionEstrellas() {
        // Al iniciar se marcan las estrellas según haya votado.
        var mispuntos = $('#torrent-puntos').data('mispuntos');
        var boxTorrentRating = $('.torrentRating ul li');

        boxTorrentRating.each(function(index, value) {
            if (index +1 <= mispuntos) {
                $(this).addClass('hover active');
            }
        });
    }
    dibujarPuntuacionEstrellas();

    /************************************************
     **             Reportar Torrent               **
     ************************************************/

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
     * Muestra u Oculta el formulario para reportar comentarios.
     *
     * @param id Recibe el id del comentario.
     */
    function mostrarFormReporteComentario(id) {
        $('#comment-' + id + ' .box-reportes-comentarios').toggle();
    }

    /**
     * Valida y envía los campos para reportar formulario.
     *
     * @param id El identificador del comentario.
     * @param titulo Título del reporte.
     * @param resumen Resumen del reporte.
     * @param box Objeto que representa el comentario actual.
     */
    function reportarComentario(id, titulo, resumen, box) {
        $('.errorReporteComentarios').remove();  // Limpia errores anteriores.
        var errores = [];

        if (titulo == '') {
            errores.push('El título no puede estar vacío');
        }

        if (resumen == '') {
            errores.push('La descripción no puede estar vacía');
        }

        if (errores.length == 0) {
            $.ajax({
                type: 'GET',
                url: "/reportes-comentarios/reportar",
                data: {
                    'id': id,
                    'titulo': titulo,
                    'resumen': resumen,
                },
                timeout: 5000,
            });
            mostrarFormReporteComentario(id);
        } else {
            errores.forEach(function(ele) {
                box.find('.box-reportes-comentarios').append(
                    '<div class="errorReporteComentarios">' + ele + '</div>'
                );
            });
        }
    }

    /**
     * Prepara el botón para reportar comentario en el momento que se pulsa
     * sobre el desplegable "Reportar"
     * @param id Recibe el id del comentario.
     */
    function prepararBotonSubmit(id) {
        var box = $('#comment-' + id + ' .box-reportes-comentarios');
        var btnSubmit = box.find('.btn-enviar-reporte-comentario');

        btnSubmit.click(function() {
            var titulo = box.find('.reportar-titulo').val();
            var resumen = box.find('.reportar-descripcion').val();
            reportarComentario(id, titulo, resumen, box);
        });
    }

    // Asigna evento al botón "Responder" para desplegar formulario de Reportes.
    $('.btn-reportar-comentario').click(function() {
        var id = $(this).attr('data-comment-content-id');
        mostrarFormReporteComentario(id);
        prepararBotonSubmit(id);
    });

    /************************************************
     **             Votar Comentarios              **
     ************************************************/
    /**
     * Modifica la puntuación para un comentario.
     * @param puntuacion Recibe puntuación del 1-10.
     * @param comentario Recibe el "id" del comentario que se puntúa.
     * @param boxPuntos  Recibe la caja sobre la que pintar la nueva puntuación.
     */
    function modificarPuntuacionComentario(puntuacion, comentario, boxPuntos) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/puntuacion-comentarios/modificar",
            async: false,
            data: {
                'puntuacion': puntuacion,
                'comentario' : comentario,
            },
            success: function(data) {
                // Puntuación media.
                var media = data['media'];

                // La puntuación que el usuario actual le ha dado.
                var puntosUsuario = data['puntuado'];

                // Agrego la nueva media calculada.
                boxPuntos.empty();
                boxPuntos.html(media);
            }
        });
    }

    // Llamada al plugin de votación "star-rating"
    $('.comentarioRating').starRating({
        minus: true // step minus button
    });

    // Al pulsar un valor se actualiza en la DB.
    $('.comentarioRating').click(function() {
        var puntuacion = $(this).attr('data-val');
        var comentario = $(this).attr('data-comentario');
        var boxPuntos = $(this).parent().find('.puntos');

        modificarPuntuacionComentario(puntuacion, comentario, boxPuntos);
    });

    /**
     * Comprueba los puntos que el usuario actual ha dado a cada comentario y
     * pinta tantas estrellas como puntos tenga.
     */
    function dibujarPuntuacionComentariosEstrellas() {
        var allBoxComentarios = $('.box-votar-comentario');

        /**
         * Recorro cada comentario.
         */
        allBoxComentarios.each(function() {
            var miPuntuacion = $(this).data('mispuntos');
            var boxComentariosRating = $(this).find('ul li');

            /**
             * Marco tantas estrellas como puntos.
             */
            boxComentariosRating.each(function(index, value) {
                if (index +1 <= miPuntuacion) {
                    $(this).addClass('hover active');
                }
            });
        });
    }
    dibujarPuntuacionComentariosEstrellas();


    /************************************************
     **       ACTUALIZAR SEEDERS Y LEECHERS        **
     ************************************************/
    /**
     * Obtiene los leechers y seeders del torrent actual y lo pinta en su
     * caja correspondiente.
     */
    function getCompartiendo() {
        var torrentId = $('#btn-torrent-download').data('torrent_id');
        var boxSeeders = $('#seeders');
        var boxLeechers = $('#leechers');

        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '/torrents/compartiendo',
            data: {'id': torrentId}
        })
         .done(function(datos) {
             var seeders = datos.seeders;
             var leechers = datos.leechers;

             boxSeeders.html(
                 'Hay ' + seeders + ' seeders (Sembrando)'
             );

             boxLeechers.html(
                 'Hay ' + leechers + ' leechers (Sanguijuelas)'
             );
        });
    }

    getCompartiendo();
});
