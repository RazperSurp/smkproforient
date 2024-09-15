<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specialities".
 *
 * @property int $id
 * @property int|null $ugs_id
 * @property string|null $okso
 * @property string|null $name
 * @property bool|null $is_deleted
 *
 * @property ProforientQuestionsAnswers[] $proforientQuestionsAnswers
 * @property Ugs $ugs
 */
class Specialities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ugs_id'], 'default', 'value' => null],
            [['ugs_id'], 'integer'],
            [['name'], 'string'],
            [['is_deleted'], 'boolean'],
            [['okso'], 'string', 'max' => 8],
            [['ugs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ugs::class, 'targetAttribute' => ['ugs_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ugs_id' => 'Ugs ID',
            'okso' => 'Okso',
            'name' => 'Name',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[ProforientQuestionsAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProforientQuestionsAnswers()
    {
        return $this->hasMany(ProforientQuestionsAnswers::class, ['specialities_id' => 'id']);
    }

    /**
     * Gets query for [[Ugs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUgs()
    {
        return $this->hasOne(Ugs::class, ['id' => 'ugs_id']);
    }
}
