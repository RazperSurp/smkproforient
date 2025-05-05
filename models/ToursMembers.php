<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tours_members".
 *
 * @property int $id
 * @property int|null $tours_id
 * @property int|null $users_id
 * @property bool|null $is_responsible
 * @property bool|null $is_deleted
 *
 * @property Tours $tours
 * @property Users $users
 */
class ToursMembers extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tours_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tours_id', 'users_id'], 'default', 'value' => null],
            [['tours_id', 'users_id'], 'integer'],
            [['is_responsible', 'is_deleted'], 'boolean'],
            [['tours_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tours::class, 'targetAttribute' => ['tours_id' => 'id']],
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
            'tours_id' => 'Tours ID',
            'users_id' => 'Users ID',
            'is_responsible' => 'Is Responsible',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Tours]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasOne(Tours::class, ['id' => 'tours_id']);
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
