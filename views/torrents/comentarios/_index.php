<?php

use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $commentModel \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */
/* @var $encryptedEntity string */
/* @var $pjaxContainerId string */
/* @var $formId string comment form id */
/* @var $commentDataProvider \yii\data\ArrayDataProvider */
/* @var $listViewConfig array */
/* @var $commentWrapperId string */

/*
$commentModel = new ArrayDataProvider([ 'allModels' => $commentModel, 'pagination' =>
    [ 'pageSize' => 1, ], 'sort' => [ 'attributes' => [
    'createdAt' => [
        'desc' => ['createdAt' => SORT_DESC],
        'default' => SORT_DESC,
    ]
], ],
]);

$sort = new Sort([
    'attributes' => [
        'createdAt' => [
            'asc' => ['createdAt' => SORT_ASC],
            'default' => SORT_ASC,
        ]
    ],
]);

$commentDataProvider->sort->attributes['createdAt'] = [
    'default' => SORT_ASC
];
*/

?>
<div class="comment-wrapper" id="<?= $commentWrapperId; ?>">
    <?php Pjax::begin([
        'enablePushState' => false,
        'timeout' => 20000,
        'id' => $pjaxContainerId
    ]); ?>

    <div class="comments row">
        <div class="col-md-12 col-sm-12">
            <div class="title-block clearfix">
                <h3 class="h3-body-title">
                    <?= 'Comentarios ' . $commentModel->getCommentsCount(); ?>
                </h3>
                <div class="title-separator"></div>
            </div>
            <?= ListView::widget(ArrayHelper::merge(
                [
                    'dataProvider' => $commentDataProvider,
                    'layout' => "{items}\n{pager}",
                    'itemView' => '_list',
                    'viewParams' => [
                        'maxLevel' => $maxLevel,
                    ],
                    'options' => [
                        'tag' => 'ol',
                        'class' => 'comments-list',
                    ],
                    'itemOptions' => [
                        'tag' => false,
                    ],
                    //'sorter' => $sort,
                ],
                $listViewConfig

            )); ?>
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?= $this->render('_form', [
                    'commentModel' => $commentModel,
                    'formId' => $formId,
                    'encryptedEntity' => $encryptedEntity,
                ]); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
