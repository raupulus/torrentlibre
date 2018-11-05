<?php

use app\helpers\Roles;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\Editable;

/* @var $this \yii\web\View */
/* @var $model \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */
?>

<li class="comment" id="comment-<?= $model->id; ?>">
    <div class="comment-content" data-comment-content-id="<?= $model->id ?>">
        <div class="comment-author-avatar">
            <?= Html::img($model->getAvatar(), [
                    'alt' => $model->getAuthorName(),
                    'title' => $model->getAuthorName(),
            ]); ?>
        </div>

        <div class="comment-details">
            <div class="comment-action-buttons">
                <?php if (Roles::isAdmin() || ($model->createdBy ==
                        yii::$app->user->id)): ?>
                    <?= Html::a('<span id="eliminarComentario"
                          class="glyphicon glyphicon-trash"></span> Eliminar', [
                        'eliminarcommentario',
                        'id' => $model->id,
                    ], [
                        'data' => [
                            'confirm' => '¿Seguro que quieres eliminar este comentario?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>

                <?php if ($model->createdBy != yii::$app->user->id): ?>
                    <span class="btn-reportar-comentario glyphicon
                          glyphicon-bullhorn reportarComentario"
                          data-comment-content-id="<?= $model->id ?>">Reportar</span>
                    <span class="reportarComentario"></span>
                <?php endif; ?>

                <?php if (!Yii::$app->user->isGuest &&
                         ($model->level < $maxLevel || is_null($maxLevel))) : ?>
                    <?= Html::a("<span class='glyphicon glyphicon-share-alt'></span> Responder", '#', ['class' => 'comment-reply', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
                <?php endif; ?>
            </div>
            <div class="comment-author-name">
                <span><?= $model->getAuthorName(); ?></span>
                <?= Html::a($model->getPostedDate(), $model->getAnchorUrl(),
                    ['class' => 'comment-date']); ?>
            </div>
            <div class="comment-body">
                <?php if (Roles::isAdmin() ||
                         ($model->createdBy == yii::$app->user->id)): ?>
                    <?= Editable::widget([
                        'model' => $model,
                        'attribute' => 'content',
                        'url' => '/torrents/edit-page',
                        'options' => [
                            'id' => 'editable-comment-' . $model->id,
                        ],
                    ]); ?>
                <?php else: ?>
                    <?= $model->getContent(); ?>
                <?php endif; ?>
            </div>

            <div class="box-reportes-comentarios">
                <h4>Reportar comentario</h4>

                <div>
                    Título: <input type="text" class="reportar-titulo" />
                    <br />
                    Motivo: <input type="text" class="reportar-descripcion" />
                    <br />
                    <div class="box-reportes-comentarios"></div>
                    <div class="btn-enviar-reporte-comentario btn btn-warning">
                        Enviar Reporte
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
<?php if ($model->hasChildren()) : ?>
    <ul class="children">
        <?php foreach ($model->getChildren() as $children) : ?>
            <li class="comment" id="comment-<?= $children->id; ?>">
                <?= $this->render('_list', ['model' => $children, 'maxLevel'
                => $maxLevel]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
