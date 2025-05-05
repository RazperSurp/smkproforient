<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tg_authorized}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m240915_092613_create_tg_authorized_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tg_authorized}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'auth_code' => $this->string(8),
            'tg_id' => $this->text(),
            'epoch' => $this->integer()->defaultExpression('extract(epoch from now())'),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-tg_authorized-users_id}}',
            '{{%tg_authorized}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-tg_authorized-users_id}}',
            '{{%tg_authorized}}',
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
            '{{%fk-tg_authorized-users_id}}',
            '{{%tg_authorized}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-tg_authorized-users_id}}',
            '{{%tg_authorized}}'
        );

        $this->dropTable('{{%tg_authorized}}');
    }
}
