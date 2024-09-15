<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alias
 *
 * @property ManagersContacts[] $managersContacts
 * @property UsersContacts[] $usersContacts
 */
class ContactsType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
        ];
    }

    /**
     * Gets query for [[ManagersContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagersContacts()
    {
        return $this->hasMany(ManagersContacts::class, ['contacts_type_id' => 'id']);
    }

    /**
     * Gets query for [[UsersContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersContacts()
    {
        return $this->hasMany(UsersContacts::class, ['contacts_type_id' => 'id']);
    }
}
