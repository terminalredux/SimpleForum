<?php
use yii\helpers\Url;
use app\models\Post;
use yii\helpers\Html;
use app\models\User;
use app\models\Topic;
?>

<div style="padding-top: 5px;">    
    <a href="<?= Url::toRoute(['post/post', 'topic_id' => $model->id]) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
        <h4 class="mb-1"><?= Html::encode($model->name) ?></h4>
        <small>
            <p style="margin: 0">Dodano: <?= Yii::$app->formatter->asDateTime($model->created_at) ?></p>
            <p style="margin: 0">Autor: <?= Topic::getFirstPostOfTopic($model->id)->user->name ?> </p>    
            <p style="margin: 0">Posty: <?= Post::countPostInTopic($model->id) ?></p>
            <p style="margin: 0">Ostatnia aktywność: <?= Yii::$app->formatter->asDatetime($model->last_post) ?></p>
        </small>
    </div>
    <p class="mb-1"></p>
    <small></small>
  </a>
</div>

