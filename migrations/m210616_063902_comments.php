<?php

use yii\db\Migration;

/**
 * Class m210616_063902_comments
 */
class m210616_063902_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'value' => $this->text()->notNull(),
            'created' => $this->date()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'idx-comment-author',
            'comments',
            'author_id'
        );

        $this->addForeignKey(
            'fk-comment-author',
            'comments',
            'author_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-comment-task',
            'comments',
            'task_id'
        );

        $this->addForeignKey(
            'fk-comment-task',
            'comments',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');

        return true;
    }
}
