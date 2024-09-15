<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%colors}}`
 * - `{{%employee_posts}}`
 * - `{{%classes}}`
 * - `{{%referals}}`
 */
class m240915_092532_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'colors_id' => $this->integer(),
            'employee_posts_id' => $this->integer(),
            'classes_id' => $this->integer()->null(),
            'firstname' => $this->text(),
            'secondname' => $this->text(),
            'thirdname' => $this->text()->null(),
            'username' => $this->text()->unique(),
            'access_token' => $this->text()->null(),
            'password' => $this->text(),
            'is_deleted' => $this->boolean()->null()->defaultValue(false),
            'is_parent' => $this->boolean()->null()->defaultValue(false),
            'referal_code' => $this->string(32)->null()->unique()->defaultExpression('substring(md5(random()::text),1, 16)'),
            'referer_code' => $this->string(32)->null(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('users', ['colors_id', 'employee_posts_id', 'firstname', 'secondname', 'username', 'password', 'is_deleted'], [
            [6, 1, ' ', 'ПРЯМОЙ ЗАПРОС', ' ', ' ', true],
            [6, 1, ' ', 'АДМИНИСТРАТОР', ' ', ' ', true],
            [6, 1, ' ', 'НЕАВТОРИЗОВАН', ' ', ' ', true],
            [6, 1, 'Дмитрий', 'Шиянов', 'oinkzery', md5('aboba42'), false],
        ])->execute();

        // creates index for column `colors_id`
        $this->createIndex(
            '{{%idx-users-colors_id}}',
            '{{%users}}',
            'colors_id'
        );

        // add foreign key for table `{{%colors}}`
        $this->addForeignKey(
            '{{%fk-users-colors_id}}',
            '{{%users}}',
            'colors_id',
            '{{%colors}}',
            'id',
            'CASCADE'
        );

        // creates index for column `employee_posts_id`
        $this->createIndex(
            '{{%idx-users-employee_posts_id}}',
            '{{%users}}',
            'employee_posts_id'
        );

        // add foreign key for table `{{%employee_posts}}`
        $this->addForeignKey(
            '{{%fk-users-employee_posts_id}}',
            '{{%users}}',
            'employee_posts_id',
            '{{%employee_posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `classes_id`
        $this->createIndex(
            '{{%idx-users-classes_id}}',
            '{{%users}}',
            'classes_id'
        );

        // add foreign key for table `{{%classes}}`
        $this->addForeignKey(
            '{{%fk-users-classes_id}}',
            '{{%users}}',
            'classes_id',
            '{{%classes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `users`
        $this->createIndex(
            '{{%idx-users-referer_code}}',
            '{{%users}}',
            'referer_code'
        );

        // creates index for column `users`
        $this->createIndex(
            '{{%idx-users-referal_code}}',
            '{{%users}}',
            'referal_code'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users-referer_code}}',
            '{{%users}}',
            'referer_code',
            '{{%users}}',
            'referal_code',
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
            '{{%fk-users-colors_id}}',
            '{{%users}}'
        );

        // drops index for column `colors_id`
        $this->dropIndex(
            '{{%idx-users-colors_id}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%employee_posts}}`
        $this->dropForeignKey(
            '{{%fk-users-employee_posts_id}}',
            '{{%users}}'
        );

        // drops index for column `employee_posts_id`
        $this->dropIndex(
            '{{%idx-users-employee_posts_id}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%classes}}`
        $this->dropForeignKey(
            '{{%fk-users-classes_id}}',
            '{{%users}}'
        );

        // drops index for column `classes_id`
        $this->dropIndex(
            '{{%idx-users-classes_id}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%referals}}`
        $this->dropForeignKey(
            '{{%fk-users-referer_code}}',
            '{{%users}}'
        );

        // drops index for column `referer_code`
        $this->dropIndex(
            '{{%idx-users-referer_code}}',
            '{{%users}}'
        );

        $this->dropTable('{{%users}}');
    }
}
