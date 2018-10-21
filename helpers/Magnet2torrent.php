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
        $trackers = Magnet2torrent::trackers();

        return [
            'announce' => $trackers[0],
            'filename' => $oldTorrent->titulo,
            'created by' => 'TorrentLibre',
            'created_by' => 'TorrentLibre',
            'creation date' => $oldTorrent->torrentcreate_at,
            'creation_date' => $oldTorrent->torrentcreate_at,
            'name' => $oldTorrent->titulo,
            'comment' => $oldTorrent->resumen,
            'announce_list' => $trackers,
            'info_hash' => $oldTorrent->hash,
            'size' => $oldTorrent->size,
            'private' => false,
        ];
    }
}
