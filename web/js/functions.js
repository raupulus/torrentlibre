

/************************************
            FORMULARIOS
*************************************/

function formValueClear() {
    $('#form-btn-clear').click(() => {
        $('form input, form select, form textarea').val('');
    });
}
