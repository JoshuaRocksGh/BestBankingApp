<?php

namespace App\Http\Controllers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



class transferController extends Controller
{

    public function transfer()
    {
        return view('pages.transfer.transfer');
    }



    public function international_bank()
    {
        $response = Http::get(env('API_BASE_URL') . "/utilities/getBanks");
        return view('pages.transfer.international_bank_beneficiary')->with('banks', $response['data']);
    }

    public function international_bank_()
    {
        return view('pages.transfer.international_bank');
    }

    public function beneficiary_list()
    {
        return view('pages.transfer.beneficiary_list');
    }
    public function forex_request()
    {
        return view('pages.transfer.forex_rate');
    }

    public function transferBeneficiaryList()
    {

        $base_response = new BaseResponse();
        $customerNumber = session()->get('customerNumber');
        $userID = session()->get('userId');

        try {
            $response = Http::get(env('API_BASE_URL') . "/beneficiary/getTransferBeneficiaries/$customerNumber");

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE

        }
    }

    public function delete_beneficiary(Request $request)
    {
        $beneficiaryId = $request->beneficiaryId;

        return $beneficiaryId;
    }
}