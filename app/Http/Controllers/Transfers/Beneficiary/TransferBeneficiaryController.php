<?php

namespace App\Http\Controllers\Transfers\beneficiary;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\classes\WEB\UserAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransferBeneficiaryController extends Controller
{
    //
    public function checkRequest($req)
    {

        $userID = session()->get('userId');
        $customerNumber = session()->get('customerNumber');
        $data = [
            "accountDetails" => [
                "beneficiaryAccount" => $req->accountNumber,
                // "beneficiaryAccountCurrency" => $req->account_currency,
                // "beneficiaryAcountName" => $req->account_name
            ],

            "addressDetails" => [
                "address1" => $req->beneficiaryAddress,
                "address2" => null,
                "address3" => null,
                "city" => null,
                "countryOfResidence" => null
            ],

            "bankDetails" => [
                "bankAddress" => null,
                "bankBranch" => null,
                "bankCity" => null,
                "bankCountry" => $req->bankCountry,
                "bankName" => $req->bankName,
                "bankSwiftCode" => $req->bankCode
            ],

            "beneID" => $req->beneficiaryId,

            "beneficiaryDetails" => [
                "email" => $req->beneficiaryEmail,
                "firstName" => $req->accountName,
                "lastName" => null,
                "nationality" => null,
                "nickname" => $req->beneficiaryName,
                "otherName" => null,
                "sendMail" => $req->notify,
            ],

            "beneficiaryType" => $req->type,

            "securityDetails" => [
                "approvedBy" => $customerNumber,
                "approvedDateTime" => date('Y-m-d'),
                "createdBy" => $customerNumber,
                "createdDateTime" =>  date('Y-m-d'),
                "entrySource" => null,
                "modifyBy" => $customerNumber,
                "modifyDateTime" =>  date('Y-m-d')
            ],

            "transactionType" => null,
            "userID" => $customerNumber,
            // "telephone" => $req->number

        ];
        return $data;
    }


    public function saveBeneficiary(Request $req)
    {

        $data = $this->checkRequest($req);
        try {
            if ($req->mode === "EDIT") {
                $response = Http::put(env('API_BASE_URL') . "/beneficiary/updateTransferBeneficiary", $data);
            } else {
                $response = Http::post(env('API_BASE_URL') . "/beneficiary/addTransferBeneficiary", $data);
            }

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            $base_response = new BaseResponse();
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }

    public function deleteBeneficiary(Request $req)
    {
        $response = Http::delete(
            env('API_BASE_URL') . "/beneficiary/deleteTransferBeneficiary/" . $req->beneficiaryId
        );
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }
}
