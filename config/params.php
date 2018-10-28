<?php
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

return [
    'adminEmail' => getenv('ADMIN_EMAIL'),
    'sitename' => getenv('SITE_TITLE'),
    'sitedescription' => getenv('SITE_DESCRIPTION'),
    'siteurl' => getenv('SITE_URL'),
    'sitenameadmin' => getenv('SITE_NAME_ADMIN'),
    'siterepo' => getenv('SITE_REPO'),
    'sitemailcontact' => getenv('SITE_MAIL_CONTACT'),
    'language_default' => getenv('LANGUAGE_DEFAULT'),
    'rutaAvatar' => 'images/user-avatar',
    'rutaImagenes' => 'images',
    'rutaIconos' => 'images/icons',
    'rutaTorrent' => 'uploads/torrents',
    'rutaImagenTorrent' => 'images/torrent-image',
    'rutaImagenLicencias' => 'images/licencias',
    'tmp' => 'tmp',
    'downloads' => 'downloads',
    'paginaciontorrents' => getenv('TORRENTS_PAGINATION'),
    'maxErrorsLogin' => getenv('USERLOGIN_MAXERRORS'),
    'uploadImages' => getenv('UPLOAD_IMAGES'),
];
