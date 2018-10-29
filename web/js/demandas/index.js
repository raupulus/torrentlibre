/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {

    /**
     * Al pulsar sobre el botón de "Yo lo subo" se actualizará la demanda que
     * corresponda asignando el id del usuario que ha pulsado.
     */
    function comprometerDemanda(id, row) {
        $.ajax({
            type: 'GET',
            url: "/demandas/update",
            async: true,
            data: { 'id': id },
            timeout:5000,  // Tiempo a esperar antes de dar error
            success:function(data) {
                $(row).hide();  //Elimino el nodo
            },
            error: function() {
                console.log(id);
                console.log('ERROR AJAX DEMANDAS');
            }
        });
    }

    /**
     * Asigno función para marcar una demanda para subirla el usuario actual.
     */
    $('.btn-subir-demanda').click( function() {
        var id = $(this).data('demandaid');
        var row = $(this).parent().parent();
        comprometerDemanda(id, row);
    });
});
