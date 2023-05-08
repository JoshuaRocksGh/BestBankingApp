<?php

namespace App\Http\Controllers\Transfers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransferStatusController extends Controller
{
    public function transfer_status()
    {
        return view('pages.transfer.transfer_status');
    }

    public function transaction_invoice(Request $request)
    {
        // return $request;
        $batch_no = $request->batch_no;

        $base_response = new BaseResponse();

        try {


            // return \config('base_urls.api_base_url') . "user/requestOTP";

            $url = \config('base_urls.cib_base_url');


            // $url = \config('bulk_url.url');
            // return $url;
            // dd(\config('base_urls.cib_api_base_url'. "corporate/getBulkUploadData/$batch_no");
            // dd(\config("base_urls.api_base_url");
            // dd(\config('base_urls.cib_base_url') . "get-transaction-invoice/$batch_no");
            $response = Http::get($url . "get-transaction-invoice/$batch_no");

            // return $response;

            $result = new ApiBaseResponse();


            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            // return $result->api_response($response);

            return $base_response->api_response('500', "Internal Server Error",  (string) $e->getMessage()); // return API BASERESPONSE


        }
    }
}
