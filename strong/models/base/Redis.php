<?php

namespace strong\models\base;

class Redis extends Model
{
    public static function getDb()
    {
        return \Yii::$app->redis;
    }
}