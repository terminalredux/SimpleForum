<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h3>
    <?= Yii::t('app', 'Edycja profilu({name})', ['name' => (Yii::$app->user->identity->name ?: Yii::$app->user->identity->email)]); ?>
</h3>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'email')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>




