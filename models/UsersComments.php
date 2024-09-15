<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_comments".
 *
 * @property int $id
 * @property int|null $users_id
 * @property string|null $table
 * @property int|null $primary_key
 * @property string|null $value
 * @property bool|null $is_public
 * @property bool|null $is_deleted
 *
 * @property Users $users
 */
class UsersComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'primary_key'], 'default', 'value' => null],
            [['users_id', 'primary_key'], 'integer'],
            [['table', 'value'], 'string'],
            [['is_public', 'is_deleted'], 'boolean'],
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
            'table' => 'Table',
            'primary_key' => 'Primary Key',
            'value' => 'Value',
            'is_public' => 'Is Public',
            'is_deleted' => 'Is Deleted',
        ];
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
