<?php
namespace backend\models;

use common\models\Adminuser;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $password;
    public $password_repeat;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入不一致'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password_repeat' => '重输密码',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {return null;}
            $adminuser= Adminuser::findOne($id);
            $adminuser->setPassword($this->password);
            $adminuser->removePasswordResetToken();
            if ($adminuser->save()) {
                return true;
            }
            return false;
    }
}
