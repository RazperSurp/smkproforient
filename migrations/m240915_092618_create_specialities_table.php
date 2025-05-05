<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%specialities}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ugs}}`
 */
class m240915_092618_create_specialities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specialities}}', [
            'id' => $this->primaryKey(),
            'ugs_id' => $this->integer(),
            'okso' => $this->string(8),
            'name' => $this->text(),
            'is_deleted' => $this->boolean()->null()->defaultValue(false)
        ]);

        // creates index for column `ugs_id`
        $this->createIndex(
            '{{%idx-specialities-ugs_id}}',
            '{{%specialities}}',
            'ugs_id'
        );

        // add foreign key for table `{{%ugs}}`
        $this->addForeignKey(
            '{{%fk-specialities-ugs_id}}',
            '{{%specialities}}',
            'ugs_id',
            '{{%ugs}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('specialities', ['ugs_id', 'okso', 'name'], [
            [8, '08.02.01', 'Строительство и эксплуатация зданий и сооружений',],
            [8, '08.02.14', 'Эксплуатация и обслуживание многоквартирного дома',],
            [9, '09.02.03', 'Программирование в компьютерных системах',],
            [9, '09.02.07', 'Информационные системы и программирование',],
            [10, '10.02.05', 'Обеспечение информационной безопасности автоматизированных систем',],
            [25, '31.02.01', 'Лечебное дело',],
            [28, '34.02.01', 'Сестринское дело',],
            [32, '38.02.01', 'Экономика и бухгалтерский учет (по отраслям)',],
            [32, '38.02.07', 'Банковское дело',],
            [34, '40.02.02', 'Правоохранительная деятельность',],
            [34, '40.02.04', 'Юриспруденция',],
            [36, '42.02.01', 'Реклама',],
            [37, '43.02.10', 'Туризм',],
            [37, '43.02.16', 'Туризм и гостеприимство',],
            [37, '43.02.17', 'Технологии индустрии красоты',],
            [38, '44.02.02', 'Преподавание в начальных классах',],
            [48, '54.02.01', 'Дизайн (по отраслям)',],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%ugs}}`
        $this->dropForeignKey(
            '{{%fk-specialities-ugs_id}}',
            '{{%specialities}}'
        );

        // drops index for column `ugs_id`
        $this->dropIndex(
            '{{%idx-specialities-ugs_id}}',
            '{{%specialities}}'
        );

        $this->dropTable('{{%specialities}}');
    }
}
