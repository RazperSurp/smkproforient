<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proforient_questions_answers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%proforient_questions}}`
 * - `{{%specialities}}`
 */
class m240915_092622_create_proforient_questions_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proforient_questions_answers}}', [
            'id' => $this->primaryKey(),
            'proforient_questions_id' => $this->integer(),
            'specialities_id' => $this->integer(),
            'name' => $this->text(),
            'is_deleted' => $this->boolean()->defaultValue('false'),
        ]);

        // creates index for column `proforient_questions_id`
        $this->createIndex(
            '{{%idx-proforient_questions_answers-proforient_questions_id}}',
            '{{%proforient_questions_answers}}',
            'proforient_questions_id'
        );

        // add foreign key for table `{{%proforient_questions}}`
        $this->addForeignKey(
            '{{%fk-proforient_questions_answers-proforient_questions_id}}',
            '{{%proforient_questions_answers}}',
            'proforient_questions_id',
            '{{%proforient_questions}}',
            'id',
            'CASCADE'
        );

        // creates index for column `specialities_id`
        $this->createIndex(
            '{{%idx-proforient_questions_answers-specialities_id}}',
            '{{%proforient_questions_answers}}',
            'specialities_id'
        );

        // add foreign key for table `{{%specialities}}`
        $this->addForeignKey(
            '{{%fk-proforient_questions_answers-specialities_id}}',
            '{{%proforient_questions_answers}}',
            'specialities_id',
            '{{%specialities}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%proforient_questions}}`
        $this->dropForeignKey(
            '{{%fk-proforient_questions_answers-proforient_questions_id}}',
            '{{%proforient_questions_answers}}'
        );

        // drops index for column `proforient_questions_id`
        $this->dropIndex(
            '{{%idx-proforient_questions_answers-proforient_questions_id}}',
            '{{%proforient_questions_answers}}'
        );

        // drops foreign key for table `{{%specialities}}`
        $this->dropForeignKey(
            '{{%fk-proforient_questions_answers-specialities_id}}',
            '{{%proforient_questions_answers}}'
        );

        // drops index for column `specialities_id`
        $this->dropIndex(
            '{{%idx-proforient_questions_answers-specialities_id}}',
            '{{%proforient_questions_answers}}'
        );

        $this->dropTable('{{%proforient_questions_answers}}');
    }
}
