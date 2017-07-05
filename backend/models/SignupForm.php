<?php
namespace backend\models;

use common\models\Adminuser;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $profile;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '邮箱地址已存在'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入不一致'],

            ['name','required'],
            ['name','string','max'=>128],

            ['profile','string',],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'username' => '用户名',
            'password' => '密码',
            'password_repeat' => '重输密码',
            'email' => '邮箱',
            'profile' => '个人说明',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new Adminuser();
            $user->username = $this->username;
            $user->name=$this->name;
            $user->profile=$this->profile;
            $user->email = $this->email;
            $user->password='*';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
