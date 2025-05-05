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

        Yii::$app->db->createCommand()->batchInsert('constants', ['name', 'value'], [
            ['MSG_TMPT', 'Здравствуйте! Меня зовут {{user->name}}, я представляю отдел науки и проф. ориентации Ставропольского Многопрофильного колледжа.']
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%constants}}');
    }
}
