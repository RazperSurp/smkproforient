<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%classes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%schools}}`
 */
class m240915_092530_create_classes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%classes}}', [
            'id' => $this->primaryKey(),
            'schools_id' => $this->integer(),
            'name' => $this->text(),
            'count' => $this->integer(),
            'year' => $this->integer(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `schools_id`
        $this->createIndex(
            '{{%idx-classes-schools_id}}',
            '{{%classes}}',
            'schools_id'
        );

        // add foreign key for table `{{%schools}}`
        $this->addForeignKey(
            '{{%fk-classes-schools_id}}',
            '{{%classes}}',
            'schools_id',
            '{{%schools}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%schools}}`
        $this->dropForeignKey(
            '{{%fk-classes-schools_id}}',
            '{{%classes}}'
        );

        // drops index for column `schools_id`
        $this->dropIndex(
            '{{%idx-classes-schools_id}}',
            '{{%classes}}'
        );

        $this->dropTable('{{%classes}}');
    }
}
