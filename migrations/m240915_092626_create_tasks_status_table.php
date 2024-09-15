<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_status}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tasks}}`
 * - `{{%tasks_labels_type}}`
 */
class m240915_092626_create_tasks_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'colors_id' => $this->integer()
        ]);

        // creates index for column `colors_id`
        $this->createIndex(
            '{{%idx-tasks_status-colors_id}}',
            '{{%tasks_status}}',
            'colors_id'
        );

        // add foreign key for table `{{%tasks}}`
        $this->addForeignKey(
            '{{%fk-tasks_status-colors_id}}',
            '{{%tasks_status}}',
            'colors_id',
            '{{%colors}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('tasks_status', ['name', 'colors_id'], [
            ['Новые задачи', '26'],
            ['В работе', '73'],
            ['Назначены командировки', '40'],
            ['Завершённые', '71'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tasks}}`
        $this->dropForeignKey(
            '{{%fk-tasks_status-colors_id}}',
            '{{%tasks_status}}'
        );

        // drops index for column `colors_id`
        $this->dropIndex(
            '{{%idx-tasks_status-colors_id}}',
            '{{%tasks_status}}'
        );

        $this->dropTable('{{%tasks_status}}');
    }
}
