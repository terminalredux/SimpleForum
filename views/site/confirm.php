<?php

use yii\helpers\Html;

?>

<ul>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
    <li><label>Password: </label>: <?= Html::encode($model->password) ?></li>
    <li><label>Password repeat: </label>: <?= Html::encode($model->password_repeat) ?></li>
</ul>