<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log_action_type}}`.
 */
class m240915_092508_create_log_action_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log_action_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log_action_type}}');
    }
}
