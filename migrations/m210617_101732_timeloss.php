<?php

use yii\db\Migration;

/**
 * Class m210617_101732_timeloss
 */
class m210617_101732_timeloss extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('timelosses', [
            'id' => $this->primaryKey(),
            'loss' => $this->integer()->notNull(),
            'title' => $this->text()->notNull(),
            'created' => $this->date()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'idx-loss-author',
            'timelosses',
            'author_id'
        );

        $this->addForeignKey(
            'fk-loss-author',
            'timelosses',
            'author_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-loss-task',
            'timelosses',
            'task_id'
        );

        $this->addForeignKey(
            'fk-loss-task',
            'timelosses',
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
        $this->dropTable('timelosses');

        return true;
    }
}
