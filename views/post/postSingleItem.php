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
                <p><strong><?= Html::encode($model->user->name) ?></strong></p>
                <p><small>Rejestracja: <?= Yii::$app->formatter->asRelativeTime($model->user->created_at); ?></small></p>
                <p><small>Posty: <?= Post::countPostOfUser($model->user_id) ?></small></p>
                
            </div>
            <div class="col-sm-9 col-md-10">
                <small>
                    <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                    
                    <?php if((!Yii::$app->user->isGuest) && ($model->user->id == Yii::$app->user->identity->id)): ?>
                    <a style="float: right" href="<?= Url::to(['/post/edit-post', 'id' => $model->id]) ?>">Edytuj post</a>
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
