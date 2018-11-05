<?php
namespace app\models;
use yii\db\ActiveRecord;
class Access extends ActiveRecord
{
    public static function tableName()
    {
        return 'material';
    }
}