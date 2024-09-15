<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_contacts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%contacts_type}}`
 */
class m240915_092544_create_users_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_contacts}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'contacts_type_id' => $this->integer(),
            'value' => $this->integer(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-users_contacts-users_id}}',
            '{{%users_contacts}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_contacts-users_id}}',
            '{{%users_contacts}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `contacts_type_id`
        $this->createIndex(
            '{{%idx-users_contacts-contacts_type_id}}',
            '{{%users_contacts}}',
            'contacts_type_id'
        );

        // add foreign key for table `{{%contacts_type}}`
        $this->addForeignKey(
            '{{%fk-users_contacts-contacts_type_id}}',
            '{{%users_contacts}}',
            'contacts_type_id',
            '{{%contacts_type}}',
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
            '{{%fk-users_contacts-users_id}}',
            '{{%users_contacts}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-users_contacts-users_id}}',
            '{{%users_contacts}}'
        );

        // drops foreign key for table `{{%contacts_type}}`
        $this->dropForeignKey(
            '{{%fk-users_contacts-contacts_type_id}}',
            '{{%users_contacts}}'
        );

        // drops index for column `contacts_type_id`
        $this->dropIndex(
            '{{%idx-users_contacts-contacts_type_id}}',
            '{{%users_contacts}}'
        );

        $this->dropTable('{{%users_contacts}}');
    }
}
