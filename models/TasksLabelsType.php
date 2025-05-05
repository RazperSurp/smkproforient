<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks_labels_type".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $colors_id
 *
 * @property Colors $colors
 * @property TasksLabels[] $tasksLabels
 */
class TasksLabelsType extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_labels_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['colors_id'], 'default', 'value' => null],
            [['colors_id'], 'integer'],
            [['colors_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::class, 'targetAttribute' => ['colors_id' => 'id']],
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
            'colors_id' => 'Colors ID',
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
     * Gets query for [[TasksLabels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksLabels()
    {
        return $this->hasMany(TasksLabels::class, ['tasks_labels_type_id' => 'id']);
    }
}
