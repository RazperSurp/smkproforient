<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schools}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%colors}}`
 * - `{{%schools_budget_type}}`
 * - `{{%schools_education_type}}`
 * - `{{%settlements}}`
 */
class m240915_092527_create_schools_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%schools}}', [
            'id' => $this->primaryKey(),
            'colors_id' => $this->integer(),
            'schools_budget_type_id' => $this->integer(),
            'schools_education_type_id' => $this->integer(),
            'number' => $this->text(),
            'settlements_id' => $this->integer(),
            'street' => $this->text(),
            'address' => $this->text(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `colors_id`
        $this->createIndex(
            '{{%idx-schools-colors_id}}',
            '{{%schools}}',
            'colors_id'
        );

        // add foreign key for table `{{%colors}}`
        $this->addForeignKey(
            '{{%fk-schools-colors_id}}',
            '{{%schools}}',
            'colors_id',
            '{{%colors}}',
            'id',
            'CASCADE'
        );

        // creates index for column `schools_budget_type`
        $this->createIndex(
            '{{%idx-schools-schools_budget_type_id}}',
            '{{%schools}}',
            'schools_budget_type_id'
        );

        // add foreign key for table `{{%schools_budget_type}}`
        $this->addForeignKey(
            '{{%fk-schools-schools_budget_type_id}}',
            '{{%schools}}',
            'schools_budget_type_id',
            '{{%schools_budget_type}}',
            'id',
            'CASCADE'
        );

        // creates index for column `schools_education_type`
        $this->createIndex(
            '{{%idx-schools-schools_education_type}}',
            '{{%schools}}',
            'schools_education_type'
        );

        // add foreign key for table `{{%schools_education_type}}`
        $this->addForeignKey(
            '{{%fk-schools-schools_education_type}}',
            '{{%schools}}',
            'schools_education_type',
            '{{%schools_education_type}}',
            'id',
            'CASCADE'
        );

        // creates index for column `settlements_id`
        $this->createIndex(
            '{{%idx-schools-settlements_id}}',
            '{{%schools}}',
            'settlements_id'
        );

        // add foreign key for table `{{%settlements}}`
        $this->addForeignKey(
            '{{%fk-schools-settlements_id}}',
            '{{%schools}}',
            'settlements_id',
            '{{%settlements}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%colors}}`
        $this->dropForeignKey(
            '{{%fk-schools-colors_id}}',
            '{{%schools}}'
        );

        // drops index for column `colors_id`
        $this->dropIndex(
            '{{%idx-schools-colors_id}}',
            '{{%schools}}'
        );

        // drops foreign key for table `{{%schools_budget_type}}`
        $this->dropForeignKey(
            '{{%fk-schools-schools_budget_type}}',
            '{{%schools}}'
        );

        // drops index for column `schools_budget_type`
        $this->dropIndex(
            '{{%idx-schools-schools_budget_type}}',
            '{{%schools}}'
        );

        // drops foreign key for table `{{%schools_education_type}}`
        $this->dropForeignKey(
            '{{%fk-schools-schools_education_type}}',
            '{{%schools}}'
        );

        // drops index for column `schools_education_type`
        $this->dropIndex(
            '{{%idx-schools-schools_education_type}}',
            '{{%schools}}'
        );

        // drops foreign key for table `{{%settlements}}`
        $this->dropForeignKey(
            '{{%fk-schools-settlements_id}}',
            '{{%schools}}'
        );

        // drops index for column `settlements_id`
        $this->dropIndex(
            '{{%idx-schools-settlements_id}}',
            '{{%schools}}'
        );

        $this->dropTable('{{%schools}}');
    }
}
