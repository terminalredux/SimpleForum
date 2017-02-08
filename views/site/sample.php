<?php
use yii\helpers\Html;
?>



<ul>
    <li><?= Yii::$app->user->identity->email ?></li>
    <li><?= Yii::$app->user->identity->name ?></li>
    <li><?= Yii::$app->user->identity->password ?></li>
    <li><?= Yii::$app->user->identity->status ?></li>
   
</ul>