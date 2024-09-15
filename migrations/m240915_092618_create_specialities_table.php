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
            'is_deleted' => $this->boolean()->defaultValue('false'),
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
