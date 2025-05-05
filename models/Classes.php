<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property int|null $schools_id
 * @property string|null $name
 * @property int|null $count
 * @property int|null $year
 * @property bool|null $is_deleted
 *
 * @property Schools $schools
 * @property Users[] $users
 */
class Classes extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classes';
    }

    public static function getTextField() {
        // return "concat(' ', classes.name)"
    }

    public static function getApiSelectJoins() {
        // return ''
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schools_id', 'count', 'year'], 'default', 'value' => null],
            [['schools_id', 'count', 'year'], 'integer'],
            [['name'], 'string'],
            [['is_deleted'], 'boolean'],
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
            'schools_id' => 'Schools ID',
            'name' => 'Name',
            'count' => 'Count',
            'year' => 'Year',
            'is_deleted' => 'Is Deleted',
        ];
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

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['classes_id' => 'id']);
    }
}
