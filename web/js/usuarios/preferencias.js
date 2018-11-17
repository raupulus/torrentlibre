/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

/**
 * Este scrip solo se aplicará a la ventana emergente para las preferencias.
 */

window.onload = function() {
    // Muestro botones y permito interactuar con ellos
    $('#tabla-preferencias button').removeClass('btn-no-interactive');
    $('#tabla-preferencias button').removeClass('hidden');

    console.log(1);
    $('#btn-guardar').click(() => {
        console.log(2);
        $(this).data('cerrar', true);
    });
    console.log(3);

    $('#btn-cerrar').click(() => {
        console.log(4);
        $(this).data('cerrar', true);
    });

    console.log(5);

};
