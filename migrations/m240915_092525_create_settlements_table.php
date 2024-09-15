<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settlements}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%areas}}`
 */
class m240915_092525_create_settlements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settlements}}', [
            'id' => $this->primaryKey(),
            'areas_id' => $this->integer(),
            'name' => $this->text(),
        ]);

        // creates index for column `areas_id`
        $this->createIndex(
            '{{%idx-settlements-areas_id}}',
            '{{%settlements}}',
            'areas_id'
        );

        // add foreign key for table `{{%areas}}`
        $this->addForeignKey(
            '{{%fk-settlements-areas_id}}',
            '{{%settlements}}',
            'areas_id',
            '{{%areas}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%areas}}`
        $this->dropForeignKey(
            '{{%fk-settlements-areas_id}}',
            '{{%settlements}}'
        );

        // drops index for column `areas_id`
        $this->dropIndex(
            '{{%idx-settlements-areas_id}}',
            '{{%settlements}}'
        );

        $this->dropTable('{{%settlements}}');
    }
}
