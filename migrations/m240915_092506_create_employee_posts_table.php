<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee_posts}}`.
 */
class m240915_092506_create_employee_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee_posts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee_posts}}');
    }
}
