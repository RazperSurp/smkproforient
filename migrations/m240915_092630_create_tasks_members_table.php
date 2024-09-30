<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_members}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%users}}`
 */
class m240915_092630_create_tasks_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_members}}', [
            'id' => $this->primaryKey(),
            'tasks_id' => $this->integer(),
            'users_id' => $this->integer(),
            'is_deleted' => $this->boolean()->null()->defaultValue(false)
        ]);

        // creates index for column `tasks_id`
        $this->createIndex(
            '{{%idx-tasks_members-tasks_id}}',
            '{{%tasks_members}}',
            'tasks_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-tasks_members-tasks_id}}',
            '{{%tasks_members}}',
            'tasks_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-tasks_members-users_id}}',
            '{{%tasks_members}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks_members-users_id}}',
            '{{%tasks_members}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-tasks_members-tasks_id}}',
            '{{%tasks_members}}'
        );

        // drops index for column `tasks_id`
        $this->dropIndex(
            '{{%idx-tasks_members-tasks_id}}',
            '{{%tasks_members}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks_members-users_id}}',
            '{{%tasks_members}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-tasks_members-users_id}}',
            '{{%tasks_members}}'
        );

        $this->dropTable('{{%tasks_members}}');
    }
}
