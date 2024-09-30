<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "managers".
 *
 * @property int $id
 * @property int|null $employee_posts_id
 * @property int|null $schools_id
 * @property string|null $firstname
 * @property string|null $secondname
 * @property string|null $thirdname
 * @property bool|null $is_deleted
 *
 * @property EmployeePosts $employeePosts
 * @property ManagersContacts[] $managersContacts
 * @property Schools $schools
 */
class Managers extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'managers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_posts_id', 'schools_id'], 'default', 'value' => null],
            [['employee_posts_id', 'schools_id'], 'integer'],
            [['firstname', 'secondname', 'thirdname'], 'string'],
            [['is_deleted'], 'boolean'],
            [['employee_posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeePosts::class, 'targetAttribute' => ['employee_posts_id' => 'id']],
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
            'employee_posts_id' => 'Employee Posts ID',
            'schools_id' => 'Schools ID',
            'firstname' => 'Firstname',
            'secondname' => 'Secondname',
            'thirdname' => 'Thirdname',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[EmployeePosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeePosts()
    {
        return $this->hasOne(EmployeePosts::class, ['id' => 'employee_posts_id']);
    }

    /**
     * Gets query for [[ManagersContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagersContacts()
    {
        return $this->hasMany(ManagersContacts::class, ['managers_id' => 'id']);
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
}
