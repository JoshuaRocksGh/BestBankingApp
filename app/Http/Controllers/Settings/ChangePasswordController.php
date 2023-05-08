<?php

namespace App\Http\Controllers\Settings;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class ChangePasswordController extends Controller
{
    //

    public function change_password(Request $request)
    {
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $new_password = $request->newPassword;
        $old_password = $request->oldPassword;
        $security_answer = strtoupper($request->securityAnswer);

        // $userID = session()->get('userId');

        $client_ip = request()->ip();
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = \config('otp.entry_source');
        $channel = \config('otp.channel');

        $data = [

            "authToken" => $authToken,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "newPassword" => $new_password,
            "oldPassword" => $old_password,
            "phoneNumber" => "",
            "securityAnswer" => $security_answer,
            "userName" => $userID

        ];
        // return $data;

        $response = Http::post(\config("base_urls.api_base_url")  . "/user/changePassword", $data);

        $result = new ApiBaseResponse();

        return $result->api_response($response);
    }

    public function post_chnage_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "security_question" => 'required',
            "security_answer" => 'required',
            "new_password" => 'required',
            "user_id" => 'required',

        ]);

        $base_response = new BaseResponse();

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $deviceIp = request()->ip();
        $deviceCountry = Location::get()->countryName;
        $str = $request->user_id;
        $userID = strtoupper($str);
        $deviceInfo = session()->get('deviceInfo');


        $data = [
            "authToken" => $authToken,
            "deviceBrand" => $deviceInfo['deviceBrand'],
            "deviceCountry" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $deviceIp,
            "deviceModel" => $deviceInfo['deviceManufacturer'],
            "password" => $request->new_password,
            "securityAnswer" => $request->security_answer,
            "securityQuestion" => $request->security_question,
            "userId" => $userID
        ];

        // return $data;
        // dd($data);

        try {

            $response = Http::post(env('API_BASE_URL') . "/user/initialPasswordSetup", $data);

            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);
            return $base_response->api_response('500', "Internal Server Error",  $e->getMessage()); // return API BASERESPONSE

        }
    }

    public function initial_pin_setup(Request $request)
    {
        // return $request;

        $validator = Validator::make($request->all(), [
            "pin" => 'required',
        ]);

        $base_response = new BaseResponse();

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $deviceIp = request()->ip();
        // $deviceCountry = Location::get()->countryName;
        $pin = $request->pin;
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "authToken" => $authToken,
            "deviceBrand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "deviceCountry" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $deviceIp,
            "deviceModel" => $deviceInfo['deviceModel'],
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "pinCode" => $pin,
            "userName" => $userID
        ];
        // return $data;
        // dd(env('API_BASE_URL') . "user/pinSetup");

        try {

            $response = Http::post(env('API_BASE_URL') . "user/pinSetup", $data);

            // return json_encode($response, true);
            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);
            return $base_response->api_response('500', "Internal Server Error",  $e->getMessage()); // return API BASERESPONSE

        }
    }
}