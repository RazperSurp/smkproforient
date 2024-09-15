<?php

use yii\db\Migration;

class m999999_999999_initialize_triggers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (Yii::$app->db->schema->tableNames as $table) {
            Yii::$app->db->createCommand('
                CREATE FUNCTION fn_log_insert_into_'. $table .' (_primary_key int, _data text) 
                AS $$
                DECLARE
                    _user int;
                BEGIN
                    BEGIN 
                        _user := select current_setting(\'local.userid\')
                        EXCEPTION 
                        WHEN OTHERS
                        THEN _user := 1;
                    END;

                    execute insert into log ("users_id", "log_action_type_id", "table", "primary_key", "data") 
                    values (
                        _user,
                        (case when _user = 1 then 5 else 1 end),
                        \''. $table .'\',
                        _primary_key,
                        _data
                    );
                END 
                $$ WITH ISCACHABLE')->execute();
            Yii::$app->db->createCommand('
                CREATE TRIGGER trg_log_insert_into_'. $table .'
                BEFORE INSERT
                ON '. $table .'
                FOR EACH ROW
                EXECUTE PROCEDURE fn_log_insert_into_'. $table .'
            ');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
