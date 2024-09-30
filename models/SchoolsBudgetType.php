<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schools_budget_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alias
 *
 * @property Schools[] $schools
 */
class SchoolsBudgetType extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schools_budget_type';
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
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasMany(Schools::class, ['schools_budget_type' => 'id']);
    }
}
