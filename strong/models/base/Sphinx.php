<?php

namespace strong\models\base;

class Sphinx extends Model
{
    public static function getDb()
    {
        return \Yii::$app->sphinx;
    }
}