<?php

namespace App\Http\Controllers;

use App\Helpers\C2CHelper;
use Illuminate\Http\Request;

class C2CCrawlController extends Controller
{
    function crawl(Request $request) {
        $c2cHelper = new C2CHelper;
        $curl = $c2cHelper->crawl($request->user()->c2cUser->pw, $request->phone);
        $response = json_decode($curl);
        return response()->json(['success' => ($response->code == 200 ? true : false), 'msg' => $response->msg, 'data' => $response->data]);
    }

    function parsePhones(Request $request) {
        $phones = explode("\n", $request->phones);
        return response()->json($phones);
    }
}
