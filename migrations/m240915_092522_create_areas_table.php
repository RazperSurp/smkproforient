<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%areas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%regions}}`
 */
class m240915_092522_create_areas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%areas}}', [
            'id' => $this->primaryKey(),
            'regions_id' => $this->integer(),
            'name' => $this->integer(),
        ]);

        // creates index for column `regions_id`
        $this->createIndex(
            '{{%idx-areas-regions_id}}',
            '{{%areas}}',
            'regions_id'
        );

        // add foreign key for table `{{%regions}}`
        $this->addForeignKey(
            '{{%fk-areas-regions_id}}',
            '{{%areas}}',
            'regions_id',
            '{{%regions}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%regions}}`
        $this->dropForeignKey(
            '{{%fk-areas-regions_id}}',
            '{{%areas}}'
        );

        // drops index for column `regions_id`
        $this->dropIndex(
            '{{%idx-areas-regions_id}}',
            '{{%areas}}'
        );

        $this->dropTable('{{%areas}}');
    }
}
