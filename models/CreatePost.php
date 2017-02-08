<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CreatePost extends Model{
    
    public $topic;
    public $user;
    public $message;
    
    public function rules()
    {
        return [
            [['topic', 'user', 'message'], 'required'],
        ];
    }
}

?>