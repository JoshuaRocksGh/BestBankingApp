<?php

namespace App\Http\Controllers\Transfers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OwnAccountController extends Controller
{
    //

    public function own_account(Request $request)
    {
        // Alert::success('Transaction Successful', 'Success Message');
        return view('pages.transfer.own_account');
    }


    public function get_my_accounts()
    {
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $base_response = new BaseResponse();

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];
        $response = Http::post(env('API_BASE_URL') . "/account/getAccounts", $data);

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function own_account_transfer(Request $req)
    {

        // return $req;

        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');
        // return $deviceInfo;
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "amount" => $req->transferAmount,
            "authToken" => $authToken,
            "brand" => $deviceInfo['deviceBrand'],
            // "channel" => env('APP_CHANNEL'),
            "channel" => $channel,
            "creditAccount" => $req->beneficiaryAccountNumber,
            "currency" => $req->accountCurrency,
            "debitAccount" => $req->accountNumber,
            "deviceIp" => $client_ip,
            "entrySource" => $entrySource,
            "expenseType" => $req->transferCategory,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "deviceName" => $deviceInfo['deviceOs'],
            "narration" => $req->transferPurpose,
            "secPin" => $req->secPin,
            "userName" => $userID,
            // "category" => $req->category,
        ];

        // return $data;

        if (isset($req->select_frequency)) {
            $frequency = $req->select_frequency;
            // return $frequency;
            $selected_frequency_code = $frequency;
            $data['schedulePaymentDate'] = $req->schedule_payment_date;
            $data['selectFrequency'] = $selected_frequency_code;
        }

        // return $data ;

        try {

            $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "transfers/sameBank", $data);
            // return $response;
            $result = new ApiBaseResponse();
            // Log::alert($response);
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


    public function corporate_own_account_transfer(Request $req)
    {
        // return $req;

        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');
        $userMandate = session()->get('userMandate');


        $data = [


            "account_no" => $req->accountNumber,
            "account_name" => $req->accountName,
            "authToken" => $authToken,
            "channel" => 'NET',
            "destinationAccountId" => $req->beneficiaryAccountNumber,
            "beneficiary_name" => $req->beneficiaryName,
            "amount" => $req->transferAmount,
            "currency" => $req->accountCurrency,
            "narration" => $req->transferPurpose,
            "postBy" => $userID,
            "account_mandate" => $req->accountMandate,
            "user_mandate" => $userMandate,
            // "appBy" => '';
            "customerTel" => $customerPhone,
            "transBy" => $userID,
            "user_id" => $userID,
            "customer_no" => $customerNumber,
            "user_alias" => $userAlias,
            "expense_type" => $req->transferCategory
            // $documentRef => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 2) . time());

        ];


        if (isset($req->select_frequency)) {
            $frequency = $req->select_frequency;
            // return $frequency;
            $selected_frequency_code = $frequency;
            $data['schedulePaymentDate'] = $req->schedule_payment_date;
            $data['selectFrequency'] = $selected_frequency_code;
        }

        // return $data;

        try {

            // dd((env('CIB_API_BASE_URL') . "own-account-gone-for-pending"));

            $response = Http::post(env('CIB_API_BASE_URL') . "own-account-gone-for-pending", $data);
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