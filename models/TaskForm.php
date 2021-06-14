<?php

namespace app\models;

use yii\base\Model;

class TaskForm extends Model
{
    public $title;
    public $description;
    public $deadline;
    public $assignee;
    public $status;

    public function rules(): array
    {
        return [
            [['title', 'status', 'assignee'], 'required', 'message' => 'required'],
        ];
    }
}