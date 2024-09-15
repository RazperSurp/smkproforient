<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_labels}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%tasks_labels_type}}`
 */
class m240915_092637_create_tasks_labels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_labels}}', [
            'id' => $this->primaryKey(),
            'tasks_id' => $this->integer(),
            'tasks_labels_type_id' => $this->integer(),
            'is_deleted' => $this->integer(),
        ]);

        // creates index for column `tasks_id`
        $this->createIndex(
            '{{%idx-tasks_labels-tasks_id}}',
            '{{%tasks_labels}}',
            'tasks_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-tasks_labels-tasks_id}}',
            '{{%tasks_labels}}',
            'tasks_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tasks_labels_type_id`
        $this->createIndex(
            '{{%idx-tasks_labels-tasks_labels_type_id}}',
            '{{%tasks_labels}}',
            'tasks_labels_type_id'
        );

        // add foreign key for table `{{%tasks_labels_type}}`
        $this->addForeignKey(
            '{{%fk-tasks_labels-tasks_labels_type_id}}',
            '{{%tasks_labels}}',
            'tasks_labels_type_id',
            '{{%tasks_labels_type}}',
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
            '{{%fk-tasks_labels-tasks_id}}',
            '{{%tasks_labels}}'
        );

        // drops index for column `tasks_id`
        $this->dropIndex(
            '{{%idx-tasks_labels-tasks_id}}',
            '{{%tasks_labels}}'
        );

        // drops foreign key for table `{{%tasks_labels_type}}`
        $this->dropForeignKey(
            '{{%fk-tasks_labels-tasks_labels_type_id}}',
            '{{%tasks_labels}}'
        );

        // drops index for column `tasks_labels_type_id`
        $this->dropIndex(
            '{{%idx-tasks_labels-tasks_labels_type_id}}',
            '{{%tasks_labels}}'
        );

        $this->dropTable('{{%tasks_labels}}');
    }
}
