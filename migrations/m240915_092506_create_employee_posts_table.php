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

        Yii::$app->db->createCommand()->batchInsert('employee_posts', ['name'], [
            ['Администратор'],
            ['Директор'],
            ['Заместитель директора по учебно-воспитательной работе'],
            ['Заместитель директора по методической работе'],
            ['Заместитель директора по внеклассной работе'],
            ['Классный руководитель'],
            ['Помощник директора'],
            ['Советник директора'],
            ['Старший дворник'],
            ['Специалист отдела науки и профессиональной ориентации'],
            ['Начальник отдела науки и профессиональной ориентации'],
            ['Водитель']
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee_posts}}');
    }
}
