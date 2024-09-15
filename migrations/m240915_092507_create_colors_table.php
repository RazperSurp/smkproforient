<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%colors}}`.
 */
class m240915_092507_create_colors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%colors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer(),
            'hex' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%colors}}');
    }
}
