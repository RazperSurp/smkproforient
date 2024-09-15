<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tours".
 *
 * @property int $id
 * @property int|null $schools_id
 * @property int|null $events_id
 * @property bool|null $is_deleted
 *
 * @property Events $events
 * @property Schools $schools
 * @property ToursMembers[] $toursMembers
 */
class Tours extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tours';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schools_id', 'events_id'], 'default', 'value' => null],
            [['schools_id', 'events_id'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['events_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::class, 'targetAttribute' => ['events_id' => 'id']],
            [['schools_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schools::class, 'targetAttribute' => ['schools_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schools_id' => 'Schools ID',
            'events_id' => 'Events ID',
            'is_deleted' => 'Is Deleted',
        ];
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
     * Gets query for [[ToursMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToursMembers()
    {
        return $this->hasMany(ToursMembers::class, ['tours_id' => 'id']);
    }
}
