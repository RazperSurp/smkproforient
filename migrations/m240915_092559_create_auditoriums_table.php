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
            'is_deleted' => $this->boolean()->null()->defaultValue(false)
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

        

        Yii::$app->db->createCommand()->batchInsert('auditoriums', ['corpuses_id', 'name'], [
            [1,'Л102'],
            [1,'Л104'],
            [1,'Л106'],
            [1,'Л110'],
            [1,'Л203'],
            [1,'Л204'],
            [1,'Л205'],
            [1,'Л206'],
            [1,'Л208'],
            [1,'Л211'],
            [1,'Л212'],
            [1,'Л213'],
            [1,'Л219'],
            [1,'Л220'],
            [1,'Л2А'],
            [1,'Л401'],
            [1,'Л403'],
            [1,'Л404'],
            [1,'Л405'],
            [1,'Л406'],
            [1,'Л407'],
            [1,'Л408'],
            [1,'Л409'],
            [1,'Л410'],
            [1,'Л411'],
            [1,'Л417'],
            [1,'Л418'],
            [1,'Л421'],
            [1,'Л422'],
            [1,'Л4А'],
            [2,'К201'],
            [2,'К202'],
            [2,'К203'],
            [2,'К204'],
            [2,'К205'],
            [2,'К206'],
            [2,'К207'],
            [2,'К208'],
            [2,'К211'],
            [2,'К212'],
            [2,'К213'],
            [2,'К214-215'],
            [2,'К216'],
            [2,'К217'],
            [2,'К218'],
            [2,'К219'],
            [2,'К220-221'],
            [3,'Э301'],
            [3,'Э302'],
            [3,'Э304'],
            [3,'Э305'],
            [3,'Э307'],
            [3,'Э308'],
            [3,'Э309'],
            [3,'Э309-1'],
            [3,'Э311'],
            [3,'Э312'],
            [3,'Э313'],
            [3,'Э314'],
            [3,'Э315'],
            [4,'Ж1'],
            [4,'Ж10'],
            [4,'Ж11'],
            [4,'Ж12 '],
            [4,'Ж13'],
            [4,'Ж14'],
            [4,'Ж15'],
            [4,'Ж16'],
            [4,'Ж17'],
            [4,'Ж18'],
            [4,'Ж19'],
            [4,'Ж2'],
            [4,'Ж20(12)'],
            [4,'Ж21'],
            [4,'Ж3'],
            [4,'Ж4'],
            [4,'Ж5'],
            [4,'Ж6'],
            [4,'Ж8'],
            [4,'Ж9'],
        ])->execute();
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
