<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $users_id
 * @property int|null $log_action_type_id
 * @property string|null $table
 * @property int|null $primary_key
 * @property string|null $data
 * @property int|null $epoch
 *
 * @property LogActionType $logActionType
 * @property Users $users
 */
class Log extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'log_action_type_id', 'primary_key', 'epoch'], 'default', 'value' => null],
            [['users_id', 'log_action_type_id', 'primary_key', 'epoch'], 'integer'],
            [['table', 'data'], 'string'],
            [['log_action_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LogActionType::class, 'targetAttribute' => ['log_action_type_id' => 'id']],
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
            'log_action_type_id' => 'Log Action Type ID',
            'table' => 'Table',
            'primary_key' => 'Primary Key',
            'data' => 'Data',
            'epoch' => 'Epoch',
        ];
    }

    /**
     * Gets query for [[LogActionType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogActionType()
    {
        return $this->hasOne(LogActionType::class, ['id' => 'log_action_type_id']);
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
