<?php

namespace App\Http\Controllers\AccountServices;

use App\Http\classes\API\BaseResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AccountServicesController extends Controller
{
    //method to return activate cheque book screen
    public function activate_cheque_book()
    {
        return view('pages.accountServices.activate_cheque_book');
    }

    //method to return add signature screen
    public function add_signature()
    {
        return view('pages.accountServices.add_signature');
    }

    //method to return cheque book request screen
    // public function cheque_book_request()
    // {
    //     return view('pages.accountServices.chequeBookRequest');
    // }

    //method to return salary advance request screen
    public function salary_advance()
    {

        $authToken = session()->get('userToken');
        $userID = session()->get('userId');

        // $userID = session()->get('userId');

        // $accountDetails = $request->transferAccount;
        $client_ip = request()->ip();
        $api_headers = session()->get('headers');
        $deviceInfo = session()->get('deviceInfo');

        $entrySource = env('APP_ENTRYSOURCE');
        $channel = env('APP_CHANNEL');

        $data = [
            "authToken" => $authToken,
            // 'userId' => $userID
            // "authToken" => "string",
            "brand" => $deviceInfo['deviceBrand'],
            "channel" => $channel,
            "country" => $deviceInfo['deviceCountry'],
            "deviceId" => $deviceInfo['deviceId'],
            "deviceIp" => $client_ip,
            "deviceName" => $deviceInfo['deviceOs'],
            "entrySource" => $entrySource,
            "manufacturer" => $deviceInfo['deviceManufacturer'],
            "phoneNumber" => "",
            "userId" => $userID,
            "userName" => $userID
        ];
        // return $data;

        $response = Http::post(env('API_BASE_URL') . "/account/saladAccount/", $data);
        // $result = json_decode($response);
        // return response()->json($result);
        // return $response;
        // return view('pages.accountServices.salary_advance');

        return view('pages.accountServices.salary_advance', ["result" => $response]);
    }

    //method to return confirm cheque
    public function chequeServices()
    {
        $base_response = new BaseResponse();


        try {

            $branchResponse = Http::get(env('API_BASE_URL') . "utilities/getBranches");
            // return

            // $branches = $branchResponse['data'];
            // return $branches;
            return view('pages.accountServices.chequeServices.cheque_services', ['branches' => $branchResponse]);
        } catch (\Exception $e) {
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'message' => (string) $e->getMessage()
            ]);

            // return back();
            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE

        }
    }

    //method to return fd creation screen
    public function fd_creation()
    {
        return view('pages.accountServices.fd_creation');
    }

    //method to return kyc update screen
    public function kyc_update()
    {
        return view('pages.accountServices.kyc_update');
    }

    //method to return open additional account screen
    public function open_additional_acc()
    {
        return view('pages.accountServices.open_additional_acc');
    }

    //method to return remove signature screen
    public function remove_signature()
    {
        return view('pages.accountServices.remove_signature');
    }

    //method to return request atm screen
    public function request_atm()
    {
        return view('pages.accountServices.request_atm');
    }

    public function block_atm()
    {
        return view('pages.accountServices.block_atm');
    }

    //method to return request draft screen
    public function request_draft()
    {
        return view('pages.accountServices.request_draft');
    }

    //method to return request statement screen
    public function request_statement()
    {
        return view('pages.accountServices.request_statement');
    }

    //method to return stop cheque screen
    public function stop_cheque()
    {
        return view('pages.accountServices.stop_cheque');
    }

    //method to return stop fd screen
    public function stop_fd()
    {
        return view('pages.accountServices.stop_fd');
    }

    //method to return request for a letter screen
    public function requests()
    {
        return view('pages.accountServices.requests.requests');
    }

    //method to return close account screen
    public function close_account()
    {
        return view('pages.accountServices.close_account');
    }

    //method to return make a complaint screen
    public function make_complaint()
    {
        return view('pages.accountServices.make_complaint');
    }
}