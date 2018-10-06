<?php header('Content-Type: text/html; charset=UTF-8');
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


class Roles
{
    /**
     * Comprueba si el usuario actual tiene el rol pasado como parámetro.
     * @param String $role Recibe el rol a comprobar.
     *
     * @return bool Devuelve boolean indicando true si coincide
     */
    public static function is(String $role): boolean
    {
        // TODO Comprobar primero si está logueado el usuario.
        // TODO → Comparar con el usuario.
        return true;
    }

    /**
     * Comprueba si el usuario actual administrador.
     *
     * @return bool Devuelve boolean indicando true si coincide
     */
    public static function isAdmin(): boolean
    {
        // TODO Comprobar primero si está logueado el usuario.
        // TODO → Comparar con el usuario.
        return true;
    }
}
