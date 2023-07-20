<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Ixudra\Curl\Facades\Curl;

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
                'token' => $request->user()->c2cUser->pw,
            ])->withData($request->phone)->post();

        $response = json_decode($curl);
        return response()->json(['success' => ($response->code == 200 ? true : false), 'msg' => $response->msg, 'data' => $response->data]);
    }

    function parsePhones(Request $request) {
        $phones = explode("\n", $request->phones);
        return response()->json($phones);
    }
}
