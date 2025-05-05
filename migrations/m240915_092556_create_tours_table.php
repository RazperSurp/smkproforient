<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tours}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%schools}}`
 * - `{{%events}}`
 */
class m240915_092556_create_tours_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tours}}', [
            'id' => $this->primaryKey(),
            'schools_id' => $this->integer(),
            'events_id' => $this->integer(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `schools_id`
        $this->createIndex(
            '{{%idx-tours-schools_id}}',
            '{{%tours}}',
            'schools_id'
        );

        // add foreign key for table `{{%schools}}`
        $this->addForeignKey(
            '{{%fk-tours-schools_id}}',
            '{{%tours}}',
            'schools_id',
            '{{%schools}}',
            'id',
            'CASCADE'
        );

        // creates index for column `events_id`
        $this->createIndex(
            '{{%idx-tours-events_id}}',
            '{{%tours}}',
            'events_id'
        );

        // add foreign key for table `{{%events}}`
        $this->addForeignKey(
            '{{%fk-tours-events_id}}',
            '{{%tours}}',
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
        // drops foreign key for table `{{%schools}}`
        $this->dropForeignKey(
            '{{%fk-tours-schools_id}}',
            '{{%tours}}'
        );

        // drops index for column `schools_id`
        $this->dropIndex(
            '{{%idx-tours-schools_id}}',
            '{{%tours}}'
        );

        // drops foreign key for table `{{%events}}`
        $this->dropForeignKey(
            '{{%fk-tours-events_id}}',
            '{{%tours}}'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            '{{%idx-tours-events_id}}',
            '{{%tours}}'
        );

        $this->dropTable('{{%tours}}');
    }
}
