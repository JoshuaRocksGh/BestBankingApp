<?php

namespace App\Http\Controllers\Settings;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChangePinController extends Controller
{
    //controller for change pin
    public function change_pin(Request $request)
    {

        $base_response = new BaseResponse();

        // return $request;
        $authToken = session()->get('userToken');
        // $userID = session()->get('userId');
        $security_answer = strtoupper($request->sec_answer);

        $userID = session()->get('userId');

        $client_ip = request()->ip();
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = \config('otp.entry_source');
        $channel = \config('otp.channel');

        $data = [

            // "authToken" => $authToken,


            // "authToken" => "string",
            "authToken" => $authToken,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "newPin" => $request->newPin,
            "oldPin" => $request->oldPin,
            "phoneNumber" => "",
            "securityAnswer" => $security_answer,
            "userName" => $userID

        ];
        // return $data;

        try {
            // return \config("base_urls.api_base_url") . "/user/changePin";

            $response = Http::post(\config("base_urls.api_base_url") . "/user/changePin", $data);

            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }
}