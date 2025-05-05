<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "managers_contacts".
 *
 * @property int $id
 * @property int|null $contacts_type_id
 * @property int|null $managers_id
 * @property string|null $value
 * @property bool|null $is_deleted
 *
 * @property ContactsType $contactsType
 * @property Managers $managers
 */
class ManagersContacts extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'managers_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contacts_type_id', 'managers_id'], 'default', 'value' => null],
            [['contacts_type_id', 'managers_id'], 'integer'],
            [['value'], 'string'],
            [['is_deleted'], 'boolean'],
            [['contacts_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContactsType::class, 'targetAttribute' => ['contacts_type_id' => 'id']],
            [['managers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Managers::class, 'targetAttribute' => ['managers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contacts_type_id' => 'Contacts Type ID',
            'managers_id' => 'Managers ID',
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
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagers()
    {
        return $this->hasOne(Managers::class, ['id' => 'managers_id']);
    }
}
