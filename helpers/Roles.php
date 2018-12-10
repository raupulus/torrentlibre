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

use app\models\Torrents;
use app\models\Usuarios;
use function count;
use DateTime;
use DateTimeZone;
use function var_dump;
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

    public static function canUpload() {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $role = Yii::$app->user->identity->rol;

        if ($role == 'tmp') {
            Yii::$app->session->setFlash('info',
                'No puedes subir torrents hasta verificar tu email' );
            return false;
        }

        if (($role == 'admin') ||
            ($role == 'editor') ||
            ($role == 'especial')) {
            return true;
        }


        $roles = self::allRoles();

        if (! $roles[$role]) {
            return false;
        }

        /*
         * Subidas máximas que puede hacer el usuario según su rol
         */
        $maxUpload = $roles[$role][1];

        /*
         * DateTime que representa el día actual a las 00:00:00
         */
        $horaZero = new DateTime('now');
        $horaZero->setTimezone(new DateTimeZone("UTC"));
        $horaZero->setTime(00,00,00);
        $horaZero = $horaZero->format('Y-m-d H:i:s e');

        $subidasHoy = Torrents::find()
            ->where(['>=', 'created_at', $horaZero])
            ->andWhere(['=', 'usuario_id', Yii::$app->user->id])
            ->all();

        if (count($subidasHoy) >= $maxUpload) {
            Yii::$app->session->setFlash('warning',
                'Has superado tu límite diario de torrents: '.
                $roles[$role][1].'<br />'.
                ' No podrás subir más hasta mañana.');
            return false;
        }
        return true;
    }

    /*
     * Roles como índice de un array que contiene:
     * [Publicaciones para rango, publicaciones diarias]
     * return @param Array
     */
    public static function allRoles() {
        return [
            'novato' => [1, 1],
            'geekv1' => [10, 2],
            'geekv2' => [50, 3],
            'geekv3' => [100, 20],
        ];
    }

    /*
     * Comprueba el rol actual y devuelve el nuevo rol o el actual
     */
    public static function proximoRole() {
        $roles = self::allRoles();

        $role = Yii::$app->user->identity->rol;

        foreach ($roles as $i => $r) {
            if ($r[0] > $roles[$role][0]) {
                return array_search($r, $roles);
            }
        }
    }

    /*
     * Comprueba si cumple requisitos para el próximo role
     */
    public static function subirRole() {
        $role = Yii::$app->user->identity->rol;
        $roles = self::allRoles();

        if (empty($roles[$role])) {
            return false;
        }

        if ($role == 'tmp') {
            Yii::$app->session->setFlash('info',
                'No puedes subir torrents hasta ser aprovado' );
            return false;
        }

        $n_subidas = Torrents::find()
                     ->where(['=', 'usuario_id', Yii::$app->user->id])
                     ->all();

        $n_subidas = count($n_subidas);

        $nextRole = self::proximoRole();

        if ($n_subidas >= $roles[$role][0]) {
            $roleId = \app\models\Roles::findOne(['tipo' => $nextRole])->id;

            $usuario = Usuarios::findOne(Yii::$app->user->id);
            $usuario->rol_id = $roleId;
            $usuario->update();

            Yii::$app->session->setFlash('info',
                'Has subido de role a: '.$nextRole );

            return true;
        }

        return false;
    }
}
