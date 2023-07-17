<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Log;
class C2CCrawlController extends Controller
{
    function crawl(Request $request) {
        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/package/findCurrPackageByIsdn1')
            ->withHeaders([
                'accept' => 'application/json, text/plain, */*',
                'access-control-allow-origin' => '*',
                'access-control-allow-headers' => '*',
                'User-Agent' => 'okhttp/3.12.12',
                'Content-Type' => 'application/json;charset=UTF-8',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => 'eyJhbGciOiJIUzUxMiJ9.eyJleHAiOjE2OTA3NzU4ODksInN1YiI6IjAzODM1MzQxNzMiLCJjcmVhdGVkIjoxNjg5MzA0NjYwOTAxfQ.K2KiSqwBHmBSmpdaPeIapWbZGYzZIFaAgjo5NdaZrCUfFuyIAdl8kgvGBXwx6cZFZYjSFDfBN8g1vkUYgu5UFw',
            ])->withData($request->phone)->post();

        $response = json_decode($curl);
        return response()->json(['success' => false, 'msg' => $response->msg, 'data' => $response->data]);
    }

    function parsePhones(Request $request) {
        $phones = explode("\n", $request->phones);
        return response()->json($phones);
    }
}
