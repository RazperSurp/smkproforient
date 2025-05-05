<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "meetings_members".
 *
 * @property int $id
 * @property int|null $meetings_id
 * @property int|null $users_id
 * @property bool|null $is_responsible
 * @property bool|null $is_employee
 * @property bool|null $is_deleted
 *
 * @property Meetings $meetings
 * @property Users $users
 */
class MeetingsMembers extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meetings_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meetings_id', 'users_id'], 'default', 'value' => null],
            [['meetings_id', 'users_id'], 'integer'],
            [['is_responsible', 'is_employee', 'is_deleted'], 'boolean'],
            [['meetings_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meetings::class, 'targetAttribute' => ['meetings_id' => 'id']],
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
            'meetings_id' => 'Meetings ID',
            'users_id' => 'Users ID',
            'is_responsible' => 'Is Responsible',
            'is_employee' => 'Is Employee',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Meetings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeetings()
    {
        return $this->hasOne(Meetings::class, ['id' => 'meetings_id']);
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
