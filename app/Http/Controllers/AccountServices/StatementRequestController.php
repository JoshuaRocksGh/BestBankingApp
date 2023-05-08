<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Validator;

class StatementRequestController extends Controller
{
    //method to check the statement request for the method
    public function statement_request(Request $request)
    {

        // return $request->accountDetails;
        // $validator = Validator::make($request->all(), [
        //     'account_no' => 'required',
        //     'type_of_statement' => 'required',
        //     // 'pick_up_branch' => 'required',
        //     'transStartDate' => 'required',
        //     'transEndDate' => 'required',
        //     'medium' => 'required',
        //     'pin' => 'required'
        // ]);
        // return $request;



        $base_response = new BaseResponse();


        $authToken = session()->get('userToken');
        $userID = session()->get('userAlias');
        $customerNumber = session()->get('customerNumber');
        $deviceBrand = session()->get('deviceInfo')['deviceBrand'];
        $deviceCountry = session()->get('deviceInfo')['deviceCountry'];
        $deviceId = session()->get('deviceInfo')['deviceId'];
        $deviceManufacturer = session()->get('deviceInfo')['deviceManufacturer'];
        $deviceOs = session()->get('deviceInfo')['deviceOs'];
        // return $authToken;

        // $base_response = new BaseResponse();
        $deviceIp = request()->ip();

        $accountNumber = $request->accountNumber;
        $branchCode = $request->branch;
        $deviceIP = $request->deviceIP;
        // $entrySource = $request->entrySource;
        $pincode = $request->pinCode;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $statementType = $request->statementType;
        $medium = $request->medium;
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [

            // "accountNumber" => $accountNumber,
            // "medium" => $medium,
            // "channel" => $channel,
            // "branch" => $branchCode,
            // "deviceIP" => $deviceIp,
            // "endDate" => $endDate,
            // "entrySource" => $entrySource,
            // "pinCode" => $pincode,
            // "startDate" => $startDate,
            // "statementType" => $statementType,
            // "tokenID" => $authToken,
            // "userID" => $userID,
            // "customer_num" => $customerNumber

            "accountNumber" => $accountNumber,
            "authToken" => $authToken,
            "branch" => $branchCode,
            "brand" => $deviceBrand,
            "channel" => $channel,
            "country" => $deviceCountry,
            "deviceIP" => $deviceIp,
            "deviceId" => $deviceId,
            "deviceIp" => $deviceIp,
            "deviceName" => $deviceOs,
            "endDate" => $endDate,
            "entrySource" => $entrySource,
            "manufacturer" => $deviceManufacturer,
            "pinCode" => $pincode,
            "startDate" => $startDate,
            "statementType" => $statementType,
            "tokenID" => $authToken,
            "userName" => $userID

        ];

        // return $data;

        // dd(env('API_BASE_URL') . "request/statment", $data);


        try {

            $response = Http::post(env('API_BASE_URL') . "request/statement", $data);

            // dd($response);
            // return $response;
            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);
            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE

        }
    }

    // corporate statement request();
    public function corporate_statement_request(Request $request)
    {

        // return $request;


        $base_response = new BaseResponse();



        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');
        $userMandate = session()->get('userMandate');

        $getAccount = $request->accountDetails;
        $allAccDetails = explode("~", $getAccount);
        // return $allAccDetails;
        $accountType = $allAccDetails[0];
        $accountName = $allAccDetails[1];
        $accountNumber = $allAccDetails[2];
        $accountCurrency = $allAccDetails[3];
        $accountCurrencyIsoCode = $allAccDetails[5];
        $accountMandate = $allAccDetails[6];

        $accountNumber = $request->accountNumber;
        $branchCode = $request->branch;
        $branchName = $request->branchName;
        $deviceIP = $request->deviceIP;
        // $entrySource = $request->entrySource;
        $pincode = $request->pinCode;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $statementType = $request->statementType;
        $medium = $request->medium;
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "accountType" => $accountType,
            "accountName" => $accountName,
            "accountNumber" => $accountNumber,
            "accountMandate" => $accountMandate,
            "accountCurrency" => $accountCurrency,
            "accountCurrencyIsoCode" => $accountCurrencyIsoCode,
            "accountCurrencyIsoCode" => $accountCurrencyIsoCode,
            "authToken" => $authToken,
            "userID" => $userID,
            "userAlias" => $userAlias,
            "customerPhone" => $customerPhone,
            "customerNumber" => $customerNumber,
            "userMandate" => $userMandate,
            "postedBy" => $userID,
            "branchCode" => $branchCode,
            "branchName" => $branchName,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "statementType" => $statementType,
        ];

        // return $data;

        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "statement-request-gone-for-pending", $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
        }
    }
}