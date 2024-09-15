<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "corpuses".
 *
 * @property int $id
 * @property int|null $settlements_id
 * @property string|null $street
 * @property string|null $address
 * @property bool|null $is_deleted
 *
 * @property Auditoriums[] $auditoriums
 * @property Settlements $settlements
 */
class Corpuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'corpuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['settlements_id'], 'default', 'value' => null],
            [['settlements_id'], 'integer'],
            [['street', 'address'], 'string'],
            [['is_deleted'], 'boolean'],
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
            'settlements_id' => 'Settlements ID',
            'street' => 'Street',
            'address' => 'Address',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Auditoriums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditoriums()
    {
        return $this->hasMany(Auditoriums::class, ['corpuses_id' => 'id']);
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
}
