<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events_type}}`.
 */
class m240915_092551_create_events_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%events_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%events_type}}');
    }
}
