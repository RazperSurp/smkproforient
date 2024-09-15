<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers_contacts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%contacts_type}}`
 * - `{{%managers}}`
 */
class m240915_092546_create_managers_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers_contacts}}', [
            'id' => $this->primaryKey(),
            'contacts_type_id' => $this->integer(),
            'managers_id' => $this->integer(),
            'value' => $this->text(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `contacts_type_id`
        $this->createIndex(
            '{{%idx-managers_contacts-contacts_type_id}}',
            '{{%managers_contacts}}',
            'contacts_type_id'
        );

        // add foreign key for table `{{%contacts_type}}`
        $this->addForeignKey(
            '{{%fk-managers_contacts-contacts_type_id}}',
            '{{%managers_contacts}}',
            'contacts_type_id',
            '{{%contacts_type}}',
            'id',
            'CASCADE'
        );

        // creates index for column `managers_id`
        $this->createIndex(
            '{{%idx-managers_contacts-managers_id}}',
            '{{%managers_contacts}}',
            'managers_id'
        );

        // add foreign key for table `{{%managers}}`
        $this->addForeignKey(
            '{{%fk-managers_contacts-managers_id}}',
            '{{%managers_contacts}}',
            'managers_id',
            '{{%managers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%contacts_type}}`
        $this->dropForeignKey(
            '{{%fk-managers_contacts-contacts_type_id}}',
            '{{%managers_contacts}}'
        );

        // drops index for column `contacts_type_id`
        $this->dropIndex(
            '{{%idx-managers_contacts-contacts_type_id}}',
            '{{%managers_contacts}}'
        );

        // drops foreign key for table `{{%managers}}`
        $this->dropForeignKey(
            '{{%fk-managers_contacts-managers_id}}',
            '{{%managers_contacts}}'
        );

        // drops index for column `managers_id`
        $this->dropIndex(
            '{{%idx-managers_contacts-managers_id}}',
            '{{%managers_contacts}}'
        );

        $this->dropTable('{{%managers_contacts}}');
    }
}
