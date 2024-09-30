<?php

namespace app\models\core;

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
class ActiveRecordExtended extends \yii\db\ActiveRecord
{
    static function getTextField() {
        return 'name';
    }
}
