<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
       
        /**
         * REGULAR USER PERMISSION:
         * - creating topics
         * - creating posts
         * - updating own posts 
         */
        
        $createPost = $auth->createPermission('createPost');
        $createPost->description = "Create a post";
        $auth->add($createPost);
        
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = "Update a own post";
        $auth->add($updateOwnPost);
        
        $createTopic = $auth->createPermission('createTopic');
        $createTopic->description = "Create a topic";
        $auth->add($createTopic);
        
        /**
         * MODERATOR PERMISSION:
         * - inherite the USER permission
         * - updating everyone's posts
         */
        
        $updateEveryPost = $auth->createPermission('updateEveryPost');
        $updateEveryPost->description = "Update a every post";
        $auth->add($updateEveryPost);
        
        /**
         * ADMIN PERMISSION:
         * - inherite the MODERATOR (with USER) permission
         * - all CRUD operations
         */
        //                TO DO  
        /*
         * CREATING ROLES:
         */
        
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $updateOwnPost);
        $auth->addChild($user, $createTopic);
        
        $moderator = $auth->createRole('moderator');
        $auth->add($moderator);
        $auth->addChild($moderator, $updateEveryPost);
        $auth->addChild($moderator, $user);
        
        $admin = $auth->createRole('admin');
        
        /*
         * ASSIGN ROLES TO USERS:  
         */
        //                TO DO  
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
}

?>