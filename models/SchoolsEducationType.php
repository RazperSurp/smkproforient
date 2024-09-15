<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schools_education_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alias
 *
 * @property Schools[] $schools
 */
class SchoolsEducationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schools_education_type';
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
        return $this->hasMany(Schools::class, ['schools_education_type' => 'id']);
    }
}
