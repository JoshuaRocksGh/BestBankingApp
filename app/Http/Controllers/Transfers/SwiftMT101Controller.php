<?php

namespace App\Http\Controllers\Transfers;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SwiftMT101Controller extends Controller
{
    //
    public function view_swift(Request $request)
    {

        // dd('pages.transfer.swift_mt101');
        // return view('pages.transfer.swift_mt101');
        $base_response = new BaseResponse();
        $customerNumber = session()->get('customerNumber');
        // return view('pages.transfer.swift_mt101', ['customerNumber' => $customerNumber]);
        // return view('pages.transfer.swift_mt101', ['batchNumber' => $batchNumber]);


        // path = storage/app/public
        $directory = "storage/app/";

        // GETS FILE NAME
        $files = Storage::disk('local')->allFiles('public');
        // $files = Storage::allfiles($directory);
        // return $files;

        // return $getBatchNo;


        try {

            $getBatchNo = Http::get(env('CIB_API_BASE_URL') . "get-batch-number");

            $batchNumber =  $getBatchNo['data'][0]['get_batchno'];
            // return $batchNumber;

            foreach ($files as $file) {


                // $path = storage_path() . "/json/${filename}.json";

                // $json = $file->getRealPath();

                // $get_contents = File::fread((storage_path($file), filesize($file)));
                // $handle = fopen($path, 'r');
                $content = Storage::get($file);
                $new_content = str_replace(' ', "\n", $content);
                $slice = preg_split("/\\r\\n|\\r|\\n/", $content);


                // return $content;
                // dd($content);
                // $file_Content = Storage::getfile_get_contents($file, false);
                // $content = Storage::get($file);
                $data = [
                    "batchNumber" => $batchNumber,
                    "customerNumber" => $customerNumber,
                    "fileTxt" => $content,
                ];
                // return $data;
                $slice = preg_split("/\\r\\n|\\r|\\n/", $content);
                $new_content = str_replace(' ', "\n", $content);
                // return $new_content;
                // dd(env('BASE_URL') . "swift/mt101/toJson");

                $response = Http::post(env('BASE_URL') . "swift/mt101/toJson", $data);
                // $response = Http::post("http://192.168.1.225:8680/swift/mt101/toJson", $data);
                // return $response;

                // if ($response['code'] == '000') {
                //     // MOVE SUUCESSFULE FILE READ TO ANOTEHR FOLDER
                //     Storage::move($file, 'swift/' . $file);
                // } else {
                //     Alert::error('error', 'Please Upload Files');
                //     return back();
                // }
            }

            // return $batchNumber;



            $getFileDetails = Http::post(env('CIB_API_BASE_URL') . "swift-file-details/$batchNumber");
            // return $getFileDetails;

            if ($getFileDetails['responseCode'] == '000') {
                $swiftData = $getFileDetails['data'];
                return view('pages.transfer.swift_mt101', ['swiftData' => $swiftData]);

                return $swiftData;
            } else {
                Alert::error('error', 'Please Upload Files');
                return back();
            }




            // $get_contents = File::get(storage_path);
        } catch (\Exception $error) {
            // Log::alert($error);
            return $base_response->api_response('500', $error,  NULL); // return API BASERESPONSE
        }
    }

    public function upload_mt101(Request $request)
    {
        // return response()->json([
        //     "responseCode" => "502",
        //     "message" => "file upload status",
        //     "data" => $request->all()
        // ]);
        $base_response = new BaseResponse();


        $validator = Validator::make($request->all(), [
            // 'excel_file' => 'required|mimes:xls,xlsx',
            'excel_file' => 'required|mimes:txt',
            'my_account' => 'required',
            // 'bulk_amount' => 'required',
            // 'reference_no' => 'required',
            // 'value_date' => 'required',
        ]);

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        $user_id = session()->get('userId');
        $customer_no = session()->get('customerNumber');
        $user_name = session()->get('userAlias');
        // $accountMandate = session()->get('')

        $documentRef = time();
        $file_upload = $request->excel_file;
        $account_no = $request->my_account;


        $getAccountDetails = explode("~", $account_no);
        $accountName = $getAccountDetails[1];
        $accountNumber = $getAccountDetails[2];
        $accountCurrency = $getAccountDetails[3];
        $accountCurrencyIsoCode = $getAccountDetails[5];
        $accountMandate = $getAccountDetails[6];

        $upload_file_excel = $request->file_name;

        $data = [
            'accountName' => $accountName,
            'accountNumber' => $accountNumber,
            'accountCurrency' => $accountCurrency,
            'accountCurrencyIsoCode' => $accountCurrencyIsoCode,
            'accountMandate' => $accountMandate,
            'userId' => $user_id,
            'customerNumber' => $customer_no,
            'postedBy' => $user_id,
            'userName' => $user_name
        ];

        try {

            $filename = $request->excel_file->getClientOriginalName();
            $path  =  $request->file('excel_file')->getPathName();

            $response = Http::attach(
                'file',
                file_get_contents($path),
                $filename
            )->post(env('CIB_API_BASE_URL') . "upload-mt101", $data);
            // return $response;
            // dd($response);



            $result = new ApiBaseResponse();

            return $result->api_response($response);
        } catch (Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE
        }
    }

    public function submit_swift_for_approval(Request $request)
    {

        $base_response = new BaseResponse();
        $userID = session()->get('userId');
        $userAlias = session()->get('userAlias');
        $batchNo = $request->data[0]['batch_no'];
        $customerNumber = session()->get('customerNumber');
        // $accountMandate = $request->
        // return $batchNo;
        $data = [
            'batchNo' => $batchNo,
            "user_id" => $userID,
            'user_alias' => $userAlias,
            "customer_number" => $customerNumber,
        ];
        // WHEN ITS SUBMITTED FOR APPROVAL, UPDATE FLAG TO P

        try {

            $response = Http::post(env('CIB_API_BASE_URL') . "update-swift-batch", $data);
            // dd($response);
            // return $response;

            $result = new ApiBaseResponse();
            return $result->api_response($response);
            // return json_decode($response->body();

        } catch (\Exception $error) {
            // DB::table('tb_error_logs')->insert([
            //     'platform' => 'ONLINE_INTERNET_BANKING',
            //     'user_id' => 'AUTH',
            //     'message' => (string) $error->getMessage()
            // ]);

            return $base_response->api_response('500', $error->getMessage(),  NULL); // return API BASERESPONSE
        }
    }

    public function get_swift_details(Request $request)
    {

        // return $request;
        $batch_no = $request->batch_no;
        $base_response = new BaseResponse();

        try {


            $url = \config('rutile_swift.url');
            // return $url;
            // dd($url . "corporate/getBulkUploadData/$batch_no");

            $response = Http::post($url . "swift-file-details/$batch_no");


            return json_encode(array('response' => $response));

            // $result = new ApiBaseResponse();

            // return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            // return $result->api_response($response);

            return $base_response->api_response('500', "Internal Server Error",  $e->getMessage()); // return API BASERESPONSE


        }
    }
}