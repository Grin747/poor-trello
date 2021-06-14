<?php


namespace app\models;


class RegisterForm extends \yii\base\Model
{
    public $username;
    public $password;
    public $confirm;

    public function rules()
    {
        return [
            [['username', 'password', 'confirm'], 'required', 'message' => 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Login is taken']
        ];
    }
}