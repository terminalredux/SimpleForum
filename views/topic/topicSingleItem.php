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
      
        <p style="margin: 0"><small>Dodano: <?= Yii::$app->formatter->asDateTime($model->created_at) ?></small></p>
        <p style="margin: 0"><samll>Autor: <?= Topic::getFirstPostOfTopic($model->id)->user->name ?> </small></p>    
        <p style="margin: 0"><small>Posty: <?= Post::countPostInTopic($model->id) ?></small></p>
        <p style="margin: 0"><small>Ostatnia aktywność: <?= Yii::$app->formatter->asDatetime($model->last_post) ?></small></p>
          
    </div>
    <p class="mb-1"></p>
    <small></small>
  </a>
</div>

