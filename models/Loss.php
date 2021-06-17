<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $loss
 * @property string $title
 * @property string $created
 * @property int $author_id
 * @property int $task_id
 *
 * @property User $author
 * @property Task $task
 */
class Loss extends ActiveRecord
{
    public static function tableName()
    {
        return 'timelosses';
    }

    public function rules()
    {
        return [
            [['loss', 'title', 'created', 'author_id', 'task_id'], 'required']
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}