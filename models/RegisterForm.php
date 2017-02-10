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
    public $name;
    
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'password_repeat'], 'required', 'message' => 'Pole wymagane'],
            ['name',  'unique', 'targetClass' => '\app\models\User', 'message' => 'Nazwa użytkowika jest już zajęta'],
            ['email', 'email', 'message' => 'To musi byc adres email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Adres email jest już zajęty'],
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
        $user->name = $this->name;
        $user->setPassword($this->password);
        $user->status = self::STATUS_UNACTIVE;
        $user->setRegisterToken();
        $user->setAuthKey();
        
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        
        try {
            
            if($user->save()){

                //RBAC, adding role to user
                $auth = \Yii::$app->authManager;
                $userRole = $auth->getRole('user'); 
                $auth->assign($userRole, $user->getId()); 

                $link = Url::to(['site/account-activation', 'token' => $user->register_token], true);

                Yii::$app->mailer->compose()
                            ->setFrom('yiiforum@mail.com')
                            ->setTo($user->email)
                            ->setSubject('Rejestracja na forum')
                            ->setHtmlBody('<a href="' . $link . '">Link aktywacyjny</a>')
                            ->send();

               $transaction->commit(); 
               return true; 

            }else{
                return null;
            }
            
        } catch (Exception $e) {
            $transaction->rollback();
        }
    } 
}
?>


