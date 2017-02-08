<?php
use yii\helpers\Url;
use app\models\Topic;
?>
<div style="padding-top: 5px;">    
    <a href="<?= Url::toRoute(['//topic/topic', 'category_id' => $model->id]) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="d-flex w-100 justify-content-between">
      <h4 class="mb-1"><?= $model->name ?></h4>
      <p><small>Liczba tematów: <?= Topic::getCount($model->id) ?></small></p>
    </div>
    <p class="mb-1"></p>
    <small></small>
  </a>
</div>

