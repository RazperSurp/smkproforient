<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proforient_survey".
 *
 * @property int $id
 * @property int|null $users_id
 * @property int|null $proforient_questions_answers_id
 * @property bool|null $is_deleted
 * @property int|null $epoch_start
 * @property int|null $epoch_end
 *
 * @property ProforientQuestionsAnswers $proforientQuestionsAnswers
 * @property Users $users
 */
class ProforientSurvey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proforient_survey';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'proforient_questions_answers_id', 'epoch_start', 'epoch_end'], 'default', 'value' => null],
            [['users_id', 'proforient_questions_answers_id', 'epoch_start', 'epoch_end'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['proforient_questions_answers_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProforientQuestionsAnswers::class, 'targetAttribute' => ['proforient_questions_answers_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Users ID',
            'proforient_questions_answers_id' => 'Proforient Questions Answers ID',
            'is_deleted' => 'Is Deleted',
            'epoch_start' => 'Epoch Start',
            'epoch_end' => 'Epoch End',
        ];
    }

    /**
     * Gets query for [[ProforientQuestionsAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProforientQuestionsAnswers()
    {
        return $this->hasOne(ProforientQuestionsAnswers::class, ['id' => 'proforient_questions_answers_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }
}
