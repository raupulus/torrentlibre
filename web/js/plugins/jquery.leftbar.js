/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2017 Raúl Caro Pastorino
 * @license https://wwww.gnu.org/licenses/gpl.txt
**/

(function($) {
    /**
     * Recibe un objeto con la configuración para personalizar el plugin y
     * un array con la información de cada menú que contendrá la barra lateral.
     * @param  {Objetct} options  Objeto de configuración
     * @param  {Array}   entradas Array que contiene un array por cada entrada
     *                   [0] → Nombre del menú
     *                   [1] → Imagen de miniatura 120x80px
     *                   [2] → Enlace hacia donde llevará
     */
    $.leftbar = function(options, entradas) {
        var conf = {
            back1: 'rgba(242,246,248,1)',  // Degradado → 0%
            back2: 'rgba(216,225,231,1)',  // Degradado → 20%
            back3: 'rgba(181,198,208,1)',  // Degradado → 45%
            back4: 'rgba(224,239,249,1)',  // Degradado → 100%
            letras_color: '#000000',       // Color de letras título
            letras_background: '#ffffff',  // Color de fondo letras
            letras_borde: '#cc6633',       // Color del borde para bloque letras
            letras_ancho: 'auto',          // El ancho del bloque para letras
            letras_alto: '20px',           // El ancho del bloque para letras
        };

        $.extend(conf, options);
        $('body').append('<div id="des_caja"></div>');

        // Por cada entrada añade un elemento al menú
        $(entradas).each(function() {
            var agregar = '' +
                '<div class="des_all">' +
                    '<img src="' + $(this)[1] +
                        '" data-link="' + $(this)[2] + '"/>' +
                    '<div class="des_letras">' + $(this)[0] + '</div>' +
                '</div>'

            $('#des_caja').append(agregar);
        });

        // Oculta todos los títulos de menú para que se muestren luego
        $('#des_caja .des_all .des_letras').hide();

        // Evento al pasar sobre un elemento del menú
        $('#des_caja .des_all > img').hover(
            function() {
                $(this).siblings('.des_letras').show();
            },
            function() {
                $(this).siblings('.des_letras').hide();
            },
        );

        // Evento al hacer click sobre un elemento/imagen del menú
        $('#des_caja .des_all > img').on('click', function() {
            location.href = $(this).data('link');  // Extrae link de la imagen
        });

        var des_estilos = '<style>' +
        '#des_caja {' +
            'position:fixed;' +
            'opacity: 0.6;' +
            'top: 115px;' +
            'width: 80px;' +
            'color: white;' +
            'z-index: 50;' +
            'left:-55px;' +
            'box-shadow: 15px 20px 20px black;' +
            'background-color: darkgray;' +
            'background: linear-gradient(to right,' +
                conf.back1 + '0%,'  +
                conf.back2 + '20%,' +
                conf.back3 + '45%,' +
                conf.back4 + '100%);' +
            'border-radius: 0px 15px 15px 0px;' +
        '}' +
        '#des_caja:hover {' +
            'left: 0px;' +
            'opacity: 1;' +
            'transition: all 1s ease-in-out;' +
        '}' +
        '.des_all {' +
            'width: 110px;' +
            'z-index: 12;' +
            'left: 5px;' +
            'opacity: 1;' +
        '}' +
        '.des_all:hover {' +
            'width: 130px;' +
            'left: 15px;' +
        '}' +
        '.des_all > img {' +
            'width: 70px;' +
            'box-shadow: 3px 5px 5px black;' +
            'margin-top: 8px;' +
            'opacity: 1;' +
        '}' +
        '.des_all > img:hover {' +
            'width: 90px;' +
            'margin-left: 15px;' +
            'cursor: pointer;' +
            'transition-duration: 0.5s;' +
            'transform: rotate(15deg) scale(1);' +
        '}' +
        '.des_letras {' +
            'position: absolute;' +
            'background-color:' + conf.letras_background + ';' +
            'left: 90px;' +
            'padding-top: 1px;' +
            'padding-bottom: 4px;' +
            'padding-left: 8px;' +
            'padding-right: 8px;' +
            'width:' + conf.letras_ancho + ';' +
            'height:' + conf.letras_alto + ';' +
            'color:' + conf.letras_color +';' +
            'text-align: center;' +
            'font-family: fantasy;' +
            'font-style: oblique;' +
            'font-size: 18px;' +
            'border: 3px solid' + conf.letras_borde + ';' +
            'border-radius: 10px 10px 10px 10px;' +
            'transition-delay: 0.2s;' +
            'transform:rotate(5deg) scale(1);' +
        '}' +
        '</style>'

        //Añade estilos al <head></head>
        $('head').append(des_estilos);
    };
})(jQuery);
