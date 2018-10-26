<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 26/10/18
 * Time: 07:12
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

namespace app\helpers;

use DateTime;
use Exception;
use function var_dump;
use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * Class Imageresize
 *
 * @package app\helpers
 */
class Imageresize
{
    /**
     * @var String Ruta hacia el directorio de las imágenes.
     */
    private $ruta;

    /**
     * @var String Ruta completa hacia el archivo de imagen.
     */
    private $rutaCompleta;

    /**
     * @var String Nombre final de la imagen subida.
     */
    private $NAME;

    /**
     * @var \yii\web\UploadedFile
     */
    private $imgObject;

    /**
     * @var int Timestamp del momento de la subida.
     */
    private $tsp;

    /**
     * Imageresize constructor.
     * Recibe un objeto \yii\web\UploadedFile
     *
     * @param $imgObj Objeto que representa la imagen subida.
     */
    public function __construct($imgObj)
    {
        $this->imgObject = $imgObj;
        $this->ruta = Yii::getAlias('@uploadImages');
        $this->tsp = (new Datetime('now'))->getTimestamp();
        $this->subirImagen();
        $this->generateRandomName();
    }

    /**
     * Sube la imagen al servidor y la redimensiona.
     *
     * @return bool
     */
    private function subirImagen()
    {
        $ruta = $this->ruta . '/';
        try {
            $rdm = random_int(100000000, 999999999);
        } catch (Exception $e) {
            $rdm = 1234567890;
        }
        $extension = $this->imgObject->extension;
        $this->rutaCompleta = $ruta.$this->tsp.'-'.$rdm.'.'.$extension;
        $nombre = $this->rutaCompleta;

        if ($this->imgObject->saveAs($nombre)) {
            return Image::thumbnail($nombre, 500, null)->save($nombre);
        }

        return false;
    }

    /**
     * Genera una cadena aleatoria para la imagen.
     */
    private function generateRandomName()
    {
        $this->NAME = $this->tsp . '-' . sha1_file($this->rutaCompleta);
    }

    /**
     * Devuelve el nombre de la imagen subida.
     *
     * @return String|void
     */
    public function getNombre()
    {
        return $this->NAME . '.' . $this->imgObject->extension;
    }

    /**
     * Devuelve la ruta completa hacia la imagen, incluido nombre y extensión.
     *
     * @return String
     */
    public function getRutaImagen() {
        return $this->rutaCompleta;
    }
}
