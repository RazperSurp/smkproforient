<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ugs".
 *
 * @property int $id
 * @property string|null $okso
 * @property string|null $name
 *
 * @property Specialities[] $specialities
 */
class Ugs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ugs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['okso'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'okso' => 'Okso',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Specialities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialities()
    {
        return $this->hasMany(Specialities::class, ['ugs_id' => 'id']);
    }
}
