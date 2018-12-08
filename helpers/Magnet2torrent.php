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
            "udp://tracker.openbittorrent.com:80/announce",
            "udp://tracker.pirateparty.gr:6969/announce",
            "udp://tracker.opentrackr.org:1337/announce",
            'http://linuxtracker.org:2710/00000000000000000000000000000000/announce',
            'http://bttracker.debian.org:6969/announce',
            'udp://tracker.publicbt.com:80/announce',
            "udp://tracker.zer0day.to:1337/announce",
            "http://tracker.tfile.me/announce",
            "udp://tracker.internetwarriors.net:1337/announce",
            "udp://tracker.sktorrent.net:6969/announce",
            "udp://tracker.coppersurfer.tk:6969/announce",
            "udp://tracker.leechers-paradise.org:6969/announce",
            "udp://explodie.org:6969/announce",
            "udp://exodus.desync.com:6969/announce",
            "udp://public.popcorn-tracker.org:6969/announce",
            "udp://tracker1.wasabii.com.tw:6969/announce",
            "udp://tracker2.wasabii.com.tw:6969/announce",
            'udp://public.popcorn-tracker.org:6969/announce',
            'http://182.176.139.129:6969/announce',
            'http://5.79.83.193:2710/announce',
            'http://91.218.230.81:6969/announce',
            'udp://tracker.ilibr.org:80/announce',
            'http://atrack.pow7.com/announce',
            'udp://9.rarbg.me:2710/announce',
            'udp://9.rarbg.com:2710/announce',
            'udp://tracker2.christianbro.pw:6969/announce',
            'udp://explodie.org:6969/announce',
            'udp://tracker.coppersurfer.tk:6969',
            'udp://tracker.leechers-paradise.org:6969',
            'udp://eddie4.nl:6969/announce',
            'udp://tracker.doko.moe:6969/announce',
            'udp://tracker.zer0day.to:1337/announce',
            'udp://tracker.opentrackr.org:1337/',
            'www.spanishtracker.com:2710/announce',
            'tracker.openbittorrent.com/announce',
            'tracker.publicbt.com/announce',
            'tpb.tracker.prq.to/announce',
            'tracker.prq.to/announce',
            'udp://tracker.openbittorrent.com:80',
            'udp://tracker.publicbt.com:80',
            'udp://tracker.openbittorrent.com:80',
            'udp://tracker.ccc.de:80',
            'udp://tracker.istole.it:6969',
            'udp://tracker.opentrackr.org:1337/announce',
            'udp://open.stealth.si:80/announce',
            'udp://tracker.leechers-paradise.org:6969/announce',
            'udp://tobn.org:6969/announce',
            'udp://tracker.zond.org:80/announce',
            'http://tracker.kali.org:6969/announce',
            'udp://tracker.kali.org:6969/announce',
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
