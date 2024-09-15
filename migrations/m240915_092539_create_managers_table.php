<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%employee_posts}}`
 * - `{{%schools}}`
 */
class m240915_092539_create_managers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers}}', [
            'id' => $this->primaryKey(),
            'employee_posts_id' => $this->integer(),
            'schools_id' => $this->integer(),
            'firstname' => $this->integer(),
            'secondname' => $this->integer(),
            'thirdname' => $this->integer()->null(),
            'is_deleted' => $this->boolean(),
        ]);

        // creates index for column `employee_posts_id`
        $this->createIndex(
            '{{%idx-managers-employee_posts_id}}',
            '{{%managers}}',
            'employee_posts_id'
        );

        // add foreign key for table `{{%employee_posts}}`
        $this->addForeignKey(
            '{{%fk-managers-employee_posts_id}}',
            '{{%managers}}',
            'employee_posts_id',
            '{{%employee_posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `schools_id`
        $this->createIndex(
            '{{%idx-managers-schools_id}}',
            '{{%managers}}',
            'schools_id'
        );

        // add foreign key for table `{{%schools}}`
        $this->addForeignKey(
            '{{%fk-managers-schools_id}}',
            '{{%managers}}',
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
        // drops foreign key for table `{{%employee_posts}}`
        $this->dropForeignKey(
            '{{%fk-managers-employee_posts_id}}',
            '{{%managers}}'
        );

        // drops index for column `employee_posts_id`
        $this->dropIndex(
            '{{%idx-managers-employee_posts_id}}',
            '{{%managers}}'
        );

        // drops foreign key for table `{{%schools}}`
        $this->dropForeignKey(
            '{{%fk-managers-schools_id}}',
            '{{%managers}}'
        );

        // drops index for column `schools_id`
        $this->dropIndex(
            '{{%idx-managers-schools_id}}',
            '{{%managers}}'
        );

        $this->dropTable('{{%managers}}');
    }
}
