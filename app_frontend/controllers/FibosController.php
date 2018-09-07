<?php
namespace frontend\controllers;

use common\models\fibos\ExchangeInfo;

/**
 * Fibos
 *
 * Class FibosController
 * @package console\controllers
 */
class FibosController extends \strong\controllers\WebController
{
    /**
     * EOS/FO 兑换比率
     *
     * 60s 一次
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'default_start' => date('Y-m-d 00:00', time()),
            'default_end' => date('Y-m-d H:i', time()),
        ]);
    }

    /**
     * EOS/FO 兑换比率 数据
     *
     * @return \yii\web\Response
     */
    public function actionGetExchangeInfo()
    {
        $begin = \Yii::$app->request->get('begin','');
        $end = \Yii::$app->request->get('end','');

        $condition = [];
        if($begin != ''){
            $condition = ['and', ['>=', 'created_at', strtotime($begin)], $condition];
        }
        if($end != ''){
            $condition = ['and', ['<=', 'created_at', strtotime($end)], $condition];
        }

        $data_db = ExchangeInfo::find()->where($condition)->select(['price', 'created_at'])->asArray()->all();
        $echarts_option = [
            'title' => [
                'text'=> 'EOS/FO 兑换比率'
            ],
            'grid' => [
//                'left' => '3%',
//                'right' => '6%',
//                'bottom' => '3%',
                'containLabel' => true,
            ],
            'tooltip' =>[
                'trigger' =>  'axis',
                'feature' => [
                    'saveAsImage' => []
                ]
            ],
            'xAxis' => [
//                'type' => 'time',
                'type' => 'category',
                'data' => [],
                'splitLine' => [
                    'show' => false
                ]
            ],
            'yAxis' => [
                'type' => 'value',
                'boundaryGap' => [0, '100%'],
                'splitLine' => [
                    'show' => false
                ],
                'min' => 0,
                'max' => 0,
            ],
            'series' => [
                [
                    'name' => 'price',
                    'data' => [],
                    'type' => 'line'
                ]
            ]
        ];
        $times = [];
        if($data_db){
            foreach ($data_db as $key=>$val){
                $echarts_option['xAxis']['data'][] = date('Y-m-d H:i', $val['created_at']);
//                $echarts_option['xAxis']['data'][] = $val['created_at'];
                $echarts_option['series'][0]['data'][] = $val['price'];

                if($echarts_option['yAxis']['min'] > 0){
                    if($val['price'] < $echarts_option['yAxis']['min']){
                        $echarts_option['yAxis']['min'] = $val['price'];
                    }
                }else{
                    $echarts_option['yAxis']['min'] = $val['price'];
                }
                if($val['price'] > $echarts_option['yAxis']['max']){
                    $echarts_option['yAxis']['max'] = $val['price'];
                }

//                $times[] = [$val['created_at'], $val['price']];
            }
//            $echarts_option['series'][0]['data'] = $times;

            $kong = round(($echarts_option['yAxis']['max'] - $echarts_option['yAxis']['min'])/10, 4);
            $echarts_option['yAxis']['max'] += $kong;
            $echarts_option['yAxis']['min'] -= $kong;
        }

        return $this->asJson([
            'code' => 0,
            'msg'  => '',
            'data' => $echarts_option,
        ]);
    }
}
