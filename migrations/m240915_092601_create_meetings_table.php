<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meetings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%events}}`
 * - `{{%auditoriums}}`
 */
class m240915_092601_create_meetings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meetings}}', [
            'id' => $this->primaryKey(),
            'events_id' => $this->integer(),
            'auditoriums_id' => $this->integer(),
            'name' => $this->text(),
            'epoch' => $this->integer()->defaultExpression('extract(epoch from now())'),
        ]);

        // creates index for column `events_id`
        $this->createIndex(
            '{{%idx-meetings-events_id}}',
            '{{%meetings}}',
            'events_id'
        );

        // add foreign key for table `{{%events}}`
        $this->addForeignKey(
            '{{%fk-meetings-events_id}}',
            '{{%meetings}}',
            'events_id',
            '{{%events}}',
            'id',
            'CASCADE'
        );

        // creates index for column `auditoriums_id`
        $this->createIndex(
            '{{%idx-meetings-auditoriums_id}}',
            '{{%meetings}}',
            'auditoriums_id'
        );

        // add foreign key for table `{{%auditoriums}}`
        $this->addForeignKey(
            '{{%fk-meetings-auditoriums_id}}',
            '{{%meetings}}',
            'auditoriums_id',
            '{{%auditoriums}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%events}}`
        $this->dropForeignKey(
            '{{%fk-meetings-events_id}}',
            '{{%meetings}}'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            '{{%idx-meetings-events_id}}',
            '{{%meetings}}'
        );

        // drops foreign key for table `{{%auditoriums}}`
        $this->dropForeignKey(
            '{{%fk-meetings-auditoriums_id}}',
            '{{%meetings}}'
        );

        // drops index for column `auditoriums_id`
        $this->dropIndex(
            '{{%idx-meetings-auditoriums_id}}',
            '{{%meetings}}'
        );

        $this->dropTable('{{%meetings}}');
    }
}
