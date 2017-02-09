<?php

namespace app\controllers;

use Yii;
use app\models\Topic;
use app\models\Post;
use app\models\TopicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\Category;
use app\models\PostSearch;
use yii\filters\AccessControl;

/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'add-topic'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexTopic'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewTopic'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createTopic'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateTopic'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteTopic'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-topic'],
                        'roles' => ['createTopic'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TopicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Topic model.
     * @param integer $id
     * @param integer $category_id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $category_id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Topic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $category_id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $category_id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTopic($category_id) 
    {    
        
        $provider = new TopicSearch;
        $provider = $provider->provider($category_id);

        return $this->render('topic', ['provider' => $provider, 'category_id' => $category_id]);
    }
    
    /**
     * Akcja dodaje topic wraz z pierwszym postem.
     * topicModel & postModel nie muszą być sprawdzane pod kątem tego
     * czy user nie jest gościem ponieważ do akcji dopuszczani są tylko
     * zalogowani (zdefiniowane w AccessControl kontrolera). 
     */
    
    public function actionAddTopic($category_id)
    {
        $topicModel = new Topic;
        $postModel = new Post;
        
        $topicModel->category_id = $category_id;
        $postModel->user_id = Yii::$app->user->identity->id; 
        
        if($topicModel->load(Yii::$app->request->post()) && $postModel->load(Yii::$app->request->post())){
            
            $idValid = $topicModel->validate();
            $isValid = $postModel->validate() && $isValid;
            
            $topicModel->save();
            $postModel->topic_id = $topicModel->id;
            $postModel->save(); 
            
            $provider = new TopicSearch();
            $provider = $provider->provider($topicModel->category_id);
            
            return $this->render('topic', ['provider' => $provider, 'category_id' => $category_id]); 
            
        }else{
           return $this->render('addTopic', ['topicModel' => $topicModel, 'postModel' => $postModel]); 
        }
    }
    
    
}
