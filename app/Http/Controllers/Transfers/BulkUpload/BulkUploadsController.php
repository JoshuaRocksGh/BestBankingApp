<?php

namespace App\Http\Controllers\Transfers\BulkUpload;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\Controllers\Controller;
use App\Imports\ExcelKorporUploadImport;
use App\Imports\ExcelUploadImport;
use App\Imports\Imports\ExcelUploadKorporImport;
use Carbon\Carbon;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use SplFileInfo;


class BulkUploadsController extends Controller
{
    public function index()
    {

        $user_id = session()->get('userId');
        $customer_no = session()->get('customerNumber');
        // return view('pages.transfer.bulkTransfers.new_bulk_transfer');
        // die();
        $base_response = new BaseResponse();


        try {
            // $response = Http::get(env('API_BASE_URL') . "corporate/getBulkUploadDataHist/$user_id/$customer_no");
            // return $response;
            // dd("http://10.1.1.56:8680/ibank/api/v1.0/corporate/getBulkUploadDataHist/$user_id/$customer_no");
            $response = Http::get("http://10.1.1.56:8680/ibank/api/v1.1/corporate/getBulkUploadDataHist/$user_id/$customer_no");
            // return $response['responseCode'];
            // return $response;
            $result = new ApiBaseResponse();
            // Log::alert($response);
            // return $result->api_response($response);
            // return json_decode($response->body();
            $allUploads =   $response['data'] ?? "";
            // return $allUploads;
            if($response['responseCode'] == '000' && $allUploads != ""){
                // return "correct";
                return view('pages.transfer.bulkTransfers.new_bulk_transfer', [
                    "bulkUploads" => $allUploads,
                ]);
            }else{
                // return "incorrect";
                return view('pages.transfer.bulkTransfers.new_bulk_transfer');
            }

        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE
        }
    }

    public function download_same_bank()
    {
        $pathToFile = public_path() . '/assets/images/Same_Bank_Bulk_Transfer_File.xlsx';

        $header = array(
            'Content-Type' => 'application/xlsx'
        );
        return response()->download($pathToFile, 'Same_Bank_Bulk_Transfer_File.xlsx');
    }

    public function download_other_bank()
    {
        $pathToFile = public_path() . '/assets/images/Other_Bank_Bulk_Transfer_File.xlsx';

        $header = array(
            'Content-Type' => 'application/xlsx'
        );
        return response()->download($pathToFile, 'Other_Bank_Bulk_Transfer_File.xlsx');
    }

    // public function download_bulk_korpor()
    // {



    //     $pathToFile = public_path() . '/assets/images/bulk_payment_korpor.xlsx';

    //     $header = array(
    //         'Content-Type' => 'application/xlsx'
    //     );
    //     return response()->download($pathToFile, 'Bulk_Payment_Korpor_File.xlsx');
    // }

    // public function bulk_korpor_download()
    // {
    //     $pathToFile = public_path() . '/assets/images/bulk_payment_korpor.xlsx';

    // $header = array(
    //     'Content-Type' => 'application/xlsx'
    // );

    //     return response()->download($pathToFile, 'Bulk_Payment_Korpor_File.xlsx');
    // }

    public function korpor_file_download()
    {
        $pathToFile = public_path() . '/assets/images/bulk_korpor_payment.xlsx';

        $header = array(
            'Content-Type' => 'application/xlsx'
        );

        return response()->download($pathToFile, 'Bulk_Payment_Korpor_File.xlsx');
    }

    public function upload_file(Request $request)
    {
        $documentRef = time();
        $account_no = $request->account_no;
        $bank_code = $request->bank_type;
        $trans_ref_no = $request->trans_ref_no;
        $total_amount = $request->total_amount;
        $value_date = $request->value_date;

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
            'account_no' => 'required',
            'bank_code' => 'required',
            'trans_ref_no' => 'required',
            'total_amount' => 'required',
            'value_date' => 'required',
        ]);

        $path = $request->file('select_file')->getRealPath();

        $file = $request->file('select_file');
        $ext = $file->getClientOriginalExtension();
        $name = strtoupper($documentRef) . '~' . strtoupper($trans_ref_no) . '~' . strtoupper($total_amount) . '.' . $ext;

        $post_date = Carbon::now();
        $post_date = $post_date->toDateTimeString();

        $pathToFile = public_path() . '/assets/images/bulk_payment_other_bank.xlsx';

        $header = array(
            'Content-Type' => 'application/xlsx'
        );
        return response()->download($pathToFile, 'Bulk_Payment_Other_bank_File.xlsx');
    }

    public function update_upload(Request $request)
    {
        // return $request;

        $validator = Validator::make($request->all(), [
            'recordID' => 'required',
            'name' => 'required',
            'accountNumber' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'bank' => 'required',
            'reference' => 'required',
            'batch' => 'required',
        ]);

        if ($validator->fails()) {

            // return $base_response->api_response('500', $validator->errors(), NULL);
            return $validator->errors();
        };

        $base_response = new BaseResponse();


        $api_headers = session()->get('headers');

        $recordID = $request->recordID;
        $name = $request->name;
        $accountNumber = $request->accountNumber;
        $description = $request->description;
        $amount = $request->amount;
        $bank = $request->bank;
        $reference = $request->reference;
        $batch = $request->batch;

        $data = [
            "accountNumber" => $accountNumber,
            "amount" => $amount,
            "bank" => $bank,
            "name" => $name,
            "recordId" => $recordID,
            "refNumber" => $reference,
            "transDecription" => $description,
            "uploadBatch" => $batch
        ];

        // return $data;


        try {

            $response = Http::withHeaders($api_headers)->post(env('API_BASE_URL') . "corporate/updateFileRecord", $data);

            $result = new ApiBaseResponse();
            // Log::alert($response);
            return $result->api_response($response);



            // $result = new ApiBaseResponse();

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


    public function upload_(Request $request)
    {

        // return response()->json([
        //     "responseCode" => "502",
        //     "message" => "file upload status",
        //     "data" => $request->all()
        // ]);

        // return $request->excel_file;

        // return $request;

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xls,xlsx',
            'my_account' => 'required',
            'bulk_amount' => 'required',
            'reference_no' => 'required',
            'value_date' => 'required',
        ]);

        $base_response = new BaseResponse();

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };




        $user_id = session()->get('userId');
        $customer_no = session()->get('customerNumber');
        $user_name = session()->get('userAlias');

        $documentRef = time();
        $batch_no = $documentRef;
        $account_no = $request->my_account;
        $bank_code = $request->bank_type;
        $trans_ref_no = strtoupper($request->reference_no);
        $total_amount = $request->bulk_amount;
        $value_date = $request->value_date;
        $file_upload = $request->excel_file;

        // return response()->json([
        //     "responseCode" => "502",
        //     "message" => "file type",
        //     "data" => $file_upload
        // ]);

        // return $file_upload;



        // return $account_no;
        $account_info = explode("~", $account_no);
        $account_no = $account_info[2];
        $account_name = $account_info[1];
        $currency = $account_info[3];

        $account_mandate = $account_info[6];
        // return $account_info;

        $upload_file_excel = $request->file_name;

        // Validate reference number in excel before upload //

        if ($request->invoiceFileUploaded == "Y") {
            $getInvoice = file_get_contents($request->voucher);
            $transVoucher = base64_encode($getInvoice);
            session([
                'transVoucher' => $transVoucher,
                'fileUploaded' => 'Y'
            ]);
        } else {
            $transVoucher = $request->voucher;
            session([
                'transVoucher' => '',
                'fileUploaded' => ''
            ]);
        }

        $data = [
            'debitAccount' => $account_no,
            // 'bankType' => $bank_code,
            'bulkAmount' => $total_amount,
            'referenceNumber' => $trans_ref_no,
            'valueDate' => $value_date,
            'customerNumber' => $customer_no,
            'userId' => $user_id
        ];

        // return $data;

        try {

            $filename = $request->excel_file->getClientOriginalName();
            $path  =  $request->file('excel_file')->getPathName();


            $response = Http::attach(
                'file',
                file_get_contents($path),
                $filename
            )->post("http://10.1.1.56:8680/ibank/api/v1.1/corporate/uploadBulkNew", $data);

            // post(env('API_BASE_URL') . "corporate/uploadBulkNew", $data);

            // return $response;
            // dd($response);



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

        die();

        //
        if ($file_upload) {

            $path = $request->file('excel_file')->getRealPath();


            $file = $request->file('excel_file');
            $ext = $file->getClientOriginalExtension();
            $name = strtoupper($documentRef) . '~' . strtoupper($trans_ref_no) . '~' . strtoupper($total_amount) . '.' . $ext;


            $post_date = Carbon::now();
            $post_date = $post_date->toDateTimeString();


            Excel::import(new ExcelUploadImport($customer_no, $user_id, $user_name, $documentRef, $account_no, $bank_code, $trans_ref_no, $total_amount, $currency, $value_date, $file, $account_mandate), $file);

            $query_upload = DB::table('tb_corp_bank_import_excel')
                ->where('customer_no', $customer_no)
                ->get();

            return response()->json([
                "responseCode" => "756",
                "message" => "Error Occured",
                "data" => $query_upload
            ]);
        } else {
            return false;
        }

        //


        if ($request->file()) {

            $path = $request->file('excel_file')->getRealPath();
            // return $path;

            $file = $request->file('excel_file');
            $ext = $file->getClientOriginalExtension();
            $name = strtoupper($documentRef) . '~' . strtoupper($trans_ref_no) . '~' . strtoupper($total_amount) . '.' . $ext;

            // return $name;
            $post_date = Carbon::now();
            $post_date = $post_date->toDateTimeString();

            $query_result_delete = DB::table('tb_corp_bank_import_excel')
                ->where('customer_no', $customer_no)
                ->get();


            $error_insert_delete = DB::table('tb_bulk_error_logs')
                ->where('customer_no', $customer_no)
                ->get();

            $query_result_delete_1 = DB::table('TB_CORP_BANK_BULK_REF')
                ->where('customer_no', $customer_no)
                ->get();
            if (
                json_decode($query_result_delete)  != null || json_decode($error_insert_delete)  != null ||
                json_decode($query_result_delete_1) != null
            ) {
                return response()->json([
                    "responseCode" => "546",
                    "message" => "File Pending Upload Found. Upload or Delete to continue",
                    "data" => []
                ]);
                // Alert::error('', 'Pending Upload Found');
                // return back()->withErrors(['File Pending Upload Found. Upload or Delete to continue', 'The Message']);
            }

            // die();

            // $response = Http::get(env('API_BASE_URL') . "account/accBalance/$account_no");
            // echo json_encode(env('API_BASE_URL') . "account/accBalance/" . $account_no);

            // die();

            Excel::import(new ExcelUploadImport($customer_no, $user_id, $user_name, $documentRef, $account_no, $bank_code, $trans_ref_no, $total_amount, $currency, $value_date, $file, $account_mandate), $file);


            // $excel_result = DB::table('tb_bulk_error_logs')
            //     ->where('batch_no', $batch_no)
            //     ->where('customer_no', $customer_no)
            //     ->get();


            // $result = DB::table('tb_corp_bank_import_excel')
            //     ->where('batch_no', $batch_no)
            //     ->where('customer_no', $customer_no)
            //     ->select('BBAN', 'NAME', 'AMOUNT', 'TRANS_DESC')
            //     ->get();


            // $excel_data = DB::table('tb_corp_bank_import_excel')
            //     ->where('batch_no', $batch_no)
            //     ->where('customer_no', $customer_no)
            //     ->get();



            // foreach ($result as $account) {

            //     if (strlen($account->BBAN) != 18 || substr($account->BBAN, 0, 3) != '004') {

            //         return view('pages.transfer.bulkTransfers.view_bulk_error_transfer', ['account' => $account]);
            //         Alert::error("Error Uploading Bulk Transfer");
            //         return redirect()->route('view-error-bulk-transfer', [
            //             'batch_no' => $batch_no,
            //             'bulk_amount' => $total_amount,
            //             'bank_type' => $bank_code,
            //             'bank_type' => $bank_code
            //         ]);
            //     }
            // }

            // Alert::success("Bulk Upload Successful");
            // return view('pages.transfer.bulkTransfers.bulk_trasnfer');
            return response()->json([
                "responseCode" => "000",
                "message" => "File Uploaded Successfully",
                "data" => []
            ]);
        } else {
            return false;
        }
    }

    public function get_bulk_upload_list(Request $request)
    {

        // dd($request);

        $fileBatch = $request->query("fileBatch");
        $customerNumber = session()->get('customerNumber');

        $base_response = new BaseResponse();


        // return $fileBatch;
        // dd('http://192.168.1.225:9096/corporate/getBulkUploadFilesDetails?' . "customerNumber=$customerNumber&batchNumber=$fileBatch");


        try {
            $response = Http::get(env('API_BASE_URL') . "corporate/getBulkUploadData/$fileBatch");
            $result = new ApiBaseResponse();
            // dd($response);
            return $result->api_response($response);
        } catch (\Exception $e) {

            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);
            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE

        }
        die();


        // $query = DB::connection('oracle')->table('bulk_temp_excel')->get();
    }

    public function get_bulk_korpor_upload_list(Request $request)
    {
        // return $request;
        $customerNumber = $request->query("customer_no");
        // return $customerNumber;

        $files = DB::table('tb_corp_korpor_import_excel')
            ->distinct()
            ->where('customer_no', $customerNumber)
            ->where('status', 'P')
            ->orderBy('batch_no', 'desc')
            ->get(['batch_no', 'account_no', 'bank_code', 'status', 'ref_no', 'total_amount', 'value_date']);

        return [
            'responseCode' => '000',
            'message' => "Available Uploads",
            'data' => $files
        ];
    }

    public function get_bulk_korpor_upload_file_details(Request $request)
    {
        $customerNumber = $request->query("customer_no");
        // return $customer_no;

        $files = DB::table('tb_corp_korpor_import_excel')
            ->distinct()
            ->where('customer_no', $customerNumber)
            ->where('status', 'P')
            ->orderBy('batch_no', 'desc')
            ->get(['batch_no', 'account_no', 'bank_code', 'status', 'ref_no', 'total_amount', 'value_date']);

        return [
            'responseCode' => '000',
            'message' => "Available Uploads",
            'data' => $files
        ];
    }


    public function view_bulk_transfer(Request $request)
    {
        // return $request;

        $fileBatch = $request->query('batch_no');
        // $account_no = $request->query('account_no');
        // $bank_type = $request->query('bank_type');

        $customer_no = session()->get('customerNumber');

        try {
            $response = Http::retry(20, 100)->get(env('API_BASE_URL') . "corporate/getBulkUploadData/$fileBatch");
            // return json_decode($response);
            // $result = new ApiBaseResponse();

            // dd($response['data']);
            $uploadData = $response['data']['uploadData'];
            $uploadDetails = $response['data']['uploadDetails'];
            return view('pages.transfer.bulkTransfers.view_bulk_trasnfer', [
                'uploadData' => $uploadData,
                'uploadDetails' => $uploadDetails,
                'batch_no' => $fileBatch,
                // 'userID' => $userID


            ]);
        } catch (\Exception $e) {
            Alert::error("Bulk Transfer Detail Not Found");
            // return view('pages.transfer.bulkTransfers.bulk_trasnfer');
            return view('pages.transfer.bulkTransfers.new_bulk_transfer');
        }
    }

    public function delete_bulk_transfer(Request $request)
    {
        $fileBatch = $request->query('batch_no');
        $base_response = new BaseResponse();

        // return $fileBatch;

        try {
            $response = Http::delete(env('API_BASE_URL') . "corporate/deleteFileRecord/$fileBatch");
            $result = new ApiBaseResponse();
            Alert::success('', 'Record Deleted Successfully');
            return back();
            // return $result->api_response($response);
        } catch (\Exception $e) {
            Alert::error('', 'Failed To Delete Record');
            return back();
            // return $base_response->api_response($result->responseCode, $result->message,  NULL);
        }
    }

    public function delete_bulk_upload_file(Request $request)
    {
        $fileBatch = $request->query('batch_no');
        $base_response = new BaseResponse();

        // return $fileBatch;

        try {
            $response = Http::delete(env('API_BASE_URL') . "corporate/deleteFileRecord/$fileBatch");
            $result = new ApiBaseResponse();
            // Alert::success('', 'Record Deleted Successfully');
            // return back();
            return $result->api_response($response);
        } catch (\Exception $e) {
            // Alert::error('', 'Failed To Delete Record');
            // return back();
            return $base_response->api_response($result->responseCode, $result->message,  NULL);
        }
    }

    public function view_bulk_transfer_korpor(Request $request)
    {
        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        $bank_type = $request->query('bank_type');

        $customer_no = session()->get('customerNumber');

        // if (null !== ($request->query('batch_no') || $request->query('account_no') || $request->query('bank_type'))) {
        //     return back();
        // }

        $bulk_details = DB::table('tb_corp_bank_import_excel')->where('batch_no', $batch_no)->get();
        $bulk_info = DB::table('TB_CORP_BANK_BULK_REF')->where('batch_no', $batch_no)->first();

        if ($bulk_info == null || $bulk_info == "") {
            Alert::error("Bulk Transfer Detail Not Found");
            return view('pages.payments.korpor.bulk_korpor');
        } else {
            return view('pages.transfer.bulkTransfers.view_bulk_transfer_korpor', [
                'customer_no' => $customer_no,
                'batch_no' => $batch_no,
                'account_no' => $account_no,
                'bank_type' => $bank_type,
            ]);
        }
    }

    public function view_error_bulk_transfer(Request $request)
    {

        // return $request;

        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        $bank_type = $request->query('bank_type');

        $customer_no = session()->get('customerNumber');

        // if (null !== ($request->query('batch_no') || $request->query('account_no') || $request->query('bank_type'))) {
        //     return back();
        // }

        return view('pages.transfer.bulkTransfers.view_bulk_error_transfer', [
            'customer_no' => $customer_no,
            'batch_no' => $batch_no,
            'account_no' => $account_no,
            'bank_type' => $bank_type,
        ]);
    }

    public function bulk_korpor_error_transfer(Request $request)
    {
        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        $bank_type = $request->query('bank_type');

        $customer_no = session()->get('customerNumber');

        return view('pages.payments.korpor.bulk_korpor_error_payment', [
            'customer_no' => $customer_no,
            'batch_no' => $batch_no,
            'account_no' => $account_no,
            'bank_type' => $bank_type,
        ]);
    }

    public function get_bulk_upload_file_details(Request $request)
    {
        // return $request;
        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        $bank_type = $request->query('bank_type');
        $customer_no = $request->query('customer_no');


        $bulk_details = DB::table('tb_corp_bank_import_excel')
            ->distinct()
            ->where('customer_no', $customer_no)
            ->where('batch_no', $batch_no)
            ->orderBy('batch_no', 'desc')
            ->get();

        // return [
        //     'responseCode' => '000',
        //     'message' => "Available Uploads",
        //     'data' => $bulk_details
        // ];
        $bulk_info = DB::table('TB_CORP_BANK_BULK_REF')->where('batch_no', $batch_no)->first();

        // return $bulk_details;
        if ($bulk_info == null || $bulk_info == "") {
            Alert::error("Bulk Transfer Detail Falied");
            return redirect()->route('pages.transfer.bulkTransfers.bulk_trasnfer');
        } else {
            return response()->json([
                'responseCode' => '000',
                'message' => "Detail of upload transfer",
                'data' => [
                    'bulk_info' => $bulk_info,
                    'bulk_details' => $bulk_details
                ]
            ], 200);
        }
    }

    public function get_bulk_korpor_file_details(Request $request)
    {

        // return $request;
        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        $bank_type = $request->query('bank_type');


        $bulk_details = DB::table('tb_corp_korpor_import_excel')->where('batch_no', $batch_no)->get();
        $bulk_info = DB::table('TB_CORP_BANK_BULK_REF')->where('batch_no', $batch_no)->first();


        return response()->json([
            'responseCode' => '000',
            'message' => "Detail of upload transfer",
            'data' => [
                'bulk_info' => $bulk_info,
                'bulk_details' => $bulk_details
            ]
        ], 200);
    }



    public function post_bulk_transaction(Request $request)
    {
        // return $request;

        $fileBatch = $request->query('batch_no');
        $customerAccounts = session()->get('customerAccounts');
        $userID = session()->get('userId');
        $transVoucher = session()->get('transVoucher');
        $fileUploaded = session()->get('fileUploaded');

        $base_response = new BaseResponse();
        // return $customerAccounts;


        try {
            $batch = Http::retry(20, 100)->get(env('API_BASE_URL') . "corporate/getBulkUploadData/$fileBatch");
            // $result = new ApiBaseResponse();
            $bulk_details = $batch['data'];
            $uploadDetails = $bulk_details['uploadDetails'];
            $debit_account = $uploadDetails['debitAccount'];
            // return $debit_account;
            foreach (session()->get('customerAccounts') as $i => $account) {
                if ($account->accountNumber ==  $debit_account) {
                    $accountDetails = $account;
                };
            }

            $transVoucher = session()->get('transVoucher');
            $fileUploaded = session()->get('fileUploaded');

            // return $accountDetails;


            $data = [
                'bulk_details' => $bulk_details,
                'accountDetails' => $accountDetails,
                'userID' => $userID,
                "transaction_voucher" => $transVoucher,
                "file_uploaded" => $fileUploaded,
            ];

            // return $data;
            // dd(env('CIB_API_BASE_URL') . "post-bulk-upload-list");
            $response = Http::post(env('CIB_API_BASE_URL') . "post-bulk-upload-list", $data);
            $result = new ApiBaseResponse();
            return $result->api_response($response);
            // urn $response;
        } catch (\Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);
            return $base_response->api_response('500', "Internal Server Error",  NULL); // return API BASERESPONSE
        }

        die();
    }

    public function post_bulk_korpor_transactions(Request $request)
    {

        // return $request;

        $batch_no = $request->query('batch_no');
        // $batch_no = $request->batch_no;
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');



        $data = DB::table('tb_corp_korpor_import_excel')->where('batch_no', $batch_no)->get()->toArray();



        // return $data;

        // return response()->json([
        //     'responseCode' => '422',
        //     'message' => 'View Korpor Error TO Api',
        //     'data' => $data
        // ], 200);

        // // die();

        /*
        $credit_data = [];
        $debit_data = [];

        foreach ($files as $data) {

            $credit['creditAccount'] = $data->BBAN;
            $credit['creditAmount'] = (float) $data->AMOUNT;
            $credit['creditBranch'] = '001';
            $credit['debitCurrency'] = 'SLL';
            $credit['creditNarration'] =  $data->TRANS_DESC;
            $credit['creditProdRef'] = $data->REF_NO;

            array_push($credit_data, $credit);
        }

        $debit_data['debitAccount'] = $files[0]->ACCOUNT_NO;
        $debit_data['debitAmount'] = (float) $files[0]->TOTAL_AMOUNT;
        $debit_data['debitCurrency'] = 'SLL';
        $debit_data['debitNarration'] = $files[0]->TRANS_DESC;
        $debit_data['debitProdRef'] = $files[0]->REF_NO;

        $data = [
            "approvedBy" => "string",
            "branch" => "string",
            "channelCode" => "string",
            "department" => "rr",
            "postedBy" => "KOBBY",
            "referenceNo" => "string",
            "transType" => "string",
            "unit" => "yyy",
            "debitAccounts" => [$debit_data],
            "creditAccounts" => $credit_data,
        ];

        // return  $data;

        */
        // dd(env('CIB_API_BASE_URL') . "post-bulk-upload-list", $data);
        $response = Http::post(env('CIB_API_BASE_URL') . "post-bulk-korpor-upload-list", $data);
        // return (array) $response;
        // $result = new ApiBaseResponse();
        $base_response = new BaseResponse();

        if ($response->ok()) {    // API response status code is 200

            // return $response->body();
            $result = json_decode($response->body());
            // return $result->responseCode;

            // return $result;


            if ($result->responseCode == '000') {

                $update_db = DB::table('tb_corp_korpor_import_excel')
                    ->where('batch_no', $batch_no)
                    ->update([
                        'status' => 'A'
                    ]);



                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            } else {   // API responseCode is not 000

                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            }
        } else { // API response status code not 200

            return $response->body();
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'code' => $response->status(),
                'message' => $response->body()
            ]);

            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }


    public function reject_bulk_transaction(Request $request)
    {
        // return $request;
        $customer_no = $request->query('customer_no');
        // $batch_no = $request->batch_no;
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        // $result = DB::table('tb_corp_bank_import_excel')->where('batch_no', $batch_no)->update(['status' => 'R']);
        $result = DB::table('tb_corp_bank_import_excel')->where('customer_no', $customer_no)->delete();
        $result_1 = DB::table('tb_bulk_error_logs')->where('customer_no', $customer_no)->delete();
        $result_2 = DB::table('tb_corp_bank_bulk_ref')->where('customer_no', $customer_no)->delete();

        $base_response = new BaseResponse();
        if ($result) {
            return $base_response->api_response('000', 'Upload rejected successfully',  NULL);
        } else {
            return $base_response->api_response('666', 'Failed to reject upload',  NULL);
        }


        // $response = Http::post(env('CIB_API_BASE_URL') . "post-bulk-upload-list", null);

        // $base_response = new BaseResponse();

        // if ($response->ok()) {


        //     $result = json_decode($response->body());



        //     if ($result->responseCode == '000') {

        //         $update_db = DB::table('tb_corp_bank_import_excel')
        //             ->where('batch_no', $batch_no)
        //             ->update([
        //                 'status' => 'A'
        //             ]);

        //         $result = DB::table('tb_corp_bank_import_excel')->where('customer_no', $customer_no)->delete();
        //         $result_1 = DB::table('tb_bulk_error_logs')->where('customer_no', $customer_no)->delete();
        //         $result_2 = DB::table('tb_corp_bank_bulk_ref')->where('customer_no', $customer_no)->delete();

        //         return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

        //     } else {

        //         return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

        //     }
        // } else {

        //     return $response->body();
        //     DB::table('tb_error_logs')->insert([
        //         'platform' => 'ONLINE_INTERNET_BANKING',
        //         'user_id' => 'AUTH',
        //         'code' => $response->status(),
        //         'message' => $response->body()
        //     ]);

        //     return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        // }
    }

    public function bulk_korpor_upload_(Request $request)
    {
        // return $request;

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xls,xlsx',
            'my_account' => 'required',
            'bulk_amount' => 'required',
            'reference_no' => 'required',
            'value_date' => 'required',
        ]);

        $base_response = new BaseResponse();

        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // return $request;

        $user_id = session()->get('userId');
        $customer_no = session()->get('customerNumber');
        $user_name = session()->get('userAlias');

        $documentRef = time();
        $batch_no = $documentRef;
        $account_no = $request->my_account;
        // $bank_code = $request->bank_type;
        $trans_ref_no = $request->reference_no;
        $total_amount = $request->bulk_amount;
        $value_date = $request->value_date;

        // return $account_no;
        $account_info = explode("~", $account_no);
        $account_no = $account_info[2];
        $currency = $account_info[3];

        // return $account_info;

        $account_mandate = $account_info[6];

        if ($request->file()) {

            $path = $request->file('excel_file')->getRealPath();
            // return $path;

            $file = $request->file('excel_file');
            $ext = $file->getClientOriginalExtension();
            $name = strtoupper($documentRef) . '~' . strtoupper($trans_ref_no) . '~' . strtoupper($total_amount) . '.' . $ext;

            $post_date = Carbon::now();
            $post_date = $post_date->toDateTimeString();



            Excel::import(new ExcelKorporUploadImport($customer_no, $user_id, $user_name, $documentRef, $account_no, $trans_ref_no, $total_amount, $currency, $value_date, $file, $account_mandate), $file);
            $results = DB::table('tb_corp_korpor_import_excel')
                ->where('batch_no', $batch_no)
                ->select('NAME', 'MOBILE_NO', 'AMOUNT', 'ADDRESS',)
                ->get();

            // return response()->json($result);
            foreach ($results as $result) {
                if (strlen($result->MOBILE_NO) != 10 || strlen($result->MOBILE_NO) > 10 || $result->NAME == "" || $result->ADDRESS == "") {
                    Alert::error("Error Uploading Bulk Korpor");
                    return redirect()->route('bulk-korpor-error-transfer', [
                        'batch_no' => $batch_no,
                        'bulk_amount' => $total_amount,
                        // 'bank_type' => $bank_code,
                        // 'bank_type' => $bank_code
                    ]);
                }
            }



            // return false;
            Alert::success("Bulk E-Korpor Pending Approval");
            return redirect()->route('view-bulk-korpor-transfer', [
                'batch_no' => $batch_no,
                'bulk_amount' => $total_amount,
                // 'bank_type' => $bank_code,
                // 'bank_type' => $bank_code
            ]);
            // return back()->with('success', 'Bulk transfer pending approval');
            // return $upload;

        } else {
        }
    }

    public function view_bulk_korpor_transfer(Request $request)
    {

        // return $request;
        $batch_no = $request->query('batch_no');
        $account_no = $request->query('account_no');
        // $bank_type = $request->query('bank_type');

        $customer_no = session()->get('customerNumber');

        // if (null !== ($request->query('batch_no') || $request->query('account_no') || $request->query('bank_type'))) {
        //     return back();
        // }

        return view('pages.payments.korpor.view_bulk_korpor', [
            'customer_no' => $customer_no,
            'batch_no' => $batch_no,
            'account_no' => $account_no,
            // 'bank_type' => $bank_type,
        ]);
    }

    public function post_bulk_korpor_transaction(Request $request)
    {

        $batch_no = $request->query('batch_no');
        // $batch_no = $request->batch_no;
        $authToken = session()->get('userToken');
        $userID = session()->get('userId');



        $data = DB::table('tb_corp_bank_import_excel')->where('batch_no', $batch_no)->get()->toArray();



        // return $data;

        // return response()->json([
        //     'responseCode' => '422',
        //     'message' => 'View Error From Api',
        //     'data' => $data
        // ], 200);

        /*
        $credit_data = [];
        $debit_data = [];

        foreach ($files as $data) {

            $credit['creditAccount'] = $data->BBAN;
            $credit['creditAmount'] = (float) $data->AMOUNT;
            $credit['creditBranch'] = '001';
            $credit['debitCurrency'] = 'SLL';
            $credit['creditNarration'] =  $data->TRANS_DESC;
            $credit['creditProdRef'] = $data->REF_NO;

            array_push($credit_data, $credit);
        }

        $debit_data['debitAccount'] = $files[0]->ACCOUNT_NO;
        $debit_data['debitAmount'] = (float) $files[0]->TOTAL_AMOUNT;
        $debit_data['debitCurrency'] = 'SLL';
        $debit_data['debitNarration'] = $files[0]->TRANS_DESC;
        $debit_data['debitProdRef'] = $files[0]->REF_NO;

        $data = [
            "approvedBy" => "string",
            "branch" => "string",
            "channelCode" => "string",
            "department" => "rr",
            "postedBy" => "KOBBY",
            "referenceNo" => "string",
            "transType" => "string",
            "unit" => "yyy",
            "debitAccounts" => [$debit_data],
            "creditAccounts" => $credit_data,
        ];

        // return  $data;

        */
        // dd(env('CIB_API_BASE_URL') . "post-bulk-upload-list");
        $response = Http::post(env('CIB_API_BASE_URL') . "post-bulk-korpor-upload-list", $data);
        // return (array) $response;
        // $result = new ApiBaseResponse();
        $base_response = new BaseResponse();

        if ($response->ok()) {    // API response status code is 200

            // return $response->body();
            $result = json_decode($response->body());
            // return $result->responseCode;

            // return $result;


            if ($result->responseCode == '000') {

                $update_db = DB::table('tb_corp_bank_import_excel')
                    ->where('batch_no', $batch_no)
                    ->update([
                        'status' => 'A'
                    ]);

                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            } else {   // API responseCode is not 000

                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            }
        } else { // API response status code not 200

            return $response->body();
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'code' => $response->status(),
                'message' => $response->body()
            ]);

            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }
}
