<?php

namespace app\controllers;

use Yii;
use app\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RbacController implements the CRUD actions for AuthItem model.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','view','delete'],
                        'roles' => ['accessAuth'],
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

  
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // POST PERMISSION ----------------------------------------------------- 
        
        $indexPost = $auth->createPermission('indexPost');
        $indexPost->description = 'Create a index';
        $auth->add($indexPost);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Update post';
        $auth->add($createPost);
        
        $viewPost = $auth->createPermission('viewPost');
        $viewPost->description = 'View a post';
        $auth->add($viewPost);
        
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update a post on CRUD table';
        $auth->add($updatePost);
        
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete a post';
        $auth->add($deletePost);
        
        $editPost = $auth->createPermission('editPost');  // action on forum
        $editPost->description = "editing post on forum";
        $auth->add($editPost);
        
        // AUTH PERMISSION --------------
        
        $accessAuth = $auth->createPermission('accessAuth');
        $accessAuth->description = 'Give a access to whole auth crud operations';
        $auth->add($accessAuth);
        
        // CATEGORY PERMISSION ----------
        
        $accessCategory = $auth->createPermission('accessCategory');
        $accessCategory->description = 'Give a access to whole category crud operations';
        $auth->add($accessCategory);
        
        // TOPIC PERMISSION -------------
        
        $indexTopic = $auth->createPermission('indexTopic');
        $indexTopic->description = "show topic index";
        $auth->add($indexTopic);
        
        $viewTopic = $auth->createPermission('viewTopic');
        $viewTopic->description = "view topic";
        $auth->add($viewTopic);
        
        $createTopic = $auth->createPermission('createTopic');
        $createTopic->description = "create topic";
        $auth->add($createTopic);
        
        $updateTopic = $auth->createPermission('updateTopic');
        $updateTopic->description = "update topic";
        $auth->add($updateTopic);
        
        $deleteTopic = $auth->createPermission('deleteTopic');
        $deleteTopic->description = "delete topic";
        $auth->add($deleteTopic);
        
        // USER PERMISSION --------------
        
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = "show user index";
        $auth->add($indexUser);
        
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = "view user";
        $auth->add($viewUser);
        
        $createUser = $auth->createPermission('createUser');
        $createUser->description = "create user";
        $auth->add($createUser);
        
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = "update user";
        $auth->add($updateUser);
        
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = "delete user";
        $auth->add($deleteUser);
        
        // ROLES ---------------------------------------------------------------
        
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $indexPost);
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $viewPost);
        $auth->addChild($user, $indexTopic);
        $auth->addChild($user, $viewTopic);
        $auth->addChild($user, $createTopic);
        $auth->addChild($user, $indexUser);
        $auth->addChild($user, $viewUser);
        
        $mod = $auth->createRole('mod');
        $auth->add($mod);
        $auth->addChild($mod, $user);
        $auth->addChild($mod, $updatePost);
        $auth->addChild($mod, $updateTopic);
        $auth->addChild($mod, $updateUser);
        $auth->addChild($mod, $editPost);
        
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $mod);
        $auth->addChild($admin, $deletePost);
        $auth->addChild($admin, $deleteTopic);
        $auth->addChild($admin, $accessAuth);
        $auth->addChild($admin, $accessCategory);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $deleteUser);
        
        // ASSIGNMENTS ROLES TO USER -------------------------------------------
        
        $auth->assign($user, 60);     
        $auth->assign($mod, 61);     
        $auth->assign($admin, 62);    
    }
    
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
