<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schools".
 *
 * @property int $id
 * @property int|null $colors_id
 * @property int|null $schools_budget_type
 * @property int|null $schools_education_type
 * @property string|null $number
 * @property int|null $settlements_id
 * @property string|null $street
 * @property string|null $address
 * @property bool|null $is_deleted
 *
 * @property Classes[] $classes
 * @property Colors $colors
 * @property Managers[] $managers
 * @property SchoolsBudgetType $schoolsBudgetType
 * @property SchoolsEducationType $schoolsEducationType
 * @property Settlements $settlements
 * @property Tasks[] $tasks
 * @property Tours[] $tours
 */
class Schools extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['colors_id', 'schools_budget_type', 'schools_education_type', 'settlements_id'], 'default', 'value' => null],
            [['colors_id', 'schools_budget_type', 'schools_education_type', 'settlements_id'], 'integer'],
            [['number', 'street', 'address'], 'string'],
            [['is_deleted'], 'boolean'],
            [['colors_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::class, 'targetAttribute' => ['colors_id' => 'id']],
            [['schools_budget_type'], 'exist', 'skipOnError' => true, 'targetClass' => SchoolsBudgetType::class, 'targetAttribute' => ['schools_budget_type' => 'id']],
            [['schools_education_type'], 'exist', 'skipOnError' => true, 'targetClass' => SchoolsEducationType::class, 'targetAttribute' => ['schools_education_type' => 'id']],
            [['settlements_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settlements::class, 'targetAttribute' => ['settlements_id' => 'id']],
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
            'schools_budget_type' => 'Schools Budget Type',
            'schools_education_type' => 'Schools Education Type',
            'number' => 'Number',
            'settlements_id' => 'Settlements ID',
            'street' => 'Street',
            'address' => 'Address',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Classes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(Classes::class, ['schools_id' => 'id']);
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
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagers()
    {
        return $this->hasMany(Managers::class, ['schools_id' => 'id']);
    }

    /**
     * Gets query for [[SchoolsBudgetType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolsBudgetType()
    {
        return $this->hasOne(SchoolsBudgetType::class, ['id' => 'schools_budget_type']);
    }

    /**
     * Gets query for [[SchoolsEducationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolsEducationType()
    {
        return $this->hasOne(SchoolsEducationType::class, ['id' => 'schools_education_type']);
    }

    /**
     * Gets query for [[Settlements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettlements()
    {
        return $this->hasOne(Settlements::class, ['id' => 'settlements_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['schools_id' => 'id']);
    }

    /**
     * Gets query for [[Tours]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tours::class, ['schools_id' => 'id']);
    }
}
