<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
       <?= Html::submitButton('Dodaj', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end();?>



