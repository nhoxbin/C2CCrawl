<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class C2CAuthController extends Controller
{
    function login(Request $request) {
        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/loginByMobilev2')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088'
            ])->withData([
                'account' => "0383534173",
                'appVersion' => "ios - 2.10.3",
                'deviceName' => "Model: iPhone X - DeviceId: iPhone10,6 - DeviceName: iPhone",
                'systemName' => "iOS - 16.4.1"
            ])->asJson(true)->post();
    }

    function updateToken(Request $request) {
        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/user/updateToken')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $request->token
            ])
            ->withData('fXZBa1A2TqWh2q_bS-0Iu2:APA91bHRcIT-nJCiD9S16orpmWXalm9lfFIvvRJayVazpeLKY6UrZe-crOvcorO9AYn71lqeSIuwt6MhVfm8uXGgQtkRY0jtSDu4IwtewBME6eB5Wrh4QxZoA0LiM5au20gNXYnycI-2')->asJson(true)->post();
    }
}
