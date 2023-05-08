<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\classes\WEB\ApiBaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\classes\API\BaseResponse;


class LoansController extends Controller
{
    //
    public function loan_request()
    {
        return view('pages.loans.loan_request');
    }

    public function sendLoanRequestQuote(Request $request)
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');
        // return $authToken;

        // $base_response = new BaseResponse();

        $loanProduct = $request->loanProductCode;
        $loanAmount = $request->loanAmount;
        // $entrySource = $request->entrySource;
        $tenureInMonths = $request->tenureInMonths;
        $interestRateType = $request->interestRateTypeCode;
        $principalRepayFreq = $request->principalRepayFreqCode;
        $interestRepayFrequency = $request->interestRepayFreqCode;
        $data = [

            "amount" => $loanAmount,
            "authToken" => $authToken,
            "deviceIp" => "A",
            "entrySource" => $entrySource,
            "channel" =>  $channel,
            "interestRepayFrequency" => $interestRepayFrequency,
            "interestType" => $interestRateType,
            "loanProduct" => $loanProduct,
            "principalRepayFrequency" => $principalRepayFreq,
            "tenure" => $tenureInMonths

        ];
        $response = Http::post(env('API_BASE_URL') . "/loans/loanQuotation", $data);
        // return $response;die();
        $result = new ApiBaseResponse();

        return $result->api_response($response);
    }

    public function postLoanOrigination(Request $request)
    {
        // Log::alert("request");
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');
        $data = [

            "amount" => $request->loanAmount,
            "authToken" => $authToken,
            "customerNumber" => session()->get("customerNumber"),
            "entrySource" => $entrySource,
            "channel" => $channel,
            "introSource" => "MOB",
            "otherPurpose" => "other",
            "pBranch" => $request->productBranchCode,
            "pin" => $request->secPin,
            "postedBy" => $userID,
            "productCode" => $request->loanProductCode,
            "purpose" => $request->loanPurpose,
            "sector" => $request->loanSectorCode,
            "subSector" => $request->loanSubSectorCode,
        ];
        // return $data;
        $response = Http::post(env('API_BASE_URL') . "/loans/loanOrigination", $data);
        $result = new ApiBaseResponse();

        return $result->api_response($response);
    }


    public function getLoanIntroSource()
    {
        $response = Http::get(env('API_BASE_URL') . "/loans/introSource");
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
    public function getLoanSectors()
    {
        $response = Http::get(env('API_BASE_URL') . "/loans/sectors");
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
    public function getLoanSubSectors(Request $request)
    {
        // $code = $request->loanSectorCode;
        // Log::alert($code);
        $response = Http::get(env('API_BASE_URL') . "/loans/subSectors/{$request->loanSectorCode}");

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
    public function getLoanPurpose()
    {
        $response = Http::get(env('API_BASE_URL') . "/loans/purpose");
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
    //method to return the interest types
    public function get_Interest_Types()
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        $response = Http::get(env('API_BASE_URL') . "/loans/interestTypes", $data);

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    //method to return the interest types
    public function get_loan_frequencies()
    {

        $base_response = new BaseResponse();

        try {
            $response = Http::get(env('API_BASE_URL') . "/loans/loanFrequencies");

            // $response = Http::get(env('API_BASE_URL') . "/loans/loanTypes");

            // $response = Http::retry(20, 100)->post(env('API_BASE_URL') . "loans/getLoans", $data);
            // $response = Http::post(env('API_BASE_URL') . "loans/getLoans", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }


        // $result = new ApiBaseResponse();
        // return $result->api_response($response);
    }

    public function getLoanTypes()
    {
        $base_response = new BaseResponse();


        try {
            $response = Http::get(env('API_BASE_URL') . "/loans/loanTypes");

            // $response = Http::retry(20, 100)->post(env('API_BASE_URL') . "loans/getLoans", $data);
            // $response = Http::post(env('API_BASE_URL') . "loans/getLoans", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }

        // $result = new ApiBaseResponse();
        // return $result->api_response($response);
    }
    public function get_my_loans_accounts()
    {
        $base_response = new BaseResponse();


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get('headers');

        $data = [
            "token" => $authToken,
        ];

        // $res = retry(3, function ($api_headers, $data) {
        //     $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "loans/getLoans", $data);
        //     $result = new ApiBaseResponse();
        //     return $result->api_response($response);
        // });

        // $response = Http::get(env('API_BASE_URL') . "/account/accountFD/$customerNumber");
        try {
            $response = Http::retry(20, 100)->post(env('API_BASE_URL') . "loans/getLoans", $data);
            // $response = Http::post(env('API_BASE_URL') . "loans/getLoans", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }

    public function getLoanTracking()
    {
        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');

        try {
            $response = Http::get(env('API_BASE_URL') . "loans/loanTrack/" . $customerNumber);
            // $response = Http::post(env('API_BASE_URL') . "loans/getLoans", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }

    public function get_Loan_products()
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        $response = Http::get(env('API_BASE_URL') . "/loans/loanProducts", $data);

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }

    public function getLoanDetails(Request $request)
    {
        $response = Http::get(env('API_BASE_URL') . "/loans/loanDetails/{$request->facilityNo}");

        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }


    public function send_loan_request(Request $request)
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');
        $deviceIp = request()->ip();

        // return $authToken;

        // $base_response = new BaseResponse();

        $loanProduct = $request->loan_product;
        $loanAmount = $request->loan_amount;
        // $entrySource = $request->entrySource;
        $loan_duration = $request->loan_duration;
        $interest_rate_type = $request->interest_rate_type;
        $principal_repay_freq = $request->principal_repay_freq;
        $interest_repay_freq = $request->interest_repay_freq;
        $loan_purpose = $request->loan_purpose;
        $disbursement_account = $request->disbursement_account;
        $data = [

            "amount" => $loanAmount,
            "authToken" => $authToken,
            "deviceIp" => $deviceIp,
            "entrySource" => $entrySource,
            "channel" => $channel,
            "interestRepayFrequency" => $interest_repay_freq,
            "interestType" => $interest_rate_type,
            "loanProduct" => $loanProduct,
            "principalRepayFrequency" => $principal_repay_freq,
            "tenure" => $loan_duration

        ];

        // return $data;
        $response = Http::post(env('API_BASE_URL') . "/loans/loanOrigination", $data);

        $result = new ApiBaseResponse();

        return $result->api_response($response);
    }

    public function getLoanRepaySchedule(Request $request)
    {
        // return $request;
        $base_response = new BaseResponse();


        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get('headers');
        $facility_number = $request->facilityNumber;

        // $data = [
        //     "token" => $authToken,
        // ];

        // $res = retry(3, function ($api_headers, $data) {
        //     $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "loans/getLoans", $data);
        //     $result = new ApiBaseResponse();
        //     return $result->api_response($response);
        // });

        // $response = Http::get(env('API_BASE_URL') . "/account/accountFD/$customerNumber");
        // dd(env('API_BASE_URL') . "loans/loanrepayschedule/$facility_number");
        try {
            $response = Http::get(env('API_BASE_URL') . "loans/loanrepayschedule/$facility_number");
            // $response = Http::post(env('API_BASE_URL') . "loans/getLoans", $data);
            return $response;

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }
}