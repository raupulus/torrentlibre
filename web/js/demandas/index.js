/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(() => {

    /**
     * Al pulsar sobre el botón de "Yo lo subo" se actualizará la demanda que
     * corresponda asignando el id del usuario que ha pulsado.
     *
     * @param id Recibe el id de la demanda a modificar.
     * @param row Recibe la fila a ocultar si se modifica correctamente.
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

    /**
     * Envía el formulario para Demandas.
     */
    function buscarDemandas() {
        $('.demandas-search button[type="submit"]').submit();
    }

    /**
     * Envía el formulario para buscar con demandas activas.
     */
    $('#btn-search_activas').click( function() {
        $('#search_activas').val('true');
        $('#search_encurso').val('');
        buscarDemandas();
    });

    /**
     * Envía el formulario para buscar con demandas en curso.
     */
    $('#btn-search_encurso').click( function() {
        $('#search_encurso').val('true');
        $('#search_activas').val('');
        buscarDemandas();
    });
});
