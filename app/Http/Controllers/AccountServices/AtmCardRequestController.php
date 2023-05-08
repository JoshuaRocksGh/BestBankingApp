<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AtmCardRequestController extends Controller
{
    //
    public function atm_card_request(Request $request)
    {
        // return $request;
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $client_ip = request()->ip();

        $deviceInfo = session()->get('deviceInfo');
        $authToken = session()->get('userToken');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');


        $data = [
            // "accountNumber" => $request->accountNumber,
            // "branch" => $request->pickUpBranch,
            // "cardNumber" => null,
            // "channel" => $channel,
            // "entrySource" => $entrySource,
            // "pinCode" => $request->pinCode,
            // "tokenID" => $authToken,
            // "secondaryAccounts" => [""],

            "accountNumber" => $request->accountNumber,
            "authToken" => $authToken,
            "branch" => $request->pickUpBranch,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "pinCode" => $request->pinCode,
            "cardNumber" => "",
            "cardType" => $request->cardType,
            "secondaryAccounts" => [
                ""
            ],
            "tokenID" => $authToken,
            "userName" => $userID
        ];
        // return $data;


        try {
            $response = Http::post(env('API_BASE_URL') . "/request/atmCard", $data);
            $result = new ApiBaseResponse();
            return  $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }

    // PIB card Block
    public function atm_card_block(Request $request)
    {
        // return $request;

        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $client_ip = request()->ip();
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');


        $data = [
            // "accountNumber" => $request->accountNumber,
            // "branch" => $request->cardBranch,
            // "cardNumber" => $request->cardNumber,
            // "channel" => $channel,
            // "entrySource" => $entrySource,
            // "pinCode" => $request->pinCode,
            // "tokenID" => $authToken,
            // "secondaryAccounts" => [""]

            "accountNumber" => $request->accountNumber,
            "authToken" => $authToken,
            "branch" => $request->cardBranch,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "cardNumber" => $request->cardNumber,
            "cardType" => $request->cardType,
            "pinCode" => $request->pinCode,
            "secondaryAccounts" => [
                ""
            ],
            "tokenID" => $authToken,
            "userName" => $userID
        ];

        // return $data;

        try {
            $response = Http::post(env('API_BASE_URL') . "request/blockCard", $data);
            $result = new ApiBaseResponse();
            return  $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }



    public function activate_card_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_no' => 'required',
            'type_of_card' => 'required',
            'card_number' => 'required',
            'pin' => 'required'
        ]);

        $base_response = new BaseResponse();

        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $cardType = $request->type_of_card;
        $accountNumber = $request->account_no;
        $pin_code = $request->pin;
        $card_number = $request->card_number;
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');


        $data = [
            "accountNumber" => $accountNumber,
            "branch" => null,
            "cardNumber" => $card_number,
            "channel" => $channel,
            "entrySource" => $entrySource,
            "pinCode" => $pin_code,
            "tokenID" => $authToken
        ];

        // return $data;

        try {
            $response = Http::post(env('API_BASE_URL') . "/request/activateCard", $data);

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

    public function block_card_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_no' => 'required',
            'type_of_card' => 'required',
            'card_number' => 'required',
            'pin' => 'required'
        ]);

        $base_response = new BaseResponse();

        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $cardType = $request->type_of_card;
        $accountNumber = $request->account_no;
        $pin_code = $request->pin;
        $card_number = $request->card_number;

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "accountNumber" => $accountNumber,
            "branch" => null,
            "cardNumber" => $card_number,
            "channel" => $channel,
            "entrySource" => $entrySource,
            "pinCode" => $pin_code,
            "tokenID" => $authToken
        ];

        // return $data;

        try {
            $response = Http::post(env('API_BASE_URL') . "/request/blockCard", $data);

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

    public function atm_card_activate(Request $request)
    {
        // return $request;

        $base_response = new BaseResponse();


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $client_ip = request()->ip();
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            // "accountNumber" => $request->accountNumber,
            // "branch" => $request->cardBranch,
            // "cardNumber" => $request->cardNumber,
            // "channel" => $channel,
            // "entrySource" => $entrySource,
            // "pinCode" => $request->pinCode,
            // "tokenID" => $authToken,
            // "secondaryAccounts" => [""]

            "accountNumber" => $request->accountNumber,
            "authToken" => $authToken,
            "branch" => $request->cardBranch,
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "cardNumber" => $request->cardNumber,
            "cardType" => $request->cardType,
            "pinCode" => $request->pinCode,
            "secondaryAccounts" => [
                ""
            ],
            "tokenID" => $authToken,
            "userName" => $userID
        ];

        // return $data;

        try {
            $response = Http::post(env('API_BASE_URL') . "request/activateCard", $data);
            $result = new ApiBaseResponse();
            return  $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }

    // CORPORATE CARD REQEST
    public function corporate_atm_card_request(Request $request)
    {
        $base_response = new BaseResponse();
        // return $request;
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
        $cardType = $request->cardType;
        $cardTypeName = $request->cardTypeName;
        $pickUpBranch = $request->pickUpBranch;
        $pickUpBranchName = $request->pickUpBranchName;

        $data = [
            "accountType" => $accountType,
            "accountName" => $accountName,
            "accountNumber" => $accountNumber,
            "accountCurrency" => $accountCurrency,
            "accountCurrencyIsoCode" => $accountCurrencyIsoCode,
            "accountMandate" => $accountMandate,
            "authToken" => $authToken,
            "userID" => $userID,
            "userAlias" => $userAlias,
            "customerPhone" => $customerPhone,
            "customerNumber" => $customerNumber,
            "userMandate" => $userMandate,
            "cardType" => $cardType,
            "cardTypeName" => $cardTypeName,
            "pickUpBranch" => $pickUpBranch,
            "pickUpBranchName" => $pickUpBranchName,
        ];

        // return $data;
        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "card-request-gone-for-pending", $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
        }
    }

    // CORPORATE CARD BLOCK
    public function corporate_bloack_card_request(Request $request)
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

        $accountType = $allAccDetails[0];
        $accountName = $allAccDetails[1];
        $accountNumber = $allAccDetails[2];
        $accountCurrency = $allAccDetails[3];
        $accountCurrencyIsoCode = $allAccDetails[5];
        $accountMandate = $allAccDetails[6];
        $cardBranch = $request->cardBranch;
        $cardBranchName = $request->cardBranchName;
        $cardNumber = $request->cardNumber;
        $cardType = $request->cardType;
        $cardTypeName = $request->cardTypeName;

        $data = [
            "accountType" => $accountType,
            "accountName" => $accountName,
            "accountNumber" => $accountNumber,
            "accountCurrency" => $accountCurrency,
            "accountCurrencyIsoCode" => $accountCurrencyIsoCode,
            "accountMandate" => $accountMandate,
            "authToken" => $authToken,
            "userID" => $userID,
            "userAlias" => $userAlias,
            "customerPhone" => $customerPhone,
            "customerNumber" => $customerNumber,
            "userMandate" => $userMandate,
            "cardType" => $cardType,
            "cardTypeName" => $cardTypeName,
            "cardBranch" => $cardBranch,
            "cardBranchName" => $cardBranchName,
            "cardNumber" => $cardNumber,
        ];

        // return $data;
        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "card-block-gone-for-pending", $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
        }
    }
}