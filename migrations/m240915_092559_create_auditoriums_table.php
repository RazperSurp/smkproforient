<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auditoriums}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%corpuses}}`
 */
class m240915_092559_create_auditoriums_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auditoriums}}', [
            'id' => $this->primaryKey(),
            'corpuses_id' => $this->integer(),
            'name' => $this->text(),
            'is_deleted' => $this->boolean()->defaultValue('false'),
        ]);

        // creates index for column `corpuses_id`
        $this->createIndex(
            '{{%idx-auditoriums-corpuses_id}}',
            '{{%auditoriums}}',
            'corpuses_id'
        );

        // add foreign key for table `{{%corpuses}}`
        $this->addForeignKey(
            '{{%fk-auditoriums-corpuses_id}}',
            '{{%auditoriums}}',
            'corpuses_id',
            '{{%corpuses}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%corpuses}}`
        $this->dropForeignKey(
            '{{%fk-auditoriums-corpuses_id}}',
            '{{%auditoriums}}'
        );

        // drops index for column `corpuses_id`
        $this->dropIndex(
            '{{%idx-auditoriums-corpuses_id}}',
            '{{%auditoriums}}'
        );

        $this->dropTable('{{%auditoriums}}');
    }
}
