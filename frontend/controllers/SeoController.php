<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Post;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use IPLib\Factory;



class SeoController extends Controller
{

    public function actionIndex()
    {
        $host = Yii::$app->request->hostInfo;

        $ipRangesData = $this->loadIpRanges('data/googlebot_ips.json');
        $ipAddress = $this->getIpAddress();
        // $ipAddress = '192.178.5.0';
        // $ipAddress = '2001:4860:4801:10::';

        $indexing = $this->isIpInRange($ipAddress, $ipRangesData) ? 4 : 5;

        $posts = Post::find()
                ->where(['>', 'indexing', $indexing])
                ->select(['url', 'priority', 'changefreq', 'updated_at'])
                ->all();

        header("Content-type: text/xml");

        return $this->renderPartial('index', compact('posts', 'host'));
    }

    public function actionRobots()
    {
        $host = Yii::$app->request->hostInfo;

        $posts = Post::find()
                ->where(['indexing' => 1])
                ->select(['url'])
                ->all();


        header('Content-Type: text/plain');

        return $this->renderPartial('robots', compact('host', 'posts'));
    }

    protected function getIpAddress()
    {
        return Yii::$app->request->userIP;
        return $_SERVER['REMOTE_ADDR'];
    }

    protected function loadIpRanges($fileName) {
        return json_decode(file_get_contents($fileName), true);
    }

    protected function isIpInRange($ipAddress, $rangesData)
    {
        foreach ($rangesData["prefixes"] as $rangeData) {
            if (isset($rangeData['ipv4Prefix'])) {
                $range = Factory::parseRangeString($rangeData['ipv4Prefix']);
            } elseif (isset($rangeData['ipv6Prefix'])) {
                $range = Factory::parseRangeString($rangeData['ipv6Prefix']);
            } else {
                continue;
            }
            $address = Factory::parseAddressString($ipAddress);

            if ($address !== null && $range !== null && $range->contains($address)) {
                return true;
            }
        }
        return false;

        // foreach ($rangesData["prefixes"] as $rangeData) {

        //     if (isset($rangeData['ipv4Prefix'])) {
        //         list($subnet, $maskBits) = explode('/', $rangeData['ipv4Prefix']);
        //     } elseif (isset($rangeData['ipv6Prefix'])) {
        //         list($subnet, $maskBits) = explode('/', $rangeData['ipv6Prefix']);
        //     } else {
        //         continue;
        //     }

        //     $ip = @inet_pton($ipAddress);
        //     $network = @inet_pton($subnet);

        //     if ($ip === FALSE || $network === FALSE) {
        //         continue;  // Skip invalid IP addresses or subnets
        //     }
    
        //     $mask = $this->generateMask($maskBits, strlen(bin2hex($network)));

        //     $network = $network & $mask;

        //     if ($network === $ip) {
        //         return true;
        //     }
        // }
    
        // return false;
    }

    protected function generateMask($maskBits, $networkLength) {
        $mask = str_repeat("f", $maskBits / 4);
    
        if ($maskBits % 4 !== 0) {
            $mask .= str_pad(dechex((1 << (4 - $maskBits % 4)) - 1), 1, '0', STR_PAD_LEFT);
        }
    
        while (strlen($mask) < $networkLength) {
            $mask .= '0';
        }
    
        return hex2bin($mask);
    }
}