<?php
$avatares = [
    [
        'nombre' => 'default.png',
        'titulo' => 'Imagen de Avatar por defecto'
    ],
    [
        'nombre' => 'hippy.png',
        'titulo' => 'Imagen de Avatar hippy'
    ],
    [
        'nombre' => 'rey.png',
        'titulo' => 'Imagen de Avatar rey'
    ],
    [
        'nombre' => 'rockero.png',
        'titulo' => 'Imagen de Avatar rockero'
    ],
];
?>

<?php foreach($avatares as $av): ?>
    <div class="col-xs-3 col">
        <img src="/images/user-avatar/<?= $av['nombre'] ?>"
             data-name="<?= $av['nombre'] ?>"
             alt="<?= $av['titulo'] ?>"
             title="<?= $av['titulo'] ?>" />
    </div>
<?php endforeach ?>

<div class="modal fade box-avatares-modal"
     tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">
                Seleccionar Avatar
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="row">
                <div class="col-sm-12">
                    <button type="button"
                            class="btn-aceptar btn btn-success center-block"
                            data-dismiss="modal">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-content">
            <?php require_once '_avataresAll.php'; ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="button"
                        class="btn-aceptar btn btn-success center-block"
                        data-dismiss="modal">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <button type="button" class="btn-modal btn btn-primary center-block"
                data-toggle="modal"
                data-target=".box-avatares-modal">Mostrar más Avatares</button>
    </div>
</div>
