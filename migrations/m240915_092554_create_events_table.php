<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%events_type}}`
 */
class m240915_092554_create_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%events}}', [
            'id' => $this->primaryKey(),
            'events_type_id' => $this->integer(),
            'epoch' => $this->integer()->defaultExpression('extract(epoch from now())'),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `events_type_id`
        $this->createIndex(
            '{{%idx-events-events_type_id}}',
            '{{%events}}',
            'events_type_id'
        );

        // add foreign key for table `{{%events_type}}`
        $this->addForeignKey(
            '{{%fk-events-events_type_id}}',
            '{{%events}}',
            'events_type_id',
            '{{%events_type}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%events_type}}`
        $this->dropForeignKey(
            '{{%fk-events-events_type_id}}',
            '{{%events}}'
        );

        // drops index for column `events_type_id`
        $this->dropIndex(
            '{{%idx-events-events_type_id}}',
            '{{%events}}'
        );

        $this->dropTable('{{%events}}');
    }
}
