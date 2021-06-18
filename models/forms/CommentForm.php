<?php


namespace app\models\forms;


use yii\base\Model;

class CommentForm extends Model
{
    public string $value;
    public int $task_id;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['value', 'task_id'], 'required', 'message' => 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return ['value' => 'Comment'];
    }
}