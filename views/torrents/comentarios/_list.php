<?php

use app\helpers\Roles;
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
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', [
                        'eliminarcommentario',
                        'id' => $model->id
                    ], [
                        'data' => [
                            'confirm' => '¿Seguro que quieres eliminar este comentario?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
                <?php if (!Yii::$app->user->isGuest && ($model->level < $maxLevel || is_null($maxLevel))) : ?>
                    <?php echo Html::a("<span class='glyphicon glyphicon-share-alt'></span> " . Yii::t('yii2mod.comments', 'Reply'), '#', ['class' => 'comment-reply', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
                <?php endif; ?>
            </div>
            <div class="comment-author-name">
                <span><?php echo $model->getAuthorName(); ?></span>
                <?php echo Html::a($model->getPostedDate(), $model->getAnchorUrl(), ['class' => 'comment-date']); ?>
            </div>
            <div class="comment-body">
                <?php if (Roles::isAdmin() || ($model->createdBy ==
                        yii::$app->user->id)): ?>
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
        </div>
    </div>
</li>
<?php if ($model->hasChildren()) : ?>
    <ul class="children">
        <?php foreach ($model->getChildren() as $children) : ?>
            <li class="comment" id="comment-<?php echo $children->id; ?>">
                <?php echo $this->render('_list', ['model' => $children, 'maxLevel' => $maxLevel]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
