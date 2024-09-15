<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%constants}}`.
 */
class m240915_092610_create_constants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%constants}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->unique(),
            'value' => $this->text()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%constants}}');
    }
}
