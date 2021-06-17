<?php

namespace app\models;

use yii\base\Model;

class LossForm extends Model
{
    public $title;
    public $loss;
    public $task_id;

    public function rules()
    {
        return [
            [['loss', 'title', 'task_id'], 'required', 'message' => 'required'],
            ['title', 'string'],
            ['loss', 'integer', 'message' => 'Loss must be a number']
        ];
    }

    public function attributeLabels()
    {
        return ['value' => 'Comment', 'loss' => 'Loss'];
    }
}