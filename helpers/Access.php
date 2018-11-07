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

use app\models\Accesos;
use app\models\Accesoserror;
use app\models\IpBloqueadas;
use DateTime;
use function var_dump;
use Yii;

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
        $h24 = new DateTime('now');
        $h24->modify('-1 day');
        $h24 = $h24->format('Y-m-d H:i:s');

        $accesosErrores = Accesoserror::find()
            ->where(['ip' => $ip])
            ->andWhere(['>=', 'registered_at', $h24])
            ->count();

        $maxErrorsLogin = Yii::getAlias('@maxErrorsLogin');

        if (($accesosErrores) >= $maxErrorsLogin) {
            $bloqueado = new IpBloqueadas([
                'ip' => $ip
            ]);

            return $bloqueado->save();
        }

        return  false;
    }


    /*
     * Comprueba si el usuario actual es el autor
     * @param String Recibe el id del autor del contenido
     */
    public static function isAutor($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->usuarioId->id;
            return $user == $id;
        }

        return false;
    }

    /**
     * Comprueba si la ip actual está bloqueada 24horas atrás.
     * @return bool Indica si está bloqueada la IP (true en ese caso)
     */
    public static function ipBloqueada() {
        $ip = Security::getIp();

        if ($ip === '?') {
            return false;
        }

        $h24 = new DateTime('now');
        $h24->modify('-1 day');
        $h24 = $h24->format('Y-m-d H:i:s');

        $bloqueada = IpBloqueadas::find()
            ->where(['ip' => $ip])
            ->andWhere(['>=', 'created_at', $h24])
            ->count();

        return (($bloqueada) >= 1) ? true : false;
    }

    public static function registrarErrorAcceso() {
        $ip = Security::getIp();

        if ($ip !== '?') {
            $tablaErrores = new Accesoserror([
                'ip' => $ip
            ]);
            $tablaErrores->save();

            return Access::bloquearIp($ip);
        }

        return false;
    }

    public static function registrarAcceso() {
        $tablaAccesos = new Accesos([
            'usuario_id' => Yii::$app->user->id,
            'ip' => Security::getIp(),
        ]);
        return $tablaAccesos->save();
    }
}
