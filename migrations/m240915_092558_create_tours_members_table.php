<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tours_members}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tours}}`
 * - `{{%users}}`
 */
class m240915_092558_create_tours_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tours_members}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer(),
            'users_id' => $this->integer(),
            'is_responsible' => $this->boolean()->null()->defaultValue(false),
            'is_deleted' => $this->boolean()->null()->defaultValue(false),
        ]);

        // creates index for column `tours_id`
        $this->createIndex(
            '{{%idx-tours_members-tours_id}}',
            '{{%tours_members}}',
            'tours_id'
        );

        // add foreign key for table `{{%tours}}`
        $this->addForeignKey(
            '{{%fk-tours_members-tours_id}}',
            '{{%tours_members}}',
            'tours_id',
            '{{%tours}}',
            'id',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-tours_members-users_id}}',
            '{{%tours_members}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tours_members-users_id}}',
            '{{%tours_members}}',
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
        // drops foreign key for table `{{%tours}}`
        $this->dropForeignKey(
            '{{%fk-tours_members-tours_id}}',
            '{{%tours_members}}'
        );

        // drops index for column `tours_id`
        $this->dropIndex(
            '{{%idx-tours_members-tours_id}}',
            '{{%tours_members}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-tours_members-users_id}}',
            '{{%tours_members}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-tours_members-users_id}}',
            '{{%tours_members}}'
        );

        $this->dropTable('{{%tours_members}}');
    }
}
