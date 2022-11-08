<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SalaryAdvanceController extends Controller
{
    //
    public function salary_advance_fee(Request $request)
    {

        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $accountDetails = $request->transferAccount;


        $getAccountDetails = explode("~", $accountDetails);
        $getAccountNumber = $getAccountDetails[2];
        $getAmount = $request->transferAmount;
        // return $getAccountDetails;
        $data = [
            "accountNumber" => $getAccountNumber,
            "amount" => $getAmount,
            "authToken" => $authToken,
            "feeType" => "salad",
        ];

        // return $data;

        // $response = Http::post(env('API_BASE_URL') . "/saladFees", $data);
        // return $response;
        // $result = new ApiBaseResponse();
        // return $result->api_response($response);

        try {

            // dd((env('API_BASE_URL') . "request/saladFees"));

            $response = Http::post(env('API_BASE_URL') . "request/saladFees", $data);
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

    public function salary_advance(Request $request)
    {
        // return $request;
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $accountDetails = $request->transferAccount;


        $getAccountDetails = explode("~", $accountDetails);
        // return $getAccountDetails;
        $getAccountType = $getAccountDetails[0];
        $getAccountName = $getAccountDetails[1];
        $getAccountNumber = $getAccountDetails[2];
        $getAccountCurrency = $getAccountDetails[3];
        $getAccountBalance = $getAccountDetails[4];
        $getAccountCurIsoCode = $getAccountDetails[5];
        $getAccountMandate = $getAccountDetails[6];
        $getAmount = $request->transferAmount;
        $getReason = $request->tranferReason;
        $getsecPin = $request->secPin;

        $data = [
            "accountNumber" => $getAccountNumber,
            "amount" => $getAmount,
            "authToken" => $authToken,
            "deviceIp" => request()->ip(),
            "pinCode" => $getsecPin,
            "reason" => $getReason,
        ];

        try {

            // dd((env('API_BASE_URL') . "request/saladFees"));

            $response = Http::post(env('API_BASE_URL') . "request/saladRequest", $data);
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

    public function salary_advance_deposit(Request $request)
    {
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $accountDetails = $request->transferAccount;


        $getAccountDetails = explode("~", $accountDetails);
        // return $getAccountDetails;
        $getAccountType = $getAccountDetails[0];
        $getAccountName = $getAccountDetails[1];
        $getAccountNumber = $getAccountDetails[2];
        $getAccountCurrency = $getAccountDetails[3];
        $getAccountBalance = $getAccountDetails[4];
        $getAccountCurIsoCode = $getAccountDetails[5];
        $getAccountMandate = $getAccountDetails[6];
        $getAmount = $request->transferAmount;
        $getReason = $request->tranferReason;
        $getsecPin = $request->secPin;
    }
}