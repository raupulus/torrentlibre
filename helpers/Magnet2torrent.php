<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 22/10/18
 * Time: 00:31
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

namespace app\helpers;

use app\models\Torrents;
use function array_combine;
use function array_map;
use function explode;
use function functionCallback;
use function implode;

/**
 * Class Magnet2torrent
 *
 * @package app\helpers
 */
class Magnet2torrent
{
    /*
     * Devuelve un array con los trackers utilizados.
     * @param Array
     */
    public static function trackers() {
        return [
            "http://tracker.tfile.me/announce",
            "udp://tracker.openbittorrent.com:80/announce",
            "udp://tracker.internetwarriors.net:1337/announce",
            "udp://tracker.sktorrent.net:6969/announce",
            "udp://tracker.opentrackr.org:1337/announce",
            "udp://tracker.coppersurfer.tk:6969/announce",
            "udp://tracker.leechers-paradise.org:6969/announce",
            "udp://tracker.zer0day.to:1337/announce",
            "udp://explodie.org:6969/announce",
            "udp://exodus.desync.com:6969/announce",
            "udp://tracker.pirateparty.gr:6969/announce",
            "udp://public.popcorn-tracker.org:6969/announce",
            "udp://tracker1.wasabii.com.tw:6969/announce",
            "udp://tracker2.wasabii.com.tw:6969/announce"
        ];
    }

    /*
     * Genera un array con la información necesaria para el torrent.
     */
    public static function generateTorrentInfo($id) {
        $oldTorrent = Torrents::findOne(['id' => $id]);
        $pieces = array_map(function($ele) {
            return sha1($ele, true);
        }, explode(',', $oldTorrent->archivos_hash));
        $pieces = implode('', $pieces);

        if ($oldTorrent->trackers == '') {
            $trackers = Magnet2torrent::trackers();
        } else {
            $trackers = explode(',', $oldTorrent->trackers);
        }

        $files_path = explode(',', $oldTorrent->archivos);
        $files_length = explode(',', $oldTorrent->archivos_size);

        $filesTMP = array_combine($files_path, $files_length);
        $files = [];
        foreach ($filesTMP as $path => $length) {
            array_push($files,
                [
                    'path' => $path,
                    'length' => $length,
                ]
            );
        }

        return [
            'announce' => $trackers[0],
            //'announce-list' => [$trackers],
            'created by' => 'TorrentLibre',
            'creation date' => $oldTorrent->torrentcreate_at,
            'encoding' => 'UTF-8',
            'info' => [
                'filename' => $oldTorrent->name ?: $oldTorrent->titulo,
                'comment' => $oldTorrent->resumen ?: 'Sin detalles',
                'infohash' => $oldTorrent->hash,
                'root hash' => $oldTorrent->hash,
                'name' => $oldTorrent->titulo ?: $oldTorrent->name,
                'piece length' => $oldTorrent->size_piezas,
                'pieces' => $pieces,
                'length' => $oldTorrent->size ?: '1',
                'private' => 0,
                //'md5sum' =>
                //'info' => []
                'files' => $files,

                /*
                'filetree' => [
                    '??' => [
                        ''
                    ],
                ],
                */
            ],
        ];
    }
}
