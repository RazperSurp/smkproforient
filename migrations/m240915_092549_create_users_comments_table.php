<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m240915_092549_create_users_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_comments}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'table' => $this->text(),
            'primary_key' => $this->integer(),
            'value' => $this->text(),
            'is_public' => $this->boolean()->null()->defaultValue(false),
            'is_deleted' => $this->boolean()->null()->defaultValue(false),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-users_comments-users_id}}',
            '{{%users_comments}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_comments-users_id}}',
            '{{%users_comments}}',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_comments-users_id}}',
            '{{%users_comments}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-users_comments-users_id}}',
            '{{%users_comments}}'
        );

        $this->dropTable('{{%users_comments}}');
    }
}
