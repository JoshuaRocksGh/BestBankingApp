<?php

namespace App\Http\Controllers\AccountEnquiry;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AccountEnquiryController extends Controller
{
    //method to return the account enquiry screen
    public function account_enquiry(Request $request)
    {

        return view('pages.accountEnquiry.accountEnquiry', [
            'accountNumber' => $request->query('ac')
        ]);
    }

    public function my_accounts()
    {
        return view('pages.accountEnquiry.myAccounts');
    }

    public function list_of_accounts()
    {
        return view('pages.accountEnquiry.listOfAccounts');
    }

    public function accounts_statement()
    {
        return view('pages.accountEnquiry.accountStatementPrint');
    }

    public function print_account_statement(Request $request)
    {

        return view('pages.accountEnquiry.print_statement', [
            'accountNumber' => $request->query('ac'),
            'startDate' => $request->query('sd'),
            'endDate' => $request->query('ed'),
        ]);
    }

    public function account_transaction_history(Request $request)
    {
        $base_response = new BaseResponse();


        $accountNumber = $request->accountNumber;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $transLimit = $request->transLimit;

        $result = new ApiBaseResponse();

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');


        $data = [
            // "authToken" => $authToken,
            // "userId"    => $userID
            "accountNumber" => $accountNumber,
            "authToken" =>  $authToken,
            "endDate" => $endDate,
            "entrySource" => $entrySource,
            "startDate" => $startDate,
            "transLimit" => $transLimit,
            "channel" => $channel


        ];
        //  return $data;
        // return env('API_BASE_URL') . "account/getTransactions";
        try {
            $response = Http::post(env('API_BASE_URL') . "account/getTransactions", $data);
            // return response()->json($response);

            return $result->api_response($response);
        } catch (\Exception $error) {
            Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }


    // public function print_account_statement_history(Request $request)
    // {
    //     $accountNumber = $request->accountNumber;
    //     $startDate = $request->startDate;
    //     $endDate = $request->endDate;
    //     $transLimit = $request->transLimit;

    //     $result = new ApiBaseResponse();

    //     $authToken = session()->get('userToken');
    //     $userID = session()->get('userId');


    //     $data = [
    //         // "authToken" => $authToken,
    //         // "userId"    => $userID
    //         "accountNumber" => $accountNumber,
    //         "authToken" =>  $authToken,
    //         "endDate" => $endDate,
    //         "entrySource" => "string",
    //         "startDate" => $startDate,
    //         "transLimit" => $transLimit


    //     ];
    //     // return $data;
    //     // return env('API_BASE_URL') . "account/getTransactions";

    //     $response = Http::post(env('API_BASE_URL') . "account/getTransactions", $data);


    //     return $result->api_response($response);
    // }
    public function accountTransDocument(Request $res)
    {
        $response = Http::post(env('API_BASE_URL') . "/account/transDocuments/" . $res->batchNumber);
        $result = new ApiBaseResponse();
        return $result->api_response($response);
    }


    public function account_balance_info(Request $request)
    {
        $accountNumber = $request->accountNumber;

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        $result = new ApiBaseResponse();

        $data = [
            "authToken" => $authToken,
            "userId" => $accountNumber
        ];


        $response = Http::post(env('API_BASE_URL') . "account/getAccountDescription", $data);


        return $result->api_response($response);
    }

    function transaction_receipt(Request $request)
    {
        // $data = $request->query('data');
        // return $request;

        $debitAccount = $request->query('debitAccount');
        $batchNo = $request->query('batchNo');
        $postingDate = $request->query('postingDate');
        $transNumber = $request->query('transNumber');
        $valueDate = $request->query('valueDate');
        $branch = $request->query('branch');
        $narration = $request->query('narration');
        $amount = $request->query('amount');
        $contraAccount = $request->query('contraAccount');
        $channel = $request->query('channel');


        // return json_decode($request);
        return view('pages.accountEnquiry.transaction_receipt', [
            "debitAccount" => $debitAccount,
            "batchNo" => $batchNo,
            "postingDate" => $postingDate,
            "transNumber" => $transNumber,
            "valueDate" => $valueDate,
            "branch" => $branch,
            "narration" => $narration,
            "amount" => $amount,
            "contraAccount" => $contraAccount,
            "channel" => $channel,
        ]);
    }
}
