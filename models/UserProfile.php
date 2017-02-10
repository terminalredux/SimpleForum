<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

class UserProfile extends User{
     
    
    public function rules(){
        return [
            ['name', 'required', 'message' => 'To pole jest wymagane'],
            ['name', 'string', 'min' => 10, 'max' => 20],
            ['name', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Zacznij od wielkiej litery (a-z0-9)'],
            ['email', 'email', 'message' => 'To musi być email'],
            [['email', 'name'], 'unique', 'message' => 'Zajęty'],
        ];
    } 
}
?>
