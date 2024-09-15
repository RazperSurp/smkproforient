<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "meetings".
 *
 * @property int $id
 * @property int|null $events_id
 * @property int|null $auditoriums_id
 * @property string|null $name
 * @property int|null $epoch
 *
 * @property Auditoriums $auditoriums
 * @property Events $events
 * @property MeetingsMembers[] $meetingsMembers
 */
class Meetings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meetings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['events_id', 'auditoriums_id', 'epoch'], 'default', 'value' => null],
            [['events_id', 'auditoriums_id', 'epoch'], 'integer'],
            [['name'], 'string'],
            [['auditoriums_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auditoriums::class, 'targetAttribute' => ['auditoriums_id' => 'id']],
            [['events_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::class, 'targetAttribute' => ['events_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'events_id' => 'Events ID',
            'auditoriums_id' => 'Auditoriums ID',
            'name' => 'Name',
            'epoch' => 'Epoch',
        ];
    }

    /**
     * Gets query for [[Auditoriums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditoriums()
    {
        return $this->hasOne(Auditoriums::class, ['id' => 'auditoriums_id']);
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
     * Gets query for [[MeetingsMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeetingsMembers()
    {
        return $this->hasMany(MeetingsMembers::class, ['meetings_id' => 'id']);
    }
}
