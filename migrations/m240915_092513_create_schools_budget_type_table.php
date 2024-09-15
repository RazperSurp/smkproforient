<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schools_budget_type}}`.
 */
class m240915_092513_create_schools_budget_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%schools_budget_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'alias' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%schools_budget_type}}');
    }
}
