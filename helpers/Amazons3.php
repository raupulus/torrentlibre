<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 25/10/18
 * Time: 22:54
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/** @var \frostealth\yii2\aws\s3\Service $s3 */

/*
$result = $s3->commands()->get('filename.ext')->saveAs('/path/to/local/file.ext')->execute();

$result = $s3->commands()->put('filename.ext', 'body')->withContentType('text/plain')->execute();

$result = $s3->commands()->delete('filename.ext')->execute();

$result = $s3->commands()->upload('filename.ext', '/path/to/local/file.ext')->withAcl('private')->execute();

$result = $s3->commands()->restore('filename.ext', $days = 7)->execute();

$result = $s3->commands()->list('path/')->execute();

$exist = $s3->commands()->exist('filename.ext')->execute();

$url = $s3->commands()->getUrl('filename.ext')->execute();

$signedUrl = $s3->commands()->getPresignedUrl('filename.ext', '+2 days')->execute();
 */
namespace app\helpers;

use function getenv;
use Yii;

/**
 *
 * @package app\helpers
 */
class Amazons3
{
    private $aws;
    private $s3;

    function __construct() {
        $this->s3 = Yii::$app->get('s3');
    }

    public function uploadImage($rutalocal, $rutaremoto)
    {
        return $this->s3->commands()->upload(
            $rutalocal,
            $rutaremoto
        )->execute();

    }

    public function downloadImage($nombre) {
        return $this->s3->commands()->getUrl($nombre)->execute();
    }
}
