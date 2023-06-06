<?php
namespace frontend\class;

use Yii;
use IPLib\Factory;

class IsBot
{
    public static function isGoogle()
    {
        $ipRangesData = IsBot::loadIpRanges('data/googlebot_ips.json');
        $ipAddress = IsBot::getIpAddress();
        // $ipAddress = '192.178.5.0';
        $ipAddress = '2001:4860:4801:10::';

        return IsBot::isIpInRange($ipAddress, $ipRangesData);
    }

    protected static function getIpAddress()
    {
        return Yii::$app->request->userIP;
    }

    protected static function loadIpRanges($fileName) {
        return json_decode(file_get_contents($fileName), true);
    }

    protected static function isIpInRange($ipAddress, $rangesData)
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
    }
}