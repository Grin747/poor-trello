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
            [['deadline'], 'date', 'format' => 'yyyy-MM-dd'],
            [['deadline', 'description'], 'default']
        ];
    }

    public function attributeLabels()
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