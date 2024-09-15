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

        Yii::$app->db->createCommand()->batchInsert('schools_budget_type', ['name', 'alias'], [
            ['Муниципальное казенное образовательное учреждение', 'МКОУ'],
            ['Муниципальное бюджетное образовательное учреждение', 'МБОУ'],
            ['Государственное бюджетное образовательное учреждение', 'ГБОУ'],
            ['Муниципальное автономное образовательное учреждение', 'МАОУ'],
            ['Частное образовательное учреждение', 'ЧОУ'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%schools_budget_type}}');
    }
}
