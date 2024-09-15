<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proforient_questions_answers".
 *
 * @property int $id
 * @property int|null $proforient_questions_id
 * @property int|null $specialities_id
 * @property string|null $name
 * @property bool|null $is_deleted
 *
 * @property ProforientQuestions $proforientQuestions
 * @property ProforientSurvey[] $proforientSurveys
 * @property Specialities $specialities
 */
class ProforientQuestionsAnswers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proforient_questions_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proforient_questions_id', 'specialities_id'], 'default', 'value' => null],
            [['proforient_questions_id', 'specialities_id'], 'integer'],
            [['name'], 'string'],
            [['is_deleted'], 'boolean'],
            [['proforient_questions_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProforientQuestions::class, 'targetAttribute' => ['proforient_questions_id' => 'id']],
            [['specialities_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialities::class, 'targetAttribute' => ['specialities_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proforient_questions_id' => 'Proforient Questions ID',
            'specialities_id' => 'Specialities ID',
            'name' => 'Name',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[ProforientQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProforientQuestions()
    {
        return $this->hasOne(ProforientQuestions::class, ['id' => 'proforient_questions_id']);
    }

    /**
     * Gets query for [[ProforientSurveys]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProforientSurveys()
    {
        return $this->hasMany(ProforientSurvey::class, ['proforient_questions_answers_id' => 'id']);
    }

    /**
     * Gets query for [[Specialities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialities()
    {
        return $this->hasOne(Specialities::class, ['id' => 'specialities_id']);
    }
}
