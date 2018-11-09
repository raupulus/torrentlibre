<?php
/**
 * Almaceno todas las imágenes en el array.
 */
$avataresTodos = [];
$dir = dir('images/user-avatar');
while (($archivo = $dir->read()) !== false) {
    if (preg_match("/png$/i", $archivo)){
        array_push($avataresTodos, [
            'nombre' => $archivo,
            'titulo' => basename($archivo, '.png'),
        ]);
    }
}
$dir->close();
?>

<?php foreach($avataresTodos as $av): ?>
    <div class="avatar-modal col-xs-4 col">
        <img src="/images/user-avatar/<?= $av['nombre'] ?>"
             data-name="<?= $av['nombre'] ?>"
             alt="<?= $av['titulo'] ?>"
             title="<?= $av['titulo'] ?>" />
    </div>
<?php endforeach ?>
