<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts_type}}`.
 */
class m240915_092542_create_contacts_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer(),
            'alias' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contacts_type}}');
    }
}
