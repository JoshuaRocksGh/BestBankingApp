<?php

namespace App\Http\Controllers\Payments;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PaymentsController extends Controller
{

    public function paymentTypes()
    {

        return view('pages.payments.payment_types');
    }

    public function makePayment(Request $req)
    {
        // return $req;
        $base_response = new BaseResponse();
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');
        // $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');






        if (config("app.corporate")) {

            // return $req;
            // return false;


            $authToken = session()->get('userToken');
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

            $data = [
                "account_no" => $req->account,
                "account_name" => $req->accountName,
                "channel" => 'NET',
                'amount' => $req->amount,
                "currency" => $req->accountCurrency,
                "currency_isoCode" => $req->accountCurrCode,
                "postBy" => $userID,
                "account_mandate" => $req->accountMandate,
                "user_mandate" => $userMandate,
                "customerTel" => $customerPhone,
                "transBy" => $userID,
                "user_id" => $userID,
                "customer_no" => $customerNumber,
                "user_alias" => $userAlias,
                'naration' => $req->paymentDescription,
                'payeeName' => $req->payeeName,
                'payeeNumber' => $req->paymentAccount,
                'paymentCode' => $req->payeeName,
                'paymentType' => $req->paymentType,
                'beneficiaryAccount' => $req->beneficiaryAccount,
                'recipientName' => $req->recipientName,
                "transaction_voucher" => $transVoucher,
                "file_uploaded" => $req->fileUploaded,

            ];

            // return $data;

            try {
                $response = Http::post(env('CIB_API_BASE_URL') . "payment-gone-for-pending", $data);
                // return $response;
                $result = new ApiBaseResponse();
                return $result->api_response($response);
            } catch (\Exception $e) {
                return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
            }
        }

        if ($req->payeeName == "DYCAR" &&  $req->paymentType == "UTL") {

            $data = [

                "accountNumber" => $req->account,
                "amount" => $req->amount,
                "authToken" => $authToken,
                "brand" => $deviceInfo['deviceBrand'],
                // "channel" => env('APP_CHANNEL'),
                "channel" => "MOB",
                // "channel" => $channel,
                "country" => $deviceInfo['deviceCountry'],
                "customerName" => $req->recipientName,
                "customerNumber" => $customerNumber,
                "deviceId" => $deviceInfo['deviceId'],
                "deviceIp" => $client_ip,
                "deviceName" => $deviceInfo['deviceOs'],
                "entrySource" => $entrySource,
                "manufacturer" => $deviceInfo['deviceManufacturer'],
                "meterNumber" => $req->beneficiaryAccount,
                "phoneNumber" => $customerNumber,
                "pinCode" => $req->pinCode,
                "userName" => $req->recipientName

            ];

            $url = "http://10.1.1.45:5908/ibank/api/v1.0/edsa/buyCredit";
        } else if ($req->payeeName == "AFRI" &&  $req->paymentType == "AIR") {
            $data = [
                "accountNumber" => $req->account,
                "amount" => $req->amount,
                "authToken" =>  $authToken,
                "brand" => $deviceInfo['deviceBrand'],
                "channel" => "MOB",
                "country" => $deviceInfo['deviceCountry'],
                "deviceId" => $deviceInfo['deviceId'],
                "deviceIp" =>  $client_ip,
                "deviceName" => $deviceInfo['deviceOs'],
                "entrySource" => $entrySource,
                "manufacturer" => $deviceInfo['deviceManufacturer'],
                "phoneNumber" => "",
                "pinCode" => $req->pinCode,
                "telephone" => $req->beneficiaryAccount,
                "userName" =>  $req->recipientName
            ];

            $url = "http://10.1.1.45:5908/ibank/api/v1.0/africel/africelTopup";
        } else if ($req->payeeName == "AFRI" &&  $req->paymentType == "MOM") {

            $data = [
                "accountNumber" => $req->account,
                "amount" => $req->amount,
                "authToken" => $authToken,
                "brand" => $deviceInfo['deviceBrand'],
                "channel" =>  "MOB",
                "country" => $deviceInfo['deviceCountry'],
                "currency" => $req->accountCurrency,
                "customerName" => $req->accountName,
                "deviceId" => $deviceInfo['deviceId'],
                "deviceIp" => $client_ip,
                "deviceName" =>  $deviceInfo['deviceOs'],
                "entrySource" => $entrySource,
                "manufacturer" => $deviceInfo['deviceManufacturer'],
                "network" => "AFRICELL",
                "phoneNumber" => "",
                "pinCode" =>  $req->pinCode,
                "telephone" => $customerNumber,
                "userName" => $req->recipientName
            ];


            if ($req->momoTransferType == "AcctToMomo") {
                $url = "http://10.1.1.45:5908/ibank/api/v1.0/africel/creditMomo";
            } else {
                $url = "http://10.1.1.45:5908/ibank/api/v1.0/africel/debitMomo";
            }
        } else {

            $data = [
                'accountNumber' => $req->account,
                'amount' => $req->amount,
                'customerName' => session()->get('userId'),
                'customerNumber' => session()->get('customerNumber'),
                'customerPhone' => session()->get('customerPhone'),
                // 'entrySource' => "MOM",
                'entrySource' => $entrySource,
                'channel' => $channel,
                'naration' => $req->paymentDescription,
                'payeeName' => $req->payeeName,
                'payeeNumber' => $req->paymentAccount,
                'paymentCode' => $req->payeeName,
                'paymentType' => $req->paymentType,
                'pinCode' => $req->pinCode,
            ];


            $url = "payment/makePayment";
        }

        // $data["pinCode"] = $req->pinCode;
        // return $data;
        // if($req->payeeName == "AFRICEL"){
        //     $response = Http::get("http://10.1.1.45:5908/ibank/api/v1.0/africel/africelTopup", );
        //     $result = new ApiBaseResponse();
        //     return $result->api_response($response);
        // }
        try {
            // http://10.1.1.45:5908/ibank/api/v1.0/edsa/buyCredit
            // $response = Http::post(env('API_BASE_URL') . $url, $data);
            $response = Http::post($url, $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
        }
    }

    public function get_link_status()
    {
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        try {
            $response = Http::get("http://10.1.1.45:5908/ibank/api/v1.0/africel/getLinkedAccount/${authToken}");
            // return $response;
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE
        }
    }
}
