<?php

use app\models\Topic;
use yii\widgets\ListView;
use app\models\Post;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<h1><?= Html::encode(Topic::getTopicName($topic_id)) ?></h1>

<div class="list-group">
    <?php
    echo ListView::widget([
        'dataProvider' => $provider,
        'pager' => [
            'firstPageLabel' => 'Pierwsza',
            'lastPageLabel'  => 'Ostatnia',
            'prevPageLabel' => '<span class="glyphicon glyphicon-chevron-left"></span>',
            'nextPageLabel' => '<span class="glyphicon glyphicon-chevron-right"></span>',
    ],
        'itemView' => function($model) {
            return $this->render('postSingleItem', ['model' => $model]);
        }
    ]);
    ?>
    
    <?php if(!Yii::$app->user->isGuest): ?>
        <?= $this->render('addPost', ['postModel' => $postModel, 'topic_id' => $topic_id]); ?>
    <?php endif; ?>
    

</div>
