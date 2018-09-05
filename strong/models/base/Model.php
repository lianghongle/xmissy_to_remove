<?php

namespace strong\models\base;

use yii\behaviors\TimestampBehavior;

/**
 * ActiveRecord 模型基类
 *
 * Class Model
 *
 * ActiveRecord 生命周期
 * --------------------
 * new:
 * __construct()
 * init()
 *
 * find:
 * __construct()
 * init()
 * afterFind()
 *
 * save:
 * beforeValidate()
 * validate
 * afterValidate()
 * beforeSave()
 * save/update
 * afterSave()
 *
 * delete:
 * beforeDelete()
 * afterDelete()
 *
 * refresh:
 * afterRefresh()
 * --------------------
 *
 * @package strong\models\base
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * 修改连接
     *
     * @return mixed
     */
    public static function getDb()
    {
        return parent::getDb();
//        return \Yii::$app->db2;  // 修改使用名为 "db2" 的应用组件
    }

    /**
     * 模型对应存储名称
     *
     * @return string
     */
    public static function tableName()
    {
        return parent::tableName();
//        return '{{%post}}';
    }

    /**
     * 模型验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * attribute labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            //自动处理创建/修改时间
            [
                'class' => TimestampBehavior::class,
                //                'createdAtAttribute' => 'created_at',
                //                'updatedAtAttribute' => 'update_at',
                //'value' => new Expression('NOW()'),
                //'value'=>$this->timeTemp(),
            ],

        ];
    }

    public function attributes()
    {
        return parent::attributes();
//        return array_merge(parent::attributes(), ['other']);// 添加额外属性
    }
}