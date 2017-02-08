<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'topic_id', 'created_at', 'updated_at'], 'integer'],
            [['content', 'user.name', 'topic.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.name', 'topic.name']);
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $query->joinWith(['user']);
        $query->joinWith(['topic']);
        
        $dataProvider->sort->attributes['user.name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['topic.name'] = [
            'asc' => ['topic.name' => SORT_ASC],
            'desc' => ['topic.name' => SORT_DESC],
        ];
        
        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'topic_id' => $this->topic_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['LIKE', 'user.name', $this->getAttribute('user.name')]);
        $query->andFilterWhere(['LIKE', 'topic.name', $this->getAttribute('topic.name')]);
        
        return $dataProvider;
    }
   
    /*
    funkcja provider - służy do zapewnienia danych widgetowi listview (kontorler post, akcja actionPost) 
                       znajdującym się w widoku post/posts 
    */
    
    public function provider($topic_id){
        
        $provider = new ActiveDataProvider([
            'query' => Post::find()
                       ->where(['topic_id' => $topic_id]),
            'pagination' => [
                'pageSize' =>10,
            ],
            ]);
        
        return $provider;
        
    }
}
