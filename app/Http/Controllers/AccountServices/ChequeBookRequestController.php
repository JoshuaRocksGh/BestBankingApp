<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\classes\WEB\UserAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ChequeBookRequestController extends Controller
{
    //function or method to hit the cheque book request api
    public function cheque_book_request(Request $request)
    {


        $authToken = session()->get('userToken');
        $deviceIP = $request->ip();
        $userID = session()->get('userId');


        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');


        $data = [

            // "accountNumber" => $request->accountNumber,
            // "branch" => $request->branchCode,
            // "deviceIP" => $deviceIP,
            // "Channel" => "NET",
            // "numberOfLeaves" => $request->leaflets,
            // "pinCode" => $request->pinCode,
            // "tokenID" => $authToken,

            "accountNumber" => $request->accountNumber,
            "authToken" => $authToken,
            "branch" => $request->branchCode,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "numberOfLeaves" => $request->leaflets,
            "phoneNumber" => "",
            "pinCode" => $request->pinCode,
            "tokenID" => $authToken,
            "userName" => $userID



        ];
        // return ($data);
        $response = Http::post(env('API_BASE_URL') . "request/chequeBook", $data);
        // return $response;
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function cheque_book_block(Request $request)
    {
        // return $request;

        $authToken = session()->get('userToken');
        $deviceIP = $request->ip();


        $data = [

            "accountNumber" => $request->accountNumber,
            // "branch" => $request->branchCode,
            "deviceIP" => $deviceIP,
            "Channel" => "NET",
            // "numberOfLeaves" => $request->leaflets,
            "pinCode" => $request->pinCode,
            "token" => $authToken,

            // "accountNumber" => "string",
            "beneficiaryName" => $request->beneficiaryName,
            // "channel" => "string",
            "chequeAmount" => $request->chequeAmount,
            // "deviceIP" => "string",
            "endCheque" => $request->endCheque,
            "issueDate" => $request->issueDate,
            // "pinCode" => "string",
            "startCheque" => $request->startCheque,
            // "token" => "string"

        ];

        // return ($data);

        $response = Http::post(env('API_BASE_URL') . "request/stopCheque", $data);
        // return $response;
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function corporate_cheque_book_request(Request $request)
    {
        // return $request;

        $validator = Validator::make($request->all(), [
            'accountNumber' => 'required',
            'branchCode' => 'required',
            'leaflets' => 'required',
            // 'account_mandate' => 'required'
        ]);


        $base_response = new BaseResponse();

        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;


        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerNumber = session()->get('customerNumber');
        $userMandate = $request->accountMandate;
        $userAlias = session()->get('userAlias');
        $accountNumber = $request->accountNumber;
        $branchCode = $request->branchCode;
        $numberOfLeaves = $request->leaflets;
        $deviceIP = $request->ip();
        $postBy = session()->get('userAlias');
        $transBy = session()->get('userAlias');
        $branchName = $request->branchName;

        //         'customer_no' => 'required',
        // 'account_mandate' => 'required',
        // 'user_id' => 'required',
        // 'user_alias' => 'required',
        // 'accountNumber' => 'required',
        // 'branch' => 'required',
        // 'deviceIP' => 'required',
        // 'entrySource' => 'required',
        // 'numberOfLeaves' => 'required',


        $data = [

            "user_id" => $userID,
            "user_name" => $userAlias,
            "customer_no" => $customerNumber,
            "account_mandate" => $userMandate,
            "branch_name" => $branchName,
            "account_no" => $accountNumber,
            "branch_code" => $branchCode,
            // "deviceIP" => $deviceIP,
            "leaflet" => $numberOfLeaves,
            'postedBy' => $postBy,
            'transBy' => $transBy

        ];

        // return $data;


        try {

            // dd((env('CIB_API_BASE_URL') . "chequebook-request"));

            $response = Http::post(env('CIB_API_BASE_URL') . "chequebook-request", $data);
            // return $response;

            $result = new ApiBaseResponse();
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

    public function corporate_cheque_book_block(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'required',
            'beneficiaryName' => 'required',
            'chequeAmount' => 'required',
            'endCheque' => 'required',
            'issueDate' => 'required',
            'startCheque' => 'required',
        ]);

        $base_response = new BaseResponse();

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;

        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerNumber = session()->get('customerNumber');
        $deviceIP = $request->ip();
        $accountDetails = $request->accountDetails;
        $getAccountDetails = explode("~", $accountDetails);
        // return $getAccountDetails;
        $accountName = $getAccountDetails[1];
        $accountCurrency = $getAccountDetails[3];
        $accountCurrencyIsoCode = $getAccountDetails[5];
        $accountMandate = $request->accountMandate;
        $accountNumber = $request->accountNumber;
        $beneficiaryName = $request->beneficiaryName;
        $chequeAmount = $request->chequeAmount;
        $endChequeNumber = $request->endCheque;
        $startChequeNumber = $request->startCheque;
        $chequeIssueDate = $request->issueDate;


        $data = [
            "user_id" => $userID,
            "user_name" => $userAlias,
            "customer_no" => $customerNumber,
            "account_name" => $accountName,
            "account_mandate" => $accountMandate,
            "account_no" => $accountNumber,
            "account_currency" => $accountCurrency,
            "currency_isoCode" => $accountCurrencyIsoCode,
            "cheque_beneficiary" => $beneficiaryName,
            "cheque_amount" => $chequeAmount,
            "cheque_end_number" => $endChequeNumber,
            "cheque_start_number" => $startChequeNumber,
            "cheque_issue_date" => $chequeIssueDate,
            "postedBy" => $userID,
            "tranBy" => $userAlias,
        ];

        // return $data;

        try {

            // dd((env('CIB_API_BASE_URL') . "chequebook-request"));

            $response = Http::post(env('CIB_API_BASE_URL') . "stop-chequebook", $data);
            // return $response;

            $result = new ApiBaseResponse();
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
}
