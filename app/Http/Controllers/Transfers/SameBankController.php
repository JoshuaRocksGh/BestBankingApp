<?php

namespace App\Http\Controllers\Transfers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SameBankController extends Controller
{
    //

    public function same_bank()
    {
        return view('pages.transfer.same_bank_');
    }


    public function sameBankTransfer(Request $req)
    {
        // return $req;


        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "amount" => (float) $req->transferAmount,
            "authToken" => $authToken,
            "brand" => $deviceInfo['deviceBrand'],
            "creditAccount" => $req->beneficiaryAccountNumber,
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "currency" => $req->accountCurrency,
            "debitAccount" => $req->accountNumber,
            "deviceId" => $deviceInfo['deviceId'],
            "deviceName" => $deviceInfo['deviceOs'],
            "deviceIp" => $client_ip,
            "entrySource" => $entrySource,
            "expenseType" => $req->transferCategory,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "narration" => $req->transferPurpose,
            "secPin" => $req->secPin,
            "userName" => $userID,
            "beneficiaryEmail" => $req->beneficiaryEmail
        ];

        // return $data;

        try {

            $response = Http::post(env('API_BASE_URL') . "transfers/sameBank", $data);
            $result = new ApiBaseResponse();
            Log::alert($response);
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

    public function corporate_same_bank(Request $request)
    {
        // return $request;
        // if ($request->hasFile('voucher')) {
        //     return 'yes';
        //     die();
        // } else {
        //     return 'no';
        //     die();
        // }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);
        // $test_voucher = file_get_contents($request->voucher);
        // return $test_voucher;
        $base_response = new BaseResponse();
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $customerPhone = session()->get('customerPhone');
        $customerNumber = session()->get('customerNumber');
        $userMandate = session()->get('userMandate');
        // return $request->voucher;
        // $check_voucher =
        if ($request->fileUploaded == "Y") {
            $getInvoice = file_get_contents($request->voucher);
            $transVoucher = base64_encode($getInvoice);
        } else {
            $transVoucher = $request->voucher;
        }
        // $transVoucher = file_get_contents($request->file('voucher')->getRealPath());
        // return $transVoucher;
        // if ($request->hasFile('voucher')) {
        //     return 'yes';
        //     die();
        // } else {
        //     return 'no';
        //     die();
        // }
        // $voucher = explode(",", $transVoucher);
        // $getVoucher = $voucher[1];
        // $imageName = time() . '.' . $request->voucher->extension();
        // $file = base64_decode($request->voucher);

        // $file = $request->photo;

        // return base64_encode($transVoucher);
        $data = [
            "account_no" => $request->accountNumber,
            "account_name" => $request->accountName,
            "authToken" => $authToken,
            "channel" => 'NET',
            "destinationAccountId" => $request->beneficiaryAccountNumber,
            "beneficiary_name" => $request->beneficiaryName,
            "beneficiaryName" => $request->beneficiaryName,
            "currency" => $request->accountCurrency,
            "account_mandate" => $request->accountMandate,
            "amount" => $request->transferAmount,
            "narration" => $request->transferPurpose,
            "postBy" => $userID,
            "transaction_voucher" => $transVoucher,
            "file_uploaded" => $request->fileUploaded,
            "customerTel" => $customerPhone,
            "transBy" => $userAlias,
            "customer_no" => $customerNumber,
            "user_alias" => $userAlias,
            "user_mandate" => $userMandate,
            "expense_type" => $request->transferCategory,
            "documentRef" => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 2) . time()),
        ];
        // return round(memory_get_usage() / 1024 / 1024, 2) . ' MB';;
        // echo memory_get_usage();
        // die();
        // return $data;
        try {
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => "http://192.168.1.242/imaging/internet_banking-$request->accountNumber-$request->accountName-$userID",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'GET',
            //     CURLOPT_HTTPHEADER => array(
            //         'Cookie: PHPSESSID=0hnq2mefqjd5uurbv0ec08p814'
            //     ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // return $response;

            // return response()->json([
            //     'responseCode' => '999',
            //     'message' => ' Successful',
            //     'data' => $response
            // ], 200);

            $response = Http::post(env('CIB_API_BASE_URL') . "same-bank-gone-for-pending", $data);
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
}
