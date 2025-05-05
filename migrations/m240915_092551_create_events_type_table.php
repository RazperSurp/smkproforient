<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events_type}}`.
 */
class m240915_092551_create_events_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%events_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->unique(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('events_type', ['name'], [
            ['Фестиваль профессий СмК'],
            ['Фестиваль профессий IThub'],
            ['Фестиваль профессий мед. колледж'],
            ['Командировка СмК'],
            ['Командировка IThub'],
            ['Командировка мед. колледж'],
            ['Родительское собрание СмК'],
            ['Родительское собрание IThub'],
            ['Родительское собрание мед. колледж'],
            ['Открытый урок СмК'],
            ['Открытый урок IThub'],
            ['Открытый урок мед. колледж'],
            ['Дистанционная работа СмК'],
            ['Дистанционная работа IThub'],
            ['Дистанционная работа мед. колледж'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%events_type}}');
    }
}
