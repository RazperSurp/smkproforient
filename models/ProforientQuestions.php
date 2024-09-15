<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proforient_questions".
 *
 * @property int $id
 * @property string|null $name
 * @property bool|null $is_deleted
 *
 * @property ProforientQuestionsAnswers[] $proforientQuestionsAnswers
 */
class ProforientQuestions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proforient_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['is_deleted'], 'boolean'],
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
        return $this->hasMany(ProforientQuestionsAnswers::class, ['proforient_questions_id' => 'id']);
    }
}
