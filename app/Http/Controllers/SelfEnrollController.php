<?php

namespace App\Http\Controllers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use hisorange\BrowserDetect\Facade as Browser;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;


class SelfEnrollController extends Controller
{

    public function validateCustomer(Request $req)
    {
        Log::info($req);

        $validator = Validator::make($req->all(), [
            'customerNumber' => 'required',
        ]);
        // return $req ;

        $base_response = new BaseResponse();


        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        $appVersion = "web";
        $deviceBrand = Browser::deviceFamily();
        $deviceCountry = Location::get()->countryName;
        $deviceId = Browser::browserName();
        $deviceIp = request()->ip();
        $deviceManufacturer = Browser::deviceFamily();
        $deviceModel = Browser::deviceModel();
        $deviceOs =  Browser::platformName();


        $data = [
            "customerNumber" => $req->customerNumber,
            "appVersion" => $appVersion,
            "deviceBrand" => $deviceBrand,
            "deviceCountry" =>  $deviceCountry,
            "deviceId" => $deviceId,
            "deviceIp" => $deviceIp,
            "deviceManufacturer" => $deviceManufacturer,
            "deviceModel" => $deviceModel,
            "deviceOs" => $deviceOs
        ];

        try {

            $response = Http::post(env('API_BASE_URL') . "/user/validateCustomer", $data);

            $result = new ApiBaseResponse();
            Log::info($response);
            return $result->api_response($response);
            // return json_decode($response->body();

        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }


    public function confirmCustomer(Request $req)
    {
        Log::info($req);
        $validator = Validator::make($req->all(), [
            'customerNumber' => 'required',
            'dateOfBirth' => 'required',
            'phoneNumber' => 'required',
            'idNumber' => 'required',
            'authToken' => 'required'
        ]);
        // return $req ;

        $base_response = new BaseResponse();


        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };


        $data = [
            "authToken" => $req->authToken,
            "customerNumber" => $req->customerNumber,
            "dateOfBirth" => $req->dateOfBirth,
            "idNumber" => $req->idNumber,
            "telephone" => $req->phoneNumber
        ];
        Log::info("a");
        Log::info($data);
        try {

            $response = Http::post(env('API_BASE_URL') . "/user/confirmCustomer", $data);

            $result = new ApiBaseResponse();
            Log::info($response);
            return $result->api_response($response);
            // return json_decode($response->body();

        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }

    public function registerCustomer(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'customerNumber' => 'required',
            'authToken' => 'required',
            'oneTimePin' => 'required'
        ]);
        // return $req;

        $base_response = new BaseResponse();


        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };


        $data = [
            'customerNumber' => $req->customerNumber,
            'authToken' => $req->authToken,
            'oneTimePin' => $req->oneTimePin
        ];
        // return $data;

        try {

            $response = Http::post(env('API_BASE_URL') . "/user/registerCustomer", $data);

            $result = new ApiBaseResponse();
            Log::info($response);
            return $result->api_response($response);
            // return json_decode($response->body();

        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}