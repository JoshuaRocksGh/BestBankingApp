<?php

namespace App\Http\Controllers\Transfers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StandingOrderController extends Controller
{
    //method to display the standing order page
    public function display_standing_order()
    {
        return view('pages.transfer.standing_order');
    }

    //method to display standing order status
    public function display_standing_order_status()
    {
        return view('pages.transfer.standing_order_status');
    }

    //method to send pay load request
    public function standingOrderTransfer(Request $req)
    {
        // return $request;
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $api_headers = session()->get('headers');
        $clientIp = request()->ip();
        $deviceInfo = session()->get('deviceInfo');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');
        $userID = session()->get('userId');



        $data =
            [
                "amount" => $req->transferAmount,
                "authToken" => $authToken,
                "bankCode" => $req->bankCode,
                "brand" => $deviceInfo['deviceBrand'],
                "channel" => $channel,
                // "country" => '',
                "country" => $deviceInfo['deviceCountry'],
                "creditAccount" => $req->accountNumber,
                "debitAccount" => $req->beneficiaryAccountNumber,
                // "deviceId" => '',
                "deviceId" => $deviceInfo['deviceId'],
                "deviceIp" => $clientIp,
                // "deviceName" => '',
                "deviceName" => $deviceInfo['deviceOs'],
                "effectiveDate" => $req->soStartDate,
                "entrySource" => $entrySource,
                "expiryDate" => $req->soEndDate,
                "frequency" => $req->soFrequencyCode,
                // 'manufacturer' => '',
                "manufacturer" => $deviceInfo['deviceManufacturer'],
                'phoneNumber' => '',
                "pinCode" => $req->secPin,
                "transactionDesc" => $req->transferPurpose,
                'userName' => $userID,
                "expenseType" => $req->transferCategory,
            ];

        // Log::alert($data);
        // return $data;

        try {
            $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "transfers/standingOrder", $data);
            // return $response;
            // Log::alert("message");
            // Log::alert($response);
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

    public function corporate_standing_order_request(Request $req)
    {

        // return $req;
        $base_response = new BaseResponse();
        // return $req;


        $authToken = session()->get('userToken');
        $api_headers = session()->get('headers');
        $terminalId = get_current_user();
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');
        $userMandate = session()->get('userMandate');

        if ($req->fileUploaded == "Y") {
            $getInvoice = file_get_contents($req->voucher);
            $transVoucher = base64_encode($getInvoice);
        } else {
            $transVoucher = $req->voucher;
        }

        // return ($req);
        $data =
            [
                "amount" => $req->transferAmount,
                "authToken" => $authToken,
                // "bankCode" => $req->backCode,
                "destinationAccountId" => $req->beneficiaryAccountNumber,
                "account_no" => $req->accountNumber,
                "account_name" => $req->accountName,
                "deviceIp" => $terminalId,
                "effectiveDate" => $req->soStartDate,
                "expiryDate" => $req->soEndDate,
                "frequency" => $req->soFrequencyCode . '~' . $req->soFrequency,
                // "pinCode" => $req->secPin,
                "narration" => $req->transferPurpose,
                "channel" => 'NET',
                "currency" => $req->accountCurrency,
                "account_mandate" => $req->accountMandate,
                "postBy" => $userID,
                "customerTel" => $customerPhone,
                "transBy" => $userAlias,
                "customer_no" => $customerNumber,
                "user_alias" => $userAlias,
                "user_mandate" => $userMandate,
                "beneficiaryName" => $req->beneficiaryName,
                "documentRef" => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 2) . time()),
                "transaction_voucher" => $transVoucher,
                "file_uploaded" => $req->fileUploaded,
            ];
        // return $data;
        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "standing-order-gone-for-pending", $data);
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


    public function getStandingOrderStatus(Request $request)
    {
        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        // $authToken = session()->get('userToken');
        $userId = session()->get('userId');
        $deviceInfo = session()->get('deviceInfo');
        $channel = \config('otp.channel');
        $entrySource = \config('otp.entry_source');
        $data = [
            "accountNumber" => $request->accountNumber,
            "authToken" => $authToken,

            //             "accountNumber": "string",
            //   "authToken": "string",
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $deviceInfo['deviceIp'],
            "deviceName" => $deviceInfo['deviceBrand'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "userName" => $userId
        ];

        // return $data;
        try {

            $response = Http::post(env('API_BASE_URL') . "/transfers/standingOrderEnq/", $data);
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

    public function cancelStandingOrder(Request $request)
    {
        $base_response = new BaseResponse();

        $deviceInfo = session()->get('deviceInfo');
        $userId = session()->get('userId');
        // $deviceInfo = session()->get('deviceInfo');
        $channel = \config('otp.channel');
        $entrySource = \config('otp.entry_source');
        $data = [
            "orderNumber" => $request->orderNumber,
            "authToken" => session()->get('userToken'),
            "myPin" => $request->pinCode,
            "deviceIp" => $deviceInfo["deviceIp"],
            // "authToken": "string",

            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $deviceInfo['deviceIp'],
            "deviceName" => $deviceInfo['deviceBrand'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "userName" => $userId
        ];

        // return $data;
        try {

            $response = Http::post(env('API_BASE_URL') . "/transfers/cancelStandingOrder", $data);
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
}
