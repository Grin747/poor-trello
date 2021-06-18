<?php


namespace app\models\domain;

use yii\db\ActiveQuery;
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
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['value', 'created', 'author_id', 'task_id'], 'required']
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}