<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks_members".
 *
 * @property int $id
 * @property int|null $tasks_id
 * @property int|null $users_id
 * @property bool|null $is_responsible
 * @property bool|null $is_deleted
 *
 * @property Tasks $tasks
 * @property Users $users
 */
class TasksMembers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tasks_id', 'users_id'], 'default', 'value' => null],
            [['tasks_id', 'users_id'], 'integer'],
            [['is_responsible', 'is_deleted'], 'boolean'],
            [['tasks_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['tasks_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tasks_id' => 'Tasks ID',
            'users_id' => 'Users ID',
            'is_responsible' => 'Is Responsible',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Tasks::class, ['id' => 'tasks_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }
}
