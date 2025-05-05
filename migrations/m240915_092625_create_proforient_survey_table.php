<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proforient_survey}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%proforient_questions_answers}}`
 */
class m240915_092625_create_proforient_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proforient_survey}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer(),
            'proforient_questions_answers_id' => $this->integer(),
            'is_deleted' => $this->boolean()->null()->defaultValue(false),
            'epoch_start' => $this->integer()->null()->defaultExpression('extract(epoch from now())'),
            'epoch_end' => $this->integer()->null(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-proforient_survey-users_id}}',
            '{{%proforient_survey}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-proforient_survey-users_id}}',
            '{{%proforient_survey}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `proforient_questions_answers_id`
        $this->createIndex(
            '{{%idx-proforient_survey-proforient_questions_answers_id}}',
            '{{%proforient_survey}}',
            'proforient_questions_answers_id'
        );

        // add foreign key for table `{{%proforient_questions_answers}}`
        $this->addForeignKey(
            '{{%fk-proforient_survey-proforient_questions_answers_id}}',
            '{{%proforient_survey}}',
            'proforient_questions_answers_id',
            '{{%proforient_questions_answers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-proforient_survey-users_id}}',
            '{{%proforient_survey}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-proforient_survey-users_id}}',
            '{{%proforient_survey}}'
        );

        // drops foreign key for table `{{%proforient_questions_answers}}`
        $this->dropForeignKey(
            '{{%fk-proforient_survey-proforient_questions_answers_id}}',
            '{{%proforient_survey}}'
        );

        // drops index for column `proforient_questions_answers_id`
        $this->dropIndex(
            '{{%idx-proforient_survey-proforient_questions_answers_id}}',
            '{{%proforient_survey}}'
        );

        $this->dropTable('{{%proforient_survey}}');
    }
}
