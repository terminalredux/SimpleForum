<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Topic;
?>

<?php $form = ActiveForm::begin(); ?>

  
    <?= $form->field($postModel, 'content')->textarea(['rows' => 6])->label('Twoja odpowiedź') ?>
    
    <div class="form-group">
       <?= Html::submitButton('Dodaj', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>