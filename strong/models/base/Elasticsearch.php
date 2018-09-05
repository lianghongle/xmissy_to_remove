<?php

namespace strong\models\base;

class Elasticsearch extends Model
{
    public static function getDb()
    {
        return \Yii::$app->elasticsearch;
    }
}