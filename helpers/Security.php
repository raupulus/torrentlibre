<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 21/10/18
 * Time: 16:12
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

namespace app\helpers;

/**
 * Class Security
 *
 * @package app\helpers
 */
class Security
{
    /*
     * Aplico filtros de validación al elemento $ip recibido
     * @param $ip recibe la supuesta ip  y devuelve si cumple.
     */
    public static function filtrarIp($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE ) !== false ) {
            return true;
        }
        return false;
    }

    /**
     * Recorro cada elemento de la variable para el servidor aplicando filtros
     * para descubrir la IP recibida.
     *
     * @param $ele
     *
     * @return mixed
     */
    public static function comprobarIp($ele) {
        foreach (array_map('trim', explode(',', $_SERVER[$ele])) as $ip) {
            if (Security::filtrarIp($ip)) {
                return $ip;
            }
        }
    }

    /**
     * Comprueba todas las variables para descubrir la IP real del cliente
     * y la devuelve. En caso de que no sea posible devolverá "?".
     * @return string Cadena con la IP o con "?" en caso de no ser encontrada.
     */
    public static function getIp() {
        $ALLHTTP = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ALLHTTP as $ele) {
            if (array_key_exists($ele, $_SERVER)) {
                Security::comprobarIp($ele);
            }
        }

        return '?';
    }
}
