<?php
use yii\widgets\ListView;
use app\models\Category;
use app\models\Post;
use app\models\Topic;
use yii\helpers\Url;
?>

<h1>Temat z kategorii: <?= Category::findOne($category_id)->name ?></h1><br/>


<div class="list-group">
<?php
    echo ListView::widget([
            'dataProvider' => $provider,
            'itemView' => function($model)
            {
                return $this->render('topicSingleItem', ['model' => $model]);
            }
    ]); 
?>
    <a class="btn btn-success" style="margin-top: 15px; float: right;" href="<?= Url::toRoute(['topic/add-topic', 'category_id' => $category_id]); ?>">Dodaj temat</a>
    
</div>