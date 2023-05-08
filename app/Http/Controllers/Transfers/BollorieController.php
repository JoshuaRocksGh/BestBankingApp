<?php

namespace App\Http\Controllers\Transfers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BollorieController extends Controller
{
    //
    public function view_bollorie()
    {
        return view('pages.transfer.bollorie_link');
    }

    public function bollore_transfer(Request $request)
    {
        // return $request;

        $base_response = new BaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');
        $deviceIP = $request->ip();
        $userAlias = session()->get('userAlias');
        // return $userAlias;


        $accountDetails = $request->accountDetails;
        $getAccountDetails = explode("~", $accountDetails);
        // return $getAccountDetails;
        $accountName = $getAccountDetails[1];
        $accountNumber = $getAccountDetails[2];
        $accountCurrency = $getAccountDetails[3];
        $accountCurrencyIsoCode = $getAccountDetails[5];
        $accountMandate = $getAccountDetails[6];



        $beneficiaryName = $request->beneficiaryName;
        $beneficiaryAddress = $request->beneficiaryAddress;
        $receiverName = $request->receiverName;
        $idType = $request->idType;
        $idNumber = $request->idNumber;
        $transferAmount = $request->transferAmount;
        $transferPurpose = $request->transferPurpose;
        $receiverTelephone = $request->receiverTelephone;

        $data = [
            'account_name' => $accountName,
            'account_number' => $accountNumber,
            'account_currency' => $accountCurrency,
            'currency_isoCode' => $accountCurrencyIsoCode,
            'account_mandate' => $accountMandate,
            'beneficiary_name' => $beneficiaryName,
            'beneficiary_address' => $beneficiaryAddress,
            'receiver_name' => $receiverName,
            'id_type' => $idType,
            'id_number' => $idNumber,
            'transfer_amount' => $transferAmount,
            'transfer_purpose' => $transferPurpose,
            'receiver_telephone' => $receiverTelephone,
            'posted_by' => $userID,
            'customer_number' => $customerNumber,
            'user_alias' => $userAlias
        ];

        // return $data;

        try {

            // return (env('CIB_API_BASE_URL') . "bollore-transfer-pending");

            $response = Http::post(env('CIB_API_BASE_URL') . "bollore-transfer-pending", $data);
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
