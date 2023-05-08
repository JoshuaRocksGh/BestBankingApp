<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\classes\WEB\ApiBaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ComplaintController extends Controller
{

    public function getServiceType()
    {
        $response = Http::get(env('API_BASE_URL') . "/utilities/getServiceTypes");
        // return $response;
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function make_complaint_api(Request $request)
    {
        // return  $request;
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "accountNumber" => $request->accountNumber,
            // "serviceType" => $request->serviceType,
            // "description" => $request->description,
            // "request_type" => 'comp',

            "authToken" =>  $authToken,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "other" => "",
            "phoneNumber" => "",
            "serviceCode" => $request->serviceType,
            // 'pinCode' => 1234
            "userName" => $userID,
            // "userTel" => "",
            "description" => $request->description,

        ];
        // return $data;

        try {

            $response = Http::post(env('API_BASE_URL') . "user/customerEnquiry", $data);
            // return $response;
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



    public function api_response($response_code = '500', $message = '', $data = NULL)
    {
        return response()->json([
            'responseCode' => $response_code,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}
