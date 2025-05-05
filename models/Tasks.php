<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int|null $users_id
 * @property int|null $tasks_status_id
 * @property int|null $colors_id
 * @property int|null $schools_id
 * @property int|null $events_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $epoch_start
 * @property int|null $epoch_end
 * @property bool|null $is_deleted
 *
 * @property Colors $colors
 * @property Events $events
 * @property Schools $schools
 * @property TasksLabels[] $tasksLabels
 * @property TasksMembers[] $tasksMembers
 * @property TasksStatus $tasksStatus
 * @property Users $users
 */
class Tasks extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'tasks_status_id', 'colors_id', 'schools_id', 'events_id', 'epoch_start', 'epoch_end'], 'default', 'value' => null],
            [['users_id', 'tasks_status_id', 'colors_id', 'schools_id', 'events_id', 'epoch_start', 'epoch_end'], 'integer'],
            [['name', 'description'], 'string'],
            [['is_deleted'], 'boolean'],
            [['colors_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::class, 'targetAttribute' => ['colors_id' => 'id']],
            [['events_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::class, 'targetAttribute' => ['events_id' => 'id']],
            [['schools_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schools::class, 'targetAttribute' => ['schools_id' => 'id']],
            [['tasks_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TasksStatus::class, 'targetAttribute' => ['tasks_status_id' => 'id']],
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
            'users_id' => 'Users ID',
            'tasks_status_id' => 'Tasks Status ID',
            'colors_id' => 'Colors ID',
            'schools_id' => 'Schools ID',
            'events_id' => 'Events ID',
            'name' => 'Name',
            'description' => 'Description',
            'epoch_start' => 'Epoch Start',
            'epoch_end' => 'Epoch End',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Colors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColors()
    {
        return $this->hasOne(Colors::class, ['id' => 'colors_id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasOne(Events::class, ['id' => 'events_id']);
    }

    /**
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasOne(Schools::class, ['id' => 'schools_id']);
    }

    /**
     * Gets query for [[TasksLabels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksLabels()
    {
        return $this->hasMany(TasksLabels::class, ['tasks_id' => 'id']);
    }

    /**
     * Gets query for [[TasksMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksMembers()
    {
        return $this->hasMany(TasksMembers::class, ['tasks_id' => 'id']);
    }

    /**
     * Gets query for [[TasksStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksStatus()
    {
        return $this->hasOne(TasksStatus::class, ['id' => 'tasks_status_id']);
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
