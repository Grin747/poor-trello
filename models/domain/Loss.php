<?php

namespace app\models\domain;

use yii\db\ActiveQuery;
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
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'timelosses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['loss', 'title', 'created', 'author_id', 'task_id'], 'required']
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}