<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ugs}}`.
 */
class m240915_092615_create_ugs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ugs}}', [
            'id' => $this->primaryKey(),
            'okso' => $this->string(8),
            'name' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ugs}}');
    }
}
