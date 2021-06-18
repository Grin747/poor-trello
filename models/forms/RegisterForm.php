<?php


namespace app\models\forms;


use app\models\domain\User;
use yii\base\Model;

class RegisterForm extends Model
{
    public string $username;
    public string $password;
    public string $confirm;

    public function rules(): array
    {
        return [
            [['username', 'password', 'confirm'], 'required', 'message' => 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Login is taken']
        ];
    }
}