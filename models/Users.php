<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int|null $colors_id
 * @property int|null $employee_posts_id
 * @property int|null $classes_id
 * @property string|null $firstname
 * @property string|null $secondname
 * @property string|null $thirdname
 * @property string|null $username
 * @property string|null $access_token
 * @property string|null $password
 * @property bool|null $is_deleted
 * @property bool|null $is_parent
 * @property string|null $referal_code
 * @property string|null $referer_code
 *
 * @property Classes $classes
 * @property Colors $colors
 * @property EmployeePosts $employeePosts
 * @property Log[] $logs
 * @property MeetingsMembers[] $meetingsMembers
 * @property ProforientSurvey[] $proforientSurveys
 * @property Users $refererCode
 * @property Tasks[] $tasks
 * @property TasksMembers[] $tasksMembers
 * @property TgAuthorized[] $tgAuthorizeds
 * @property ToursMembers[] $toursMembers
 * @property Users[] $users
 * @property UsersComments[] $usersComments
 * @property UsersContacts[] $usersContacts
 */
class Users extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['colors_id', 'employee_posts_id', 'classes_id'], 'default', 'value' => null],
            [['colors_id', 'employee_posts_id', 'classes_id'], 'integer'],
            [['firstname', 'secondname', 'thirdname', 'username', 'access_token', 'password'], 'string'],
            [['is_deleted', 'is_parent'], 'boolean'],
            [['referal_code', 'referer_code'], 'string', 'max' => 32],
            [['referal_code'], 'unique'],
            [['username'], 'unique'],
            [['classes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::class, 'targetAttribute' => ['classes_id' => 'id']],
            [['colors_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::class, 'targetAttribute' => ['colors_id' => 'id']],
            [['employee_posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeePosts::class, 'targetAttribute' => ['employee_posts_id' => 'id']],
            [['referer_code'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['referer_code' => 'referal_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'colors_id' => 'Colors ID',
            'employee_posts_id' => 'Employee Posts ID',
            'classes_id' => 'Classes ID',
            'firstname' => 'Имя',
            'secondname' => 'Фамилия',
            'thirdname' => 'Отчество',
            'username' => 'Имя пользователя',
            'access_token' => 'Access Token',
            'password' => 'Пароль',
            'is_deleted' => 'Is Deleted',
            'is_parent' => 'Is Parent',
            'referal_code' => 'Referal Code',
            'referer_code' => 'Referer Code',
        ];
    }

    /**
     * Gets query for [[Classes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasOne(Classes::class, ['id' => 'classes_id']);
    }

    /**
     * Gets query for [[Colors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColors()
    {
        return $this->hasOne(Colors::class, ['id' => 'colors_id']);
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
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[MeetingsMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeetingsMembers()
    {
        return $this->hasMany(MeetingsMembers::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[ProforientSurveys]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProforientSurveys()
    {
        return $this->hasMany(ProforientSurvey::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[RefererCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefererCode()
    {
        return $this->hasOne(Users::class, ['referal_code' => 'referer_code']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[TasksMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksMembers()
    {
        return $this->hasMany(TasksMembers::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[TgAuthorizeds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTgAuthorizeds()
    {
        return $this->hasMany(TgAuthorized::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[ToursMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToursMembers()
    {
        return $this->hasMany(ToursMembers::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['referer_code' => 'referal_code']);
    }

    /**
     * Gets query for [[UsersComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersComments()
    {
        return $this->hasMany(UsersComments::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[UsersContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersContacts()
    {
        return $this->hasMany(UsersContacts::class, ['users_id' => 'id']);
    }
}
