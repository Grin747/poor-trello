<?php

use yii\db\Migration;

/**
 * Class m210611_173108_init
 */
class m210611_173108_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull()
        ]);

        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'created' => $this->date()->notNull(),
            'deadline' => $this->date(),
            'author_id' => $this->integer(),
            'assignee_id' => $this->integer(),
            'status_id' => $this->integer()
        ]);

        $this->createTable('statuses', [
           'id' => $this->primaryKey(),
           'title' => $this->string()->notNull()->unique()
        ]);

        $this->createIndex(
            'idx-task-author',
            'tasks',
            'author_id'
        );

        $this->addForeignKey(
          'fk-task-author',
            'tasks',
            'author_id',
            'users',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-task-assignee',
            'tasks',
            'assignee_id'
        );

        $this->addForeignKey(
          'fk-task-assignee',
            'tasks',
            'assignee_id',
            'users',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-task-status',
            'tasks',
            'status_id'
        );

        $this->addForeignKey(
          'fk-task-status',
            'tasks',
            'status_id',
            'statuses',
            'id',
            'SET NULL'
        );

        $this->insert('statuses', [
            'id' => 1,
            'title' => 'created'
        ]);

        $this->insert('statuses', [
            'id' => 2,
            'title' => 'in progress'
        ]);

        $this->insert('statuses', [
            'id' => 3,
            'title' => 'testing'
        ]);

        $this->insert('statuses', [
            'id' => 4,
            'title' => 'done'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tasks');
        $this->dropTable('statuses');
        $this->dropTable('users');

        return true;
    }
}
