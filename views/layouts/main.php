<?php header('Content-Type: text/html; charset=UTF-8');
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 7/10/18
 * Time: 1:39
 */
/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$params = Yii::$app->params;
?>

<?php $this->beginPage() ?>
<?php require_once 'head.php' ?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php require_once 'navbar.php' ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php require_once 'footer.php' ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
