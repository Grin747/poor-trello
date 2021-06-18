<?php

namespace app\models\forms;

use yii\base\Model;

class LossForm extends Model
{
    public string $title;
    public int $loss;
    public int $task_id;

    public function rules(): array
    {
        return [
            [['loss', 'title', 'task_id'], 'required', 'message' => 'required'],
            ['title', 'string'],
            ['loss', 'integer', 'message' => 'Loss must be a number']
        ];
    }

    public function attributeLabels(): array
    {
        return ['value' => 'Comment', 'loss' => 'Loss'];
    }
}