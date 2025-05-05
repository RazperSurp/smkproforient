<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $hex
 *
 * @property Schools[] $schools
 * @property Tasks[] $tasks
 * @property TasksLabelsType[] $tasksLabelsTypes
 * @property TasksStatus[] $tasksStatuses
 * @property Users[] $users
 */
class Colors extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['hex'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'hex' => 'Hex',
        ];
    }

    /**
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasMany(Schools::class, ['colors_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['colors_id' => 'id']);
    }

    /**
     * Gets query for [[TasksLabelsTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksLabelsTypes()
    {
        return $this->hasMany(TasksLabelsType::class, ['colors_id' => 'id']);
    }

    /**
     * Gets query for [[TasksStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksStatuses()
    {
        return $this->hasMany(TasksStatus::class, ['colors_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['colors_id' => 'id']);
    }
}
