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

use Yii;

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
        if (Yii::$app->user->isGuest) {
            return false;
        }

        // Si es administrador siempre devuelve true
        if (Yii::$app->user->identity->rol == 'admin') {
            return true;
        }

        // Si coincide con el usuario logueado devuelve true
        if (Yii::$app->user->identity->rol == $role) {
            return true;
        }

        return false;
    }

    /**
     * Comprueba si el usuario actual administrador.
     *
     * @return bool Devuelve boolean indicando true si coincide
     */
    public static function isAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        // Si es administrador siempre devuelve true
        if (Yii::$app->user->identity->rol == 'admin') {
            return true;
        }

        return false;
    }
}
