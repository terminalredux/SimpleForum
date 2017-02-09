<?php

use app\models\Post;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div style="padding-top: 5px;">    
    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="row">
            <div class="col-sm-3 col-md-2">
                <strong>
                    <p><?= Html::encode($model->user->name) ?></p>
                </strong>
                <small>
                    <p>Rejestracja: <?= Yii::$app->formatter->asRelativeTime($model->user->created_at); ?></p>
                    <p>Posty: <?= Post::countPostOfUser($model->user_id) ?></p>
                    <p>Funkcja: <?= User::getUserRole($model->user->id)['item_name'] ?></p>
                </small>
            </div>
            <div class="col-sm-9 col-md-10">
                <small>
                    <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                    <?php if(!Yii::$app->user->isGuest): ?>
                    <a style="float: right" href="<?= Url::to(['/post/edit-post', 'id' => $model->id]) ?>">(Edytuj post)</a>
                    <?php endif; ?>
                </small>
            </div>
            <div class="col-sm-9 col-md-10" style="padding-top: 10px;"><?= Html::encode($model->content) ?>
                <?php if ($model->created_at != $model->updated_at): ?>
                    <p><strong> Edytowano
                    <?= Yii::$app->formatter->asDatetime($model->updated_at) ?>
                    </p></strong>
                <?php endif; ?>    
            </div>
        </div>
    </div>
</div>
