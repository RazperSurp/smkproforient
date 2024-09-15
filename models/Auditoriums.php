<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auditoriums".
 *
 * @property int $id
 * @property int|null $corpuses_id
 * @property string|null $name
 * @property bool|null $is_deleted
 *
 * @property Corpuses $corpuses
 * @property Meetings[] $meetings
 */
class Auditoriums extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auditoriums';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['corpuses_id'], 'default', 'value' => null],
            [['corpuses_id'], 'integer'],
            [['name'], 'string'],
            [['is_deleted'], 'boolean'],
            [['corpuses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corpuses::class, 'targetAttribute' => ['corpuses_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corpuses_id' => 'Corpuses ID',
            'name' => 'Name',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Corpuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorpuses()
    {
        return $this->hasOne(Corpuses::class, ['id' => 'corpuses_id']);
    }

    /**
     * Gets query for [[Meetings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeetings()
    {
        return $this->hasMany(Meetings::class, ['auditoriums_id' => 'id']);
    }
}
