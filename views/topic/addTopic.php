<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<h1>Nowy temat z kategorii: <?= Html::encode($topicModel->category->name)  ?></h1>

<?php $form = ActiveForm::begin(); ?>
    

    <?= $form->field($topicModel, 'name')->textInput()->label('Nazwa tematu') ?>

    <?= $form->field($postModel, 'content')->textarea(['rows' => 6])->label('Pierwszy wpis') ?>
    

    <div class="form-group">
       <?= Html::submitButton('Dodaj temat', ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>