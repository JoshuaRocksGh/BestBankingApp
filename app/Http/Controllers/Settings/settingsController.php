<?php

namespace App\Http\Controllers\Settings;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class settingsController extends Controller
{
    public function settings()
    {
        return view('pages.settings.settings');
    }
    //method to return the change pin screen
    public function change_pin()
    {
        return view('pages.settings.change_pin');
    }

    //method to return the biometric setup screen
    public function biometric_setup()
    {
        return view('pages.settings.biometric_setup');
    }

    //method to return the forgot transaction pin screen
    public function forgot_transaction_pin()
    {
        return view('pages.settings.forgot_transaction_pin');
    }

    //method to return the set transaction limit screen
    public function set_transaction_limit()
    {
        return view('pages.settings.set_transaction_limit');
    }

    //method to return the biometric setup
    public function update_company_info()
    {
        return view('pages.settings.update_company_info');
    }

    //method to return the create originator
    public function create_originator()
    {
        return view('pages.settings.create_originator');
    }

    public function create_originator_api(Request $request)
    {
        // return $request;
        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get("headers");
        // return $authToken;

        // $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');
        $userMandate = session()->get('userMandate');


        $accountNumber = $request->accountNo;
        $firstName = $request->firstName;
        $telephone = $request->telephone;
        $lastName = $request->lastName;
        $email = $request->email;
        // $accountNumber = "004001100241700194";
        // $beneficiaryMobileNo = $request->receiver_phoneNo;
        // $customerNo = session()->get('customerNumber');
        // $postedBy = session()->get('userAlias');
        // $referenceNo = $request->reference_no;
        // $pinCode = $request->pin;

        $getAccount = $request->accountDetails;
        $allAccDetails = explode("~", $getAccount);
        // return $allAccDetails;
        $accountType = $allAccDetails[0];
        $accountName = $allAccDetails[1];
        $accountNumber = $allAccDetails[2];
        $accountCurrency = $allAccDetails[3];
        $accountCurrencyIsoCode = $allAccDetails[5];
        $accountMandate = $allAccDetails[6];


        $data = [

            "accountName" => $accountName,
            "accountNumber" => $accountNumber,
            "firstName" => $firstName,
            "telephone" => $telephone,
            "lastName" => $lastName,
            "email" => $email,
            "authToken" => $authToken,
            "userID" => $userID,
            "userAlias" => $userAlias,
            "customerPhone" => $customerPhone,
            "customerNumber" => $customerNumber,
            "userMandate" => $userMandate,
            "accountMandate" => $accountMandate,

        ];
        // for debugging purposes
        // return $data;

        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "create-originator-gone-for-pending", $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);

        }catch(\Exception $e){


            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE

        }

        // $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "payment/reverseCardless", $data);
        // return $response;

        //for debugging purposes
        // return $data;
        // $response = Http::get(env('API_BASE_URL') . "payment/unredeemedCardless/$accountNumber");
        // return $response;die();
        // $result = new ApiBaseResponse();

        // return $result->api_response($response);
    }

    public function set_transaction_limits_api(Request $request)
    {
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $api_headers = session()->get("headers");
        // return $authToken;

        // $base_response = new BaseResponse();



        $rtgsLimit = $request->rtgs_limit;
        $directCreditLimit = $request->direct_credit_limit;
        $rokelLimit = $request->rokel_limit;
        $directCreditBulkLimit = $request->direct_credit_bulk_limit;
        $rokelBulkLimit = $request->rokel_bulk_limit;
        // $accountNumber = "004001100241700194";
        // $beneficiaryMobileNo = $request->receiver_phoneNo;
        // $customerNo = session()->get('customerNumber');
        // $postedBy = session()->get('userAlias');
        // $referenceNo = $request->reference_no;
        // $pinCode = $request->pin;


        $data = [

            // "accountNumber"=> $accountNumber,
            // "firstName"=> $firstName,
            // "otherName"=> $otherName,
            // "lastName"=> $lastName,
            // "email"=> $email

            "rtgsLimit" => $rtgsLimit,
            "directCreditLimit" => $directCreditLimit,
            "rokelLimit" => $rokelLimit,
            "directCreditBulkLimit" => $directCreditBulkLimit,
            "rokelBulkLimit" => $rokelBulkLimit

        ];
        // for debugging purposes
        return $data;


        // $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "request/setTransactionLimit", $data);
        // return $response;

        //for debugging purposes

        // return $response;die();
        // $result = new ApiBaseResponse();

        // return $result->api_response($response);
    }

    // public function create_originator(Request $request)
    // {
    //     return $request;
    // }
}
