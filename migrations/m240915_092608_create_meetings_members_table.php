<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meetings_members}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%meetings}}`
 * - `{{%users}}`
 */
class m240915_092608_create_meetings_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meetings_members}}', [
            'id' => $this->primaryKey(),
            'meetings_id' => $this->integer(),
            'users_id' => $this->integer(),
            'is_responsible' => $this->boolean()->null()->defaultValue(false),
            'is_employee' => $this->boolean()->null()->defaultValue(false),
            'is_deleted' => $this->boolean()->null()->defaultValue(false)
        ]);

        // creates index for column `meetings_id`
        $this->createIndex(
            '{{%idx-meetings_members-meetings_id}}',
            '{{%meetings_members}}',
            'meetings_id'
        );

        // add foreign key for table `{{%meetings}}`
        $this->addForeignKey(
            '{{%fk-meetings_members-meetings_id}}',
            '{{%meetings_members}}',
            'meetings_id',
            '{{%meetings}}',
            'id',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-meetings_members-users_id}}',
            '{{%meetings_members}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-meetings_members-users_id}}',
            '{{%meetings_members}}',
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
        // drops foreign key for table `{{%meetings}}`
        $this->dropForeignKey(
            '{{%fk-meetings_members-meetings_id}}',
            '{{%meetings_members}}'
        );

        // drops index for column `meetings_id`
        $this->dropIndex(
            '{{%idx-meetings_members-meetings_id}}',
            '{{%meetings_members}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-meetings_members-users_id}}',
            '{{%meetings_members}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-meetings_members-users_id}}',
            '{{%meetings_members}}'
        );

        $this->dropTable('{{%meetings_members}}');
    }
}
