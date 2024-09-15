<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tg_authorized".
 *
 * @property int $id
 * @property int|null $users_id
 * @property string|null $auth_code
 * @property string|null $tg_id
 * @property int|null $epoch
 *
 * @property Users $users
 */
class TgAuthorized extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tg_authorized';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'epoch'], 'default', 'value' => null],
            [['users_id', 'epoch'], 'integer'],
            [['tg_id'], 'string'],
            [['auth_code'], 'string', 'max' => 8],
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
            'auth_code' => 'Auth Code',
            'tg_id' => 'Tg ID',
            'epoch' => 'Epoch',
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
