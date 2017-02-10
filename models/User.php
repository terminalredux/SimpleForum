<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\helpers\HtmlPurifier;



/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property string $register_token
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post[] $posts
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    const USER_TYPE_SUPER_ADMIN = 1;

    public function behaviors() {
        return [TimestampBehavior::class];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'password', 'status', 'register_token'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password', 'register_token', 'auth_key'], 'string', 'max' => 255],
            [['email', 'register_token'], 'unique'],
            [['email', 'password', 'name'], function ($attribute) {
                    $this->$attribute = HtmlPurifier::process($this->$attribute);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
            'register_token' => Yii::t('app', 'Register Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts() {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['register_token' => $token]);
    }

    public function getId() {
        return $this->id;
    }

    // AUTH KEY ----------------------------------------------------------------

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function setAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    // PASSWORD ----------------------------------------------------------------
    
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function setRegisterToken() {
        $this->register_token = Yii::$app->security->generateRandomString();
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function getUserRole($id)
    {
        $role = (new \yii\db\Query())
                ->select('item_name')
                ->from('auth_assignment')
                ->where(['user_id' => $id])
                ->one();
        
        return $role;
    }

}
