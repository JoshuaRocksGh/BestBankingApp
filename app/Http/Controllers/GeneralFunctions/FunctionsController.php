<?php

namespace App\Http\Controllers\GeneralFunctions;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Illuminate\Support\Facades\Log;

class FunctionsController extends Controller
{


    public function baseResponseApi($response)
    {

        $base_response = new BaseResponse();

        if ($response->ok()) {    // API response status code is 200

            $result = json_decode($response->body());
            // return $result->responseCode;


            if ($result->responseCode == '000') {

                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            } else {   // API responseCode is not 000

                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            }
        } else { // API response status code not 200

            return $response->body();
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'code' => $response->status(),
                'message' => $response->body()
            ]);

            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }


    public function get_fx_rate(Request $request)
    {

        $base_response = new BaseResponse();

        if ($request->has("rateType")) {
            $rateType = $request->query("rateType");
        }

        $rateType = $request->query("rateType");

        if (empty($rateType)) {
            $rateType = "Transfer rate";
        }

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $data = [
            "authToken" => $authToken,
            "rateType" => $rateType
        ];

        try {
            $response = Http::post(\config('base_urls.api_base_url') . "utilities/getFxRates", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }



    public function get_correct_fx_rate()
    {
        $base_response = new BaseResponse();


        try {
            $response = Http::get(\config('base_urls.api_base_url') . "utilities/getCorrectFxRates");

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }





    public function get_accounts()
    {
        $base_response = new BaseResponse();



        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get('headers');
        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        try {
            $response = Http::post(\config('base_urls.api_base_url') . "account/getAccounts", $data);
            if ($response->ok()) { // API response status code is 200

                $res = json_decode($response->body());
                if ($res->responseCode === "000") {
                    session([
                        "customerAccounts" => $res->data
                    ]);
                }
            }
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }


    public function currency_list()
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $base_response = new BaseResponse();

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        try {
            $response = Http::get(\config('base_urls.api_base_url') . "utilities/getCurrencies");

            //return $response;
            // return $response->status();

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }



    public function security_question()
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $base_response = new BaseResponse();

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        try {
            $response = Http::get(\config('base_urls.api_base_url') . "utilities/getSecQuestions");

            //return $response;
            // return $response->status();
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }



    public function validate_account_no(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'accountNumber' => 'required',
        ]);

        $base_response = new BaseResponse();
        // VALIDATION
        if ($validator->fails()) {
            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;
        $account_no = $request->accountNumber;


        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');



        $data = [
            "authToken" => $authToken,
            "accountNumber"    => $account_no
        ];

        // return $data;
        try {
            $response = Http::post(\config('base_urls.api_base_url') . "account/validateBBAN", $data);

            // return $response->body();

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }




    public function get_transfer_beneficiary(Request $request)
    {
        $beneType = $request->beneType;

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');

        $base_response = new BaseResponse();

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];
        // return env('API_BASE_URL') . "/beneficiary/getTransferBeneficiariestype}?userID=$customerNumber&bankType=$beneType";

        $response = Http::get(\config('base_urls.api_base_url') . "beneficiary/getTransferBeneficiariestype}?userID=$customerNumber&bankType=$beneType");
        // $response = Http::get(env('API_BASE_URL') . "/beneficiary/getTransferBeneficiaries/$customerNumber");

        // return $response;
        // return $response->status();
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
    public function getCountries()
    {

        $response = Http::get(\config('base_urls.api_base_url') . "utilities/getCountries");

        //return $response;
        // return $response->status();
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function bank_list()
    {


        $base_response = new BaseResponse();

        //return $response;
        // return $response->status();

        try {
            // dd(\config('base_urls.api_base_url') . "utilities/getBanks");
            $response = Http::get(\config('base_urls.api_base_url') . "utilities/getBanks");

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }
    public function international_bank_list(Request $req)
    {

        $base_response = new BaseResponse();

        try {
            $response = Http::get(\config('base_urls.api_base_url') . "utilities/getInternationalBanks/$req->countryCode");
            // Log::alert($response);

            //return $response;
            // return $response->status();
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
        }
    }

    public function lovs_list()
    {

        // Log::critical("message");
        $response = Http::get(\config('base_urls.api_base_url') . "account/lovs");
        $base_response = new BaseResponse();

        if ($response->ok()) {    // API response status code is 200
            $result = json_decode($response);
            // Log::critical($response->ok());

            // return $result->responseCode;

            return $base_response->api_response("000", "List of lOVs",  $result); // return API BASERESPONSE

        } else { // API response status code not 200

            //     return $response->body();
            //     DB::table('tb_error_logs')->insert([
            //         'platform' => 'ONLINE_INTERNET_BANKING',
            //         'user_id' => 'AUTH',
            //         'code' => $response->status(),
            //         'message' => $response->body()
            //     ]);

            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }




    //method to return the interest types
    public function get_transaction_fees(Request $request)
    {

        $accountNumber = $request->accountNumber;
        $amount = $request->amount;
        $transfer_type = $request->transfer_type;
        // $feeType = $request->feeType;

        // return $request;
        // ACHP
        // RTG

        if ($transfer_type == "ACH") {
            $feeType = "ACHP";
        } else if ($transfer_type == "RTGS") {
            $feeType = "RTGS";
        } else {
            return false;
        }

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');



        $data = [
            "accountNumber" => $accountNumber,
            "amount"    => $amount,
            "feeType"    => $feeType,
            "authToken"    => $authToken,
        ];

        // return $data;

        // dd(env('API_BASE_URL') . "transfers/transactionFees");

        $response = Http::post(env('API_BASE_URL') . "transfers/transactionFees", $data);

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    // method to return expense types
    public function get_expenses()
    {
        $response = Http::get(env('API_BASE_URL') . "/utilities/expenseTypes");

        //return $response;
        // return $response->status();
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function get_standing_order_frequencies()
    {
        // return 'kjsdf';


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get('headers');

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        $base_response = new BaseResponse();
        $response = Http::withHeaders($api_headers)->get(env('API_BASE_URL') . "/transfers/standingOrderFrequencies", $data);

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function payment_types()
    {
        $base_response = new BaseResponse();
        try {
            $response = Http::get(env('API_BASE_URL') . "/payment/paymentType");
            $result = new ApiBaseResponse();
            return $result->api_response($response);
            // return $base_response->api_response("000", "payment types",  $result); // return API BASERESPONSE
        } catch (\Exception $e) {
            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }

    public function reset_security_question($user_id)
    {
        $user_id = $user_id;
        $response = Http::retry(10, 100)->get(env('API_BASE_URL') . "/user/question/{$user_id}");
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function recipientNameEnquiry(Request $req)
    {
        // return $req;
        $data = [
            'payNumber' => $req->beneficiaryAccount,
            'paymentCode' => $req->payeeName,
            'paymentType' => $req->paymentType
        ];
        // return $data;
        if ($req->payeeName == "DYCAR") {

            // http://197.157.233.214:5908/integrator/dycar/verifyMeter?meterNumber=54120004053

            $response = Http::get("http://197.157.233.214:5908/integrator/dycar/verifyMeter?meterNumber=$req->beneficiaryAccount");
            $result = new ApiBaseResponse();
            return $result->api_response($response);
        }




        $response = Http::post(env('API_BASE_URL') . "/payment/nameEnquiry", $data);
        // return $response;
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
}
