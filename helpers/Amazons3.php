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
    private $bucket;
    private $filepath;

    function __construct() {
        $this->aws = Yii::$app->awssdk->getAwsSdk();
        $this->s3 = $this->aws->createS3();

        $this->bucket = getenv('AMAZON_S3_BUCKET');
        $this->filepath = getenv('AMAZON_S3_PATH');
    }

    public function uploadImage($nombre)
    {
        $result = $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => $nombre,
            'SourceFile' => $this->filepath,
            'ContentType' => 'text/plain',
            'ACL' => 'public-read',
            'StorageClass' => 'REDUCED_REDUNDANCY',
            'Metadata' => [
                'param1' => 'value 1',
                'param2' => 'value 2'
            ],
        ]);
        return $result;  //echo $result['ObjectURL'];
    }

    public function downloadImage($url) {
        return $this->s3->getObject([
            'Bucket' => $this->bucket,
            'Key' => getenv($url),
        ]);
    }
}
