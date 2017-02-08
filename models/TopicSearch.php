<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Topic;

/**
 * TopicSearch represents the model behind the search form about `app\models\Topic`.
 */
class TopicSearch extends Topic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'last_post','created_at', 'updated_at'], 'integer'],
            [['name', 'category.name'], 'safe'],
        ];
    }
    
    public function attributes()
    {
        return array_merge(parent::attributes(), ['category.name']);
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
        $query = Topic::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        
        $query->joinWith('category');
        $dataProvider->sort->attributes['category.name'] = [
            'asc' => ['category.name' => SORT_ASC],
            'desc' => ['category.name' => SORT_DESC],
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
            'category_id' => $this->category_id,
            'last_post' => $this->last_post,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['LIKE', 'category.name', $this->getAttribute('category.name')]);

        return $dataProvider;
    }
    
    /*
    funkcja provider - służy do zapewnienia danych widgetowi listview (kontorler topic, akcja actionTopic) 
                       znajdującym się w widoku topic/topics 
    */
    
    public function provider($category_id)
    {
        $query = Topic::find()
                ->where(['category_id' => $category_id])
                ->orderBy(['last_post' => SORT_DESC]);

        //var_dump($query->createCommand()->rawSql);die;

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        
        return $provider;
    }
}
