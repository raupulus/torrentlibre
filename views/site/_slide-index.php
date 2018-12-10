<?php
$slideImg = [
    [
        'active' => true,
        'src' => 'slide/slide1.jpg',
        'title' => 'Torrent Libre',
    ],
    /*
    [
        'src' => 'slide/slide2.jpg',
        'title' => 'Máquinas Virtuales',
    ],
    [
        'src' => 'slide/slide3.jpg',
        'title' => 'Libros',
    ],
    [
        'src' => 'slide/slide4.jpg',
        'title' => 'Subir Torrent',
    ],
    [
        'src' => 'slide/slide5.jpg',
        'title' => 'Buscar Torrent',
    ],
    */
];?>

<?= \aki\imageslider\ImageSlider::widget([
    'baseUrl' => Yii::getAlias('@web/images'),
    'nextPerv' => true,
    'indicators' => false,
    'classes' => 'img-rounded',
    'images' => $slideImg,
]); ?>
