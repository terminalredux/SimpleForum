<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Topic;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'user_id')->dropDownList($model->userList) ?>
   
    
    <?= $form->field($model, 'topic_id')->dropDownList(Topic::getTopicList()) ?>
     
    
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    

</div>
