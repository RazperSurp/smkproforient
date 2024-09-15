<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%colors}}`
 * - `{{%schools}}`
 * - `{{%events}}`
 */
class m240915_092627_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'colors_id' => $this->integer(),
            'schools_id' => $this->integer()->null(),
            'events_id' => $this->integer(),
            'name' => $this->text(),
            'description' => $this->text()->null(),
            'epoch_start' => $this->integer()->defaultExpression('extract(epoch from now())'),
            'epoch_end' => $this->integer()->defaultExpression('extract(epoch from now())'),
            'is_deleted' => $this->boolean()->defaultValue('false'),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-tasks-users_id}}',
            '{{%tasks}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tasks-users_id}}',
            '{{%tasks}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `colors_id`
        $this->createIndex(
            '{{%idx-tasks-colors_id}}',
            '{{%tasks}}',
            'colors_id'
        );

        // add foreign key for table `{{%colors}}`
        $this->addForeignKey(
            '{{%fk-tasks-colors_id}}',
            '{{%tasks}}',
            'colors_id',
            '{{%colors}}',
            'id',
            'CASCADE'
        );

        // creates index for column `schools_id`
        $this->createIndex(
            '{{%idx-tasks-schools_id}}',
            '{{%tasks}}',
            'schools_id'
        );

        // add foreign key for table `{{%schools}}`
        $this->addForeignKey(
            '{{%fk-tasks-schools_id}}',
            '{{%tasks}}',
            'schools_id',
            '{{%schools}}',
            'id',
            'CASCADE'
        );

        // creates index for column `events_id`
        $this->createIndex(
            '{{%idx-tasks-events_id}}',
            '{{%tasks}}',
            'events_id'
        );

        // add foreign key for table `{{%events}}`
        $this->addForeignKey(
            '{{%fk-tasks-events_id}}',
            '{{%tasks}}',
            'events_id',
            '{{%events}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tasks-users_id}}',
            '{{%tasks}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-tasks-users_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%colors}}`
        $this->dropForeignKey(
            '{{%fk-tasks-colors_id}}',
            '{{%tasks}}'
        );

        // drops index for column `colors_id`
        $this->dropIndex(
            '{{%idx-tasks-colors_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%schools}}`
        $this->dropForeignKey(
            '{{%fk-tasks-schools_id}}',
            '{{%tasks}}'
        );

        // drops index for column `schools_id`
        $this->dropIndex(
            '{{%idx-tasks-schools_id}}',
            '{{%tasks}}'
        );

        // drops foreign key for table `{{%events}}`
        $this->dropForeignKey(
            '{{%fk-tasks-events_id}}',
            '{{%tasks}}'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            '{{%idx-tasks-events_id}}',
            '{{%tasks}}'
        );

        $this->dropTable('{{%tasks}}');
    }
}
