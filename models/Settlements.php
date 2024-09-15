<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settlements".
 *
 * @property int $id
 * @property int|null $areas_id
 * @property string|null $name
 *
 * @property Areas $areas
 * @property Corpuses[] $corpuses
 * @property Schools[] $schools
 */
class Settlements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settlements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['areas_id'], 'default', 'value' => null],
            [['areas_id'], 'integer'],
            [['name'], 'string'],
            [['areas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::class, 'targetAttribute' => ['areas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areas_id' => 'Areas ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Areas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasOne(Areas::class, ['id' => 'areas_id']);
    }

    /**
     * Gets query for [[Corpuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorpuses()
    {
        return $this->hasMany(Corpuses::class, ['settlements_id' => 'id']);
    }

    /**
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasMany(Schools::class, ['settlements_id' => 'id']);
    }
}
