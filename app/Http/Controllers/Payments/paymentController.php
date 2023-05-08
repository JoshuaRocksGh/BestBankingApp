<?php

namespace App\Http\Controllers\Payments;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class paymentController extends Controller
{


    //method to return the bulk upload payment screen
    public function bulk_upload_payment()
    {
        return view("pages.payments.bulk_upload_payment");
    }



    //method to return the cardless payment screen
    public function cardless_payment()
    {
        return view("pages.payments.cardless_payment");
    }

    //method to return the korpone loane payment screen
    public function salone_link()
    {

        return view("pages.payments.e_korpor");
    }

    //method to return the order blink payment screen
    public function order_blink_payment()
    {
        return view("pages.payments.order_blink_payment");
    }

    //method to return the pay again payment screen
    public function pay_again_payment()
    {
        return view("pages.payments.pay_again_payment");
    }

    //method to return the qr payment screen
    public function qr_payment()
    {
        return view("pages.payments.qr_payment");
    }

    //method to return the request blink payment screen
    public function request_blink_payment()
    {
        return view("pages.payments.request_blink_payment");
    }

    //method to return the schudule payment screen
    public function schedule_payment()
    {
        return view("pages.payments.schedule_payment");
    }

    public function beneficiary_list()
    {

        return view('pages.payments.payments_beneficiary_list');
    }

    public function airport_tax()
    {
        return view('pages.payments.airport_tax_payment');
    }

    public function national_id()
    {
        return view('pages.payments.national_id_payment');
    }

    public function paymentBeneficiaries()
    {
        // $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');
        $response = Http::get(env('API_BASE_URL') . "/beneficiary/getPaymentBeneficiaries/$customerNumber");
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function get_airport_tax_amount()
    {
        $base_response = new BaseResponse();

        try {

            $response = Http::get(env('API_BASE_URL') . "payment/airportTaxAmount");
            return $response;
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

    public function airport_tax_payment(Request $request)
    {

        // return $request;
        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');
        // return $deviceInfo;
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');
        // return $userAlias;


        $accountDetails = $request->accountDetails;
        $getAccountDetails = explode("~", $accountDetails);
        // return $getAccountDetails;
        $accountName = $getAccountDetails[1];
        $accountNumber = $getAccountDetails[2];
        $accountCurrency = $getAccountDetails[3];
        $accountCurrencyIsoCode = $getAccountDetails[5];
        $accountMandate = $getAccountDetails[6];

        $data = [
            "accountNumber" => $accountNumber,
            "amount" => $request->transferAmount,
            "authToken" => $authToken,
            "currency" => $accountCurrency,
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "entrySource" => $entrySource,
            "flightDate" => $request->flightDate,
            "flightNumber" => $request->flightNumber,
            "passportNumber" => $request->passportNumber,
            "phoneNumber" => "",
            "pinCode" => $request->userPin,
            "userName" => $userID
        ];

        // return $api_headers;
        // {"x-api-key":"123","x-api-secret":"123","x-api-source":"123","x-api-token":"123"}

        try {

            $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "payment/airportTax", $data);
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
}
