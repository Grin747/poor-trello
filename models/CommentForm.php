<?php


namespace app\models;


use yii\base\Model;

class CommentForm extends Model
{
    public $value;
    public $task_id;

    public function rules()
    {
        return [
            [['value', 'task_id'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return ['value' => 'Comment'];
    }
}