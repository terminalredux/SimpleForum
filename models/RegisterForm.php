<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;


class RegisterForm extends Model
{
   
    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE = 1;
   
    public $email;
    public $password;
    public $password_repeat;
    
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required', 'message' => 'Pole wymagane'],
            ['email', 'email', 'message' => 'To musi byc adres email'],
            [['password', 'password_repeat'], 'string', 'max' => 10, 'min'=>6],
            ['password', 'compare'],
            [['email', 'password'], function ($attribute) {
                    $this->$attribute = HtmlPurifier::process($this->$attribute);
            }],
        ];
    }
    
    public function singup()
    {
        if(!$this->validate()){
            return null;
        }
        
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->status = self::STATUS_UNACTIVE;
        $user->setRegisterToken();
        $user->setAuthKey();
        
        if($user->save()){
            
            $link = Url::to(['site/account-activation', 'token' => $user->register_token, 'id' => $user->id], true);
            
            Yii::$app->mailer->compose()
                        ->setFrom('yiiforum@mail.com')
                        ->setTo($user->email)
                        ->setSubject('Rejestracja na forum')
                        ->setHtmlBody('<a href="' . $link . '">Link aktywacyjny</a>')
                        ->send();
            
           return true; 
            
        }else{
            
            return null;
            
        }
        
       
    }
    
    
}

?>


