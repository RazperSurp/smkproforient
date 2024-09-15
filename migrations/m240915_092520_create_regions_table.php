<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regions}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%countries}}`
 */
class m240915_092520_create_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'countries_id' => $this->integer(),
            'name' => $this->text(),
        ]);

        // creates index for column `countries_id`
        $this->createIndex(
            '{{%idx-regions-countries_id}}',
            '{{%regions}}',
            'countries_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            '{{%fk-regions-countries_id}}',
            '{{%regions}}',
            'countries_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%countries}}`
        $this->dropForeignKey(
            '{{%fk-regions-countries_id}}',
            '{{%regions}}'
        );

        // drops index for column `countries_id`
        $this->dropIndex(
            '{{%idx-regions-countries_id}}',
            '{{%regions}}'
        );

        $this->dropTable('{{%regions}}');
    }
}
