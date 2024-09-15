<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%log_action_type}}`
 */
class m240915_092533_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'log_action_type_id' => $this->integer(),
            'table' => $this->text(),
            'primary_key' => $this->integer(),
            'data' => $this->text(),
            'epoch' => $this->integer()->defaultExpression('extract(epoch from now())'),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-log-users_id}}',
            '{{%log}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-log-users_id}}',
            '{{%log}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `log_action_type_id`
        $this->createIndex(
            '{{%idx-log-log_action_type_id}}',
            '{{%log}}',
            'log_action_type_id'
        );

        // add foreign key for table `{{%log_action_type}}`
        $this->addForeignKey(
            '{{%fk-log-log_action_type_id}}',
            '{{%log}}',
            'log_action_type_id',
            '{{%log_action_type}}',
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
            '{{%fk-log-users_id}}',
            '{{%log}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-log-users_id}}',
            '{{%log}}'
        );

        // drops foreign key for table `{{%log_action_type}}`
        $this->dropForeignKey(
            '{{%fk-log-log_action_type_id}}',
            '{{%log}}'
        );

        // drops index for column `log_action_type_id`
        $this->dropIndex(
            '{{%idx-log-log_action_type_id}}',
            '{{%log}}'
        );

        $this->dropTable('{{%log}}');
    }
}
