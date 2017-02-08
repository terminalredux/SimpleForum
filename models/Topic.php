<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "topic".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post[] $posts
 * @property Category $category
 */
class Topic extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
    
    public static function tableName()
    {
        return 'topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['name'], function ($attribute) {
                    $this->$attribute = HtmlPurifier::process($this->$attribute);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id']);
    }
    
    public function getLastPost()
    {
        return $this->hasOne(Post::className(), ['topic_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function getCategoryList()
    {
       $models = Category::find()->asArray()->all();
       return ArrayHelper::map($models, 'id', 'name');
    }
    
    public static function getTopicList()
    {
        $model = Topic::find()->asArray()->all();
        return ArrayHelper::map($model, 'id', 'name');
    }
    
    public static function getCount($category_id)
    {
        return Topic::find()
                ->where(['category_id' => $category_id])
                ->count();
    }
    
    public static function getTopicName($id)
    {
        $model = Topic::findOne($id);
        return $model->name;
    }
    
    public static function getFirstPostOfTopic($topic_id)
    {
         return $model = Post::find()
                       ->joinWith('user')
                       ->where(['topic_id' => $topic_id])
                       ->orderBy('created_at ASC')
                       ->one();   
    }
    
    
    
    
    
    
}
