<?php
/**
 * Created by PhpStorm.
 * User: lianghongle
 * Date: 2018/6/5
 * Time: 上午9:28
 */

namespace strong\debug;

use Yii;

/**
 * 分页
 *
 * Class Page
 * @package strong
 */
class DebugHelper
{
    /**
     * @param $config
     *
     * @return mixed
     */
    public static function config($config, $allowedIPs = [])
    {
        $allowedIPs = empty($allowedIPs) ? ['*'] : $allowedIPs;

        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class'               => 'yii\debug\Module',
            'controllerNamespace' => 'strong\debug\controllers',
            'enableDebugLogs'     => true,
            //如果是访问虚拟机，要用和虚拟机一个网段的那个ip
            'allowedIPs' => $allowedIPs,
        ];

        if(class_exists('yii\\elasticsearch\\DebugPanel')){
            $config['modules']['debug']['panels']['elasticsearch'] = [
                'class' => \yii\elasticsearch\DebugPanel::class,
            ];
        }

        if(class_exists('yii\\mongodb\\debug\\MongoDbPanel')){
            $config['modules']['debug']['panels']['mongodb'] = [
                'class' => \yii\mongodb\debug\MongoDbPanel::class,
            ];
        }

        if(class_exists('strong\debug\panels\OtherPanel')){
            $config['modules']['debug']['panels']['other'] = [
                'class' => \strong\debug\panels\OtherPanel::class,
            ];
        }

        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = [
            'class'      => 'yii\gii\Module',
            'allowedIPs' => $allowedIPs, // adjust this to your needs
        ];

        if(class_exists('yii\mongodb\gii\model\Generator')){
            $config['modules']['debug']['panels']['elasticsearch'] = [
                'class' => \yii\elasticsearch\DebugPanel::class,
            ];
            $config['modules']['gii']['generators']['mongoDbModel']['class'] = \yii\mongodb\gii\model\Generator::class;
        }

        return $config;
    }
}