<?php

namespace app\controllers;

use yii\filters\AccessControl;
 
use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view', 'create', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['indexPost'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewPost'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createPost'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deletePost'],
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('updateOwnPost', ['post' => $model]) || \Yii::$app->user->can('updatePost')) {
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                'model' => $model,
            ]);
            }
            
        }else{
            throw new \yii\web\HttpException(403, 'The requested Item could not be found.');
        }
        
        
       
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $user_id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /** 
     * Akcja renderująca listę postów, model jest przesyłany dla formularza
     * umożliwiającego dodanie dowego wpisu do odwiedzonego tematu. 
     * Dane takie jak user_id czy topic_id uzupełniane są automatycznie.
     */
    
    public function actionPost($topic_id)
    {
        $postModel = new Post;
        
        if(!Yii::$app->user->isGuest){
            $postModel->user_id = Yii::$app->user->identity->id;
            $postModel->topic_id = $topic_id;
        }
        
        $provider = (new PostSearch())->provider($topic_id);
        
        if ($postModel->load(Yii::$app->request->post()) && $postModel->save()) {
            return $this->refresh();
        }else{
            return $this->render('posts', [ 'provider' => $provider, 'topic_id' => $topic_id, 'postModel' => $postModel]);
        }
    }
    
    public function actionEditPost($id)
    {
        $model = Post::findOne($id);
        
        if(\Yii::$app->user->can('updateOwnPost', ['post' => $model]) || \Yii::$app->user->can('updatePost')) {
        
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->save();

                $provider = (new PostSearch())->provider($model->topic_id);

                return $this->render('posts', [ 'provider' => $provider, 'topic_id' => $model->topic_id, 'postModel' => $model]);
            }else{
                return $this->render('editPost', ['model' => $model]);
            }
        }else{
            throw new \yii\web\HttpException(403, 'The requested Item could not be found.');
        }
    }
}
