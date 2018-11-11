<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Assets para vistas de Usuarios
 */
class UsuariosCreateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/usuarios/create.css',
    ];
    public $js = [
        'js/usuarios/create.js',
        'js/usuarios/create-validaciones.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
    ];
}
