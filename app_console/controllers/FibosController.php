<?php
namespace console\controllers;

use common\models\fibos\ExchangeInfo;
use linslin\yii2\curl\Curl;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Fibos
 *
 * Class FibosController
 * @package console\controllers
 */
class FibosController extends \strong\controllers\ConsoleController
{
    /**
     * EOS/FO 兑换比率
     *
     * 60s 一次
     */
    public function actionGetExchangeInfo()
    {
        $url = 'https://fibos.io/1.0/app/getExchangeInfo';//网站刷新接口，20s 一次

        $curl = new Curl();
        $response = $curl->get($url);

        if ($curl->errorCode === null) {

            Console::error('EOS/FO 兑换比率:' . $response);

            $responseArr = json_decode($response, true);

            $exchangeInfo = new ExchangeInfo();
            $exchangeInfo->price = $responseArr['price'];
            $exchangeInfo->save();

        } else {
            switch ($curl->errorCode) {
                case 500:
                    break;
                default:
                    echo $curl->errorCode;
            }
        }

        return ExitCode::OK;
    }
}
