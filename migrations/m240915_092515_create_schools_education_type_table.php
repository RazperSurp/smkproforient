<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schools_education_type}}`.
 */
class m240915_092515_create_schools_education_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%schools_education_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'alias' => $this->text(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('schools_education_type', ['name', 'alias'], [
            ['Начальная образовательная школа', 'НОШ'],
            ['Основная образовательная школа', 'ООШ'],
            ['Средняя образовательная школа', 'СОШ'],
            ['Малокомплектная школа', 'МШ'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%schools_education_type}}');
    }
}
