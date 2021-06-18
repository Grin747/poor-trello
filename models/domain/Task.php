<?php

namespace app\models\domain;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $created
 * @property string|null $deadline
 * @property int|null $author_id
 * @property int|null $assignee_id
 * @property int|null $status_id
 *
 * @property Status $status
 * @property User $author
 * @property User $assignee
 */
class Task extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'created'], 'required'],
            [['description'], 'string'],
            [['created', 'deadline'], 'safe'],
            [['author_id', 'assignee_id', 'status_id'], 'default', 'value' => null],
            [['author_id', 'assignee_id', 'status_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['assignee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['assignee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created' => 'Created',
            'deadline' => 'Deadline',
            'author_id' => 'Author ID',
            'assignee_id' => 'Assignee ID',
            'status_id' => 'Status ID',
        ];
    }

    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getAssignee(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'assignee_id']);
    }
}
