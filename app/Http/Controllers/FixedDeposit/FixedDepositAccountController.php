<?php

namespace App\Http\Controllers\FixedDeposit;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FixedDepositAccountController extends Controller
{
    //

    function fixed_deposit_account()
    {

        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');


        // return $customerNumber;

        $data = [
            "authToken" => $authToken,
            "userId"    => $userID
        ];

        try {

            // $response = Http::retry(20, 300)->get(env('API_BASE_URL') . "/account/accountFD/$customerNumber");
            // $response = retry(3, function ($customerNumber) {
            //     return Http::get(env('API_BASE_URL') . "/account/accountFD/$customerNumber");
            //     // $result = new ApiBaseResponse();
            //     // return $result->api_response($response);
            // }, 200);


            // $response = Http::retry(20, 100)->get(env('API_BASE_URL') . "/account/accountFD/$customerNumber");
            $response = Http::get(env('API_BASE_URL') . "account/investments/$customerNumber");

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }

    public function fixed_deposit()
    {
        return view('pages.accountServices.fixedDeposit.fixed_deposit_services');
    }
}