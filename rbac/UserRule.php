<?php

namespace app\rbac;
use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'isUser';
    
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }
}
?>