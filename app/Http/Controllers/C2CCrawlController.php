<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class C2CCrawlController extends Controller
{
    function crawl(Request $request) {
        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/package/findCurrPackageByIsdn1')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $request->token,
            ])->withData('0933744014')->asJson(true)->post();
        return null;
    }
}
