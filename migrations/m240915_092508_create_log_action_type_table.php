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
            'name' => $this->text()->unique(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('log_action_type', ['name'], [
            ['INSERT'],
            ['UPDATE'],
            ['IRR_DELETE'],
            ['REV_DELETE'],
            ['DIRECT_INSERT'],
            ['DIRECT_UPDATE'],
            ['DIRECT_IRR_DELETE'],
            ['DIRECT_REV_DELETE']
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log_action_type}}');
    }
}
