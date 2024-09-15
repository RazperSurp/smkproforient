<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_labels_type}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%colors}}`
 */
class m240915_092632_create_tasks_labels_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_labels_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer(),
            'alias' => $this->integer(),
            'colors_id' => $this->integer(),
        ]);

        // creates index for column `colors_id`
        $this->createIndex(
            '{{%idx-tasks_labels_type-colors_id}}',
            '{{%tasks_labels_type}}',
            'colors_id'
        );

        // add foreign key for table `{{%colors}}`
        $this->addForeignKey(
            '{{%fk-tasks_labels_type-colors_id}}',
            '{{%tasks_labels_type}}',
            'colors_id',
            '{{%colors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%colors}}`
        $this->dropForeignKey(
            '{{%fk-tasks_labels_type-colors_id}}',
            '{{%tasks_labels_type}}'
        );

        // drops index for column `colors_id`
        $this->dropIndex(
            '{{%idx-tasks_labels_type-colors_id}}',
            '{{%tasks_labels_type}}'
        );

        $this->dropTable('{{%tasks_labels_type}}');
    }
}
