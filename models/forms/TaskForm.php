<?php

namespace app\models\forms;

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
            [['deadline'], 'date', 'format' => 'yyyy-MM-dd'],
            [['deadline', 'description'], 'default']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'deadline' => 'Deadline',
            'assignee' => 'Assignee',
            'status' => 'Status',
        ];
    }
}