<?php

namespace app\controllers;

use Yii;
use app\models\UserProfile;
use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserProfileController extends Controller {

    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
    
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionUpdate() {
       
        $model =  UserProfile::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $model->save();
            return $this->render('index', ['model' => $model]);   
            
        }
        return $this->render('update', ['model' => $model]);
    }

}
