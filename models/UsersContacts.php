<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_contacts".
 *
 * @property int $id
 * @property int|null $users_id
 * @property int|null $contacts_type_id
 * @property string|null $value
 * @property bool|null $is_deleted
 *
 * @property ContactsType $contactsType
 * @property Users $users
 */
class UsersContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'contacts_type_id'], 'default', 'value' => null],
            [['users_id', 'contacts_type_id'], 'integer'],
            [['value'], 'string'],
            [['is_deleted'], 'boolean'],
            [['contacts_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContactsType::class, 'targetAttribute' => ['contacts_type_id' => 'id']],
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
            'contacts_type_id' => 'Contacts Type ID',
            'value' => 'Value',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[ContactsType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactsType()
    {
        return $this->hasOne(ContactsType::class, ['id' => 'contacts_type_id']);
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
