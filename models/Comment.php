<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $value
 * @property string $created
 * @property int $author_id
 * @property int $task_id
 *
 * @property User $author
 * @property Task $task
 */
class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['value', 'created', 'author_id', 'task_id'], 'required']
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}