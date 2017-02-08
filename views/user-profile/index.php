<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;
?>

<h1>Dane profilu</h1>
<?php 
    $model = UserProfile::findOne(Yii::$app->user->id);
?>

<p><?= $model->name  ?></p>
<p><?= $model->email  ?></p>



