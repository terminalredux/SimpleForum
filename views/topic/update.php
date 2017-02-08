<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Topic',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id, 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
