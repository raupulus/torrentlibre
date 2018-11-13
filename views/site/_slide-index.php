<?php
$items = [
    [
        'url' => '#',
        'src' => 'images/slide/slide1.jpg',
        'options' => [
            'class' => 'index-slide-img',
            'title' => 'Máquinas Virtuales',
        ]
    ],
    [
        'url' => '#',
        'src' => 'images/slide/slide2.jpg',
        'options' => [
            'class' => 'index-slide-img',
            'title' => 'Libros',
        ]
    ],
    [
        'url' => '#',
        'src' => 'images/slide/slide3.jpg',
        'options' => [
            'class' => 'index-slide-img',
            'title' => 'Subir Torrent',
        ]
    ],
];?>

<?= dosamigos\gallery\Gallery::widget(['items' => $items]); ?>
    Probando carrusel de imágenes!

