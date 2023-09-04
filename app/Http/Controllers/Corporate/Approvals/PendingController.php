<?php

namespace App\Http\Controllers\Corporate\Approvals;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PendingController extends Controller
{
    public function approvals_pending()
    {
        // return $request_id;
        return view('pages.corporate.approvals.pending');
    }


    public function get_approvals_pending()
    {
    }


    public function approvals_pending_transfer_details($request_id, $customer_no)
    {

        $base_response = new BaseResponse();


        $userID = session()->get('userId');
        // $mandate = session()->get('userMandate');

        // return $mandate;
        return view('pages.corporate.approvals.pending_transfer_details', ['request_id' => $request_id, 'customer_no' => $customer_no]);
        die();
        try {
            $response = Http::post(env('CIB_API_BASE_URL') . "check-mandate/$customer_no/$userID");
            // dd(env('CIB_API_BASE_URL') . "check-mandate/$customer_no/$userID");
            $result = json_decode($response);
            // return $response;
            // return $result->responseCode;
            if ($result->responseCode === '000') {
                return view('pages.corporate.approvals.pending_transfer_details', ['request_id' => $request_id, 'customer_no' => $customer_no, 'mandate' => $mandate]);
            } else {
                Alert::error('', $result->message);
                return back();
            }
            // $result = new ApiBaseResponse();
            // return $result->api_response($response);
        } catch (\Exception $e) {
            return $base_response->api_response('500', "Internal Server Error",  $e->getMessage()); // return API BASERESPONSE

        }
        die();


        if ($mandate == "A") {
        } else {
            Alert::error('', 'Not Authorized To Approve Pending Request');
            return back();
        }

        die();
        // $mandate = '2B';
        // $customerAccounts = session()->get('customerAccounts');
        // $accountMandate = $customerAccounts[0]->accountMandate;
        // $getMandate = explode(' ', $accountMandate);


        // if (in_array("AND", $getMandate) || in_array("OR", $getMandate)) {
        //     $firstMandate = $getMandate[0];
        //     $secondMandate = $getMandate[2];

        //     $getSecondMandate =
        //         str_split($secondMandate);
        //     $getfirstMandate = str_split($firstMandate);
        //     $mandateType1 = $getfirstMandate[1];
        //     $mandateType2 = $getSecondMandate[1];

        //     if ($mandate == $mandateType1 || $mandate == $mandateType2) {

        //         return view('pages.corporate.approvals.pending_transfer_details', ['request_id' => $request_id, 'customer_no' => $customer_no, 'mandate' => $mandate]);
        //     } else {
        //         Alert::error('', 'Not Authorized To Approve Pending Request');
        //         return back();
        //     }
        //     // return $getMandate;
        //     // echo json_encode('AND');
        // } else {
        //     $getMandate =
        //         str_split($accountMandate);
        //     $mandateType = $getMandate[1];
        //     if ($mandate == $mandateType) {

        //         return view('pages.corporate.approvals.pending_transfer_details', ['request_id' => $request_id, 'customer_no' => $customer_no, 'mandate' => $mandate]);
        //     } else {
        //         Alert::error('', 'Not Authorized To Approve Pending Request');
        //         return back();
        //     }
        // }

        // if (strpos($accountMandate, 'AND' !== false)) {
        //     return $accountMandate;
        // } else if (strpos($accountMandate, 'OR' !== false)) {
        //     return $accountMandate;
        // } else {
        //     return $accountMandate;
        // }

        // Alert::error('', 'Not Authorized To Approve Pending Request');
        // return back();
        // $error = alert()->error('ErrorAlert','Lorem ipsum dolor sit amet.');

        // return $errorMessage ;


    }


    public function pending_request_details(Request $request)
    {


        // return ('hello');
        $customer_no = $request->query('customer_no');
        $request_id = $request->query('request_id');

        // return $request_id ;



        $base_response = new BaseResponse();

        // if ($validator->fails()) {

        //     return $base_response->api_response('500', $validator->errors(), NULL);
        // };
        // return $request;

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');


        // return $data ;
        try {

            // dd(env('CIB_API_BASE_URL') . "/get-detail-pending-request-api?customer_no=$customer_no&request_id=$request_id");
            $response = Http::get(env('CIB_API_BASE_URL') . "get-detail-pending-request-api?customer_no=$customer_no&request_id=$request_id");

            // return $response;

            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE


        }
    }


    public function get_bulk_detail_list_for_approval(Request $request)
    {

        // return $request;



        $batch_no = $request->batch_no;
        $request_id = $request->query('request_id');

        // return $request_id ;



        $base_response = new BaseResponse();

        // if ($validator->fails()) {

        //     return $base_response->api_response('500', $validator->errors(), NULL);
        // };
        // return $request;

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');


        // return $data ;
        try {


            // $url = \config('bulk_url.url');
            // return $url;
            // dd(env('API_BASE_URL') . "corporate/getBulkUploadData/$batch_no");
            $response = Http::get(env('API_BASE_URL') . "corporate/getBulkUploadData/$batch_no");

            // return $response;

            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $result->api_response($response);

            //return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE


        }
    }
}