<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_labels}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%tasks_labels_type}}`
 */
class m999999_999998_template_engine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%template_engine}}', [
            'id' => $this->primaryKey(),
            'table' => $this->text(),
            'value' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%template_engine}}');
    }
}
