<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%corpuses}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%settlements}}`
 */
class m240915_092558_create_corpuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%corpuses}}', [
            'id' => $this->primaryKey(),
            'settlements_id' => $this->integer(),
            'street' => $this->text(),
            'address' => $this->text(),
            'is_deleted' => $this->boolean()->null()->defaultValue(false)
        ]);

        // creates index for column `settlements_id`
        $this->createIndex(
            '{{%idx-corpuses-settlements_id}}',
            '{{%corpuses}}',
            'settlements_id'
        );

        // add foreign key for table `{{%settlements}}`
        $this->addForeignKey(
            '{{%fk-corpuses-settlements_id}}',
            '{{%corpuses}}',
            'settlements_id',
            '{{%settlements}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('corpuses', ['settlements_id', 'street', 'address'], [
            [1, 'пр-т Кулакова', 'д. 8литА'],
            [1, 'пр-т Кулакова', 'д. 8'],
            [1, 'ул. 1-я Промышленная', 'д. 13'],
            [1, 'ул. Маршала-Жукова', 'д. 21'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%settlements}}`
        $this->dropForeignKey(
            '{{%fk-corpuses-settlements_id}}',
            '{{%corpuses}}'
        );

        // drops index for column `settlements_id`
        $this->dropIndex(
            '{{%idx-corpuses-settlements_id}}',
            '{{%corpuses}}'
        );

        $this->dropTable('{{%corpuses}}');
    }
}
