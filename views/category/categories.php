<?php
use yii\widgets\ListView;
use yii\helpers\Url;
?>

<h1>Kategorie</h1>

<div class="list-group">
<?php
    echo ListView::widget([
            'dataProvider' => $provider,
            'itemView' => function($model){
                return $this->render('categorySingleItem', ['model' => $model]);
            }
    ]); 
?>
</div>
