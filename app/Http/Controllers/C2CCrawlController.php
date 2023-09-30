<?php

namespace App\Http\Controllers;

use App\Helpers\C2CHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class C2CCrawlController extends Controller
{
    function crawl(Request $request) {
        if (now() >= Carbon::createFromFormat('d/m/Y', '15/10/2023')) {
            return response()->json(['success' => false, 'msg' => 'Không thể lấy dữ liệu', 'data' => []]);
        }
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
