<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property int|null $events_type_id
 * @property int|null $epoch
 * @property bool|null $is_deleted
 *
 * @property EventsType $eventsType
 * @property Meetings[] $meetings
 * @property Tasks[] $tasks
 * @property Tours[] $tours
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['events_type_id', 'epoch'], 'default', 'value' => null],
            [['events_type_id', 'epoch'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['events_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventsType::class, 'targetAttribute' => ['events_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'events_type_id' => 'Events Type ID',
            'epoch' => 'Epoch',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[EventsType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventsType()
    {
        return $this->hasOne(EventsType::class, ['id' => 'events_type_id']);
    }

    /**
     * Gets query for [[Meetings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeetings()
    {
        return $this->hasMany(Meetings::class, ['events_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['events_id' => 'id']);
    }

    /**
     * Gets query for [[Tours]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tours::class, ['events_id' => 'id']);
    }
}
