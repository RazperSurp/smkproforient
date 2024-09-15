<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks_labels".
 *
 * @property int $id
 * @property int|null $tasks_id
 * @property int|null $tasks_labels_type_id
 * @property int|null $is_deleted
 *
 * @property Tasks $tasks
 * @property TasksLabelsType $tasksLabelsType
 */
class TasksLabels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_labels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tasks_id', 'tasks_labels_type_id', 'is_deleted'], 'default', 'value' => null],
            [['tasks_id', 'tasks_labels_type_id', 'is_deleted'], 'integer'],
            [['tasks_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['tasks_id' => 'id']],
            [['tasks_labels_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TasksLabelsType::class, 'targetAttribute' => ['tasks_labels_type_id' => 'id']],
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
            'tasks_labels_type_id' => 'Tasks Labels Type ID',
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
     * Gets query for [[TasksLabelsType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksLabelsType()
    {
        return $this->hasOne(TasksLabelsType::class, ['id' => 'tasks_labels_type_id']);
    }
}
