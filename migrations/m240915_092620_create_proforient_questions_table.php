<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proforient_questions}}`.
 */
class m240915_092620_create_proforient_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proforient_questions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'is_deleted' => $this->boolean()->defaultValue('false'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%proforient_questions}}');
    }
}
