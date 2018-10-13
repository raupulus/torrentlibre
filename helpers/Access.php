<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:03
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/


namespace app\helpers;

/**
 * Contiene clases estáticas para gestionar el acceso de los usuarios y/o
 * bloquearlos si fuera necesario
 *
 * @package app\helpers
 */
class Access
{
    /**
     * Comprueba los accesos desde una IP y registra cada acceso.
     * Si se producen más de 10 erróneos en 1 hora se bloqueará durante 24 horas
     * @param String $ip Recibe la IP a registrar o bloquear
     */
    public static function bloquearIp(String $ip)
    {

    }
}
