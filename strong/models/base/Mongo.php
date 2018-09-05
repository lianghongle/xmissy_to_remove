<?php

namespace strong\models\base;

class Mongo extends Model
{
    public static function getDb()
    {
        return \Yii::$app->mongodb;
    }

    /**
     * mongo 感觉有必要，防止无用字段写入
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}