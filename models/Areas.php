<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property int $id
 * @property int|null $regions_id
 * @property string|null $name
 *
 * @property Regions $regions
 * @property Settlements[] $settlements
 */
class Areas extends \app\models\core\ActiveRecordExtended
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regions_id'], 'default', 'value' => null],
            [['regions_id'], 'integer'],
            [['name'], 'string'],
            [['regions_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['regions_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regions_id' => 'Regions ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasOne(Regions::class, ['id' => 'regions_id']);
    }

    /**
     * Gets query for [[Settlements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettlements()
    {
        return $this->hasMany(Settlements::class, ['areas_id' => 'id']);
    }
}
