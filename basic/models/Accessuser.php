<?php
namespace app\models;
use yii\db\ActiveRecord;
class Accessuser extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_access';
    }
}