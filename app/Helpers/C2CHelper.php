<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;

class C2CHelper
{
    public function login($phone) {
        return Curl::to('http://kpi.mobifone5.vn:8088/C2C/loginByMobilev2')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088'
            ])->withData([
                'account' => $phone,
                'appVersion' => 'ios - 2.10.3',
                'deviceName' => 'Model: iPhone X - DeviceId: iPhone10,6 - DeviceName: iPhone',
                'systemName' => 'iOS - 16.4.1',
            ])->asJson(true)->post();
    }

    public function crawl($token, $phone) {
        return Curl::to('http://kpi.mobifone5.vn:8088/C2C/package/findCurrPackageByIsdn1')
            ->withHeaders([
                'accept' => 'application/json, text/plain, */*',
                'access-control-allow-origin' => '*',
                'access-control-allow-headers' => '*',
                'User-Agent' => 'okhttp/3.12.12',
                'Content-Type' => 'application/json;charset=UTF-8',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $token,
            ])->withData($phone)->post();
    }

    public function updateToken($token) {
        return Curl::to('http://kpi.mobifone5.vn:8088/C2C/user/updateToken')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $token
            ])->withData('fXZBa1A2TqWh2q_bS-0Iu2:APA91bHRcIT-nJCiD9S16orpmWXalm9lfFIvvRJayVazpeLKY6UrZe-crOvcorO9AYn71lqeSIuwt6MhVfm8uXGgQtkRY0jtSDu4IwtewBME6eB5Wrh4QxZoA0LiM5au20gNXYnycI-2')->asJson(true)->post();
    }

    public function logout($token) {
        return Curl::to('http://kpi.mobifone5.vn:8088/C2C/log/save')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $token
            ])->withData(['operation' => 'DANG_XUAT'])->asJson(true)->post();
    }
}
