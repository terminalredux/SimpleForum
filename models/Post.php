<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\Topic;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Topic $topic
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
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
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            [['user_id', 'topic_id', 'content'], 'required'],
            [['user_id', 'topic_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['content'], function ($attribute) {
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
            'user_id' => Yii::t('app', 'User ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    
    
    public function getUserList()
    {
        $models = User::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
    
    public static function countPostInTopic($topic_id)
    {
        return Post::find()->where(['topic_id' => $topic_id])->count();
    }
    
    public function getTopicAuthorID()
    {
        $model = Post::find(1)->one();
        return $model;
    }
    
    public static function countPostOfUser($user_id)
    {
        return Post::find()->where(['user_id' => $user_id])->count();
    }
    
    public function afterSave() {
       return $this->topic->touch('last_post');
    }
    
    public static function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    
    
     
}
