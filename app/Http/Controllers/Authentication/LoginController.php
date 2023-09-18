<?php

namespace App\Http\Controllers\Authentication;

use App\Http\classes\API\BaseResponse;
use App\Http\classes\WEB\ApiBaseResponse;
use App\Http\classes\WEB\UserAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Stevebauman\Location\Facades\Location;
use Error;
use hisorange\BrowserDetect\Facade as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {

        // if (session()->get('userToken')) {
        //     return redirect('/home');
        // }

        return view('pages.authentication.login');
    }



    public function loginApi(Request $req)
    {
        // return $req;
        // Get Location
        $res = Http::get('http://ip-api.com/json');
        // return $res;
        $base_response = new BaseResponse();

        $user_id = strtoupper($req->user_id);
        $password = $req->password;
        $deviceType = $req->deviceType;
        $deviceOS = $req->deviceOS;
        $deviceID = $req->deviceID;
        // return $deviceType;
        $data =  [
            "appVersion" => "IB",
            "authToken" => "",
            "brand" => $deviceType,
            "channel" => env('APP_CHANNEL'),
            "country" => $res['country'],
            "entrySource" => env('APP_ENTRYSOURCE'),
            // "deviceId" => Browser::browserName(),
            "deviceName" => $deviceType,
            "deviceId" => $deviceID,
            "deviceIp" => request()->ip(),
            "deviceOs" => "I",
            "manufacturer" => $deviceOS,
            "model" => Browser::browserName(),
            "password" => $password,
            "phoneNumber" => "",
            "userId" => $user_id,
            "userName" => ""

        ];
        // return $data;
        // return \config('base_urls.api_base_url') ;
        // return env('API_BASE_URL') . "user/login";

        try {
            $response = Http::post(env('API_BASE_URL') . "user/login", $data);
            // return $response;
            if (!$response->ok()) { // API response status code is 200
                return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE
            }
            $result = json_decode($response->body());
            // return $result;

            if ($result->responseCode !== '000') {
                return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE
            } // API responseCode is 000
            $userDetail = $result->data;
            // return response()->json($userDetail->accountsList[0]->accountDesc);
            // return response()->json($userDetail);
            if (!config("app.corporate") && $userDetail->customerType === 'C') {
                return  $base_response->api_response('900', 'Corporate account, use Corporate Internet Banking platform',  NULL);
            } elseif (config("app.corporate") && $userDetail->customerType !== 'C') {
                return  $base_response->api_response('900', 'Personal account, use Personal Internet Banking platform',  NULL);
            }

            // return $userDetail->customerType;
            // dd(env('CIB_API_BASE_URL') . "get-mandate/$user_id");
            // $mandateRes = Http::post(env('CIB_API_BASE_URL') . "get-mandate/$user_id");
            // return env('CIB_API_BASE_URL') . "get-mandate/$user_id";

            if ($userDetail->customerType == "C") {

                $mandateRes = Http::post(env('CIB_API_BASE_URL') . "get-mandate/$user_id");
                if ($mandateRes['responseCode'] == "000") {
                    // return $mandateRes['data'][0]['panel'];
                    // return $mandateRes;
                    $userMandate = $mandateRes['data'][0]['panel'];
                    // $userMandate = "A";
                } else {
                    $userMandate = null;
                }
            } else {
                $userMandate = "";
            }



            // return $userMandate;
            session([
                "userId" => $userDetail->userId ?? "",
                "userAlias" => $userDetail->userAlias ?? "",
                "setPin" => $userDetail->setPin ?? "",
                "changePassword" => $userDetail->changePassword ?? "",
                "email" => $userDetail->email ?? "",
                "firstTimeLogin" => $userDetail->firstTimeLogin ?? "",
                "userToken" => $userDetail->userToken ?? "",
                "customerNumber" => $userDetail->customerNumber ?? "",
                "customerPhone" => $userDetail->customerPhone ?? "",
                "lastLogin" => $userDetail->lastLogin ?? "",
                "customerType" => $userDetail->customerType ?? "",
                "checkerMaker" => $userDetail->checkerMaker ?? "",
                "accountDescription" => $userDetail->accountsList[0]->accountDesc ?? "",
                "customerAccounts" => $userDetail->accountsList ?? "",
                "customerLoans" => $userDetail->loansList ?? "",
                "customerInvestments" => $userDetail->investmentList ?? "",
                // "userMandate" => 'A',
                "userMandate" => $userMandate ?? "",

                "deviceInfo" => [
                    "appVersion" => "Web",
                    "deviceBrand" => $deviceType ?? "",
                    "deviceCountry" =>  $res['country'] ?? "",
                    "deviceId" => $deviceID ?? "",
                    "deviceIp" => request()->ip() ?? "",
                    "deviceManufacturer" => $deviceOS ?? "",
                    "deviceModel" => Browser::browserName(),
                    "deviceOs" =>  $deviceOS ?? "",
                ],
                "headers" => [
                    "x-api-key" => "123",
                    "x-api-secret" => "123",
                    "x-api-source" => "123",
                    "x-api-token" => "123"
                ],
                // "investment" => $userInvestment,

            ]);

            // return response()->json([
            //     'responseCode' => '000',
            //     'data' => session()->get('customerAccounts'),
            //     'message' => NULL

            // ]);

            // return session()->get('userMandate');

            return  $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE
        } catch (\Exception $error) {
            Log::alert($error);
            return $base_response->api_response('500', 'Cannot Contact API ... Check Your Connection',  NULL); // return API BASERESPONSE

        }
    }

    //     } catch (\Exception $e) {
    //         return $base_response->api_response('500', 'Error: Failed To Contact Server',  NULL); // return API BASERESPONSE



    //     }
    // }

    public function forgot_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'security_answer' => 'required',
            'password' => 'required',
            'security_question' => 'required',
            'user_id' => 'required'
        ]);

        // return $request;

        $base_response = new BaseResponse();

        // VALIDATION
        if ($validator->fails()) {

            return $base_response->api_response('500', $validator->errors(), NULL);
        };

        // $authToken = session()->get('userToken');
        // $userID = session()->get('userId');
        $client_ip = request()->ip();

        $data = [
            "deviceBrand" => null,
            "deviceCountry" => null,
            "deviceId" => "I",
            "deviceIp" => $client_ip,
            "newPassword" => $request->password,
            "securityAnswer" => $request->security_answer,
            "securityQuestion" => $request->security_question,
            "userId" => $request->user_id
        ];

        // return $data;

        try {

            $response = Http::post(env('API_BASE_URL') . "user/forgotPassword", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
            // return json_decode($response->body();

        } catch (\Exception $e) {

            // DB::table('tb_error_logs')->insert([
            //     'platform' => 'ONLINE_INTERNET_BANKING',
            //     'user_id' => 'AUTH',
            //     'message' => (string) $e->getMessage()
            // ]);

            return $base_response->api_response('500', $e->getMessage(),  NULL); // return API BASERESPONSE


        }
    }

    public function get_otp(Request $request)
    {
        // return $request;
        $res = Http::get('http://ip-api.com/json');
        $base_response = new BaseResponse();

        $user_id = strtoupper($request->user_id);
        $deviceType = $request->deviceType;
        $deviceOS = $request->deviceOS;
        $deviceID = $request->deviceID;
        $transType = $request->transType;
        $authToken = session()->get('userToken');
        $userAlias = session()->get('userAlias');
        $customerNumber = session()->get('customerNumber');
        $customerPhone = session()->get('customerPhone');
        if ($request->userID) {
            $userId = $request->userID;
        } else {
            $userId = session()->get('userId');
        }

        $channel = \config('otp.channel');
        $entry_source = \config('otp.entry_source');


        // return $deviceType;
        $data =  [
            // "appVersion" => env('APP_CHANNEL'),
            "authToken" => $authToken,
            "brand" => $deviceType,
            "channel" => $channel,
            "country" => $res['country'],
            "customerName" => $userAlias,
            "customerNumber" => $customerNumber,
            "deviceId" => $deviceID,
            "deviceIp" => request()->ip(),
            "entrySource" => $entry_source,
            "deviceOs" => "A",
            "name" => $deviceOS,
            "otp" => "",
            "phoneNumber" => $customerPhone,
            "transType" => $transType,
            "userName" => $userId

        ];

        // return $data;
        // return \config('base_urls.api_base_url') . "user/requestOTP";

        try {
            // $response = Http::post(env('API_BASE_URL') . "user/requestOTP", $data);
            $response = Http::post(\config('base_urls.api_base_url') . "user/requestOTP", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {

            return $base_response->api_response('500', 'Cannot Contact API ... Check Your Connection',  $error->getMessage()); // return API BASERESPONSE
        }
    }

    public function verify_otp(Request $request)
    {
        // return $request;
        $res = Http::get('http://ip-api.com/json');
        $base_response = new BaseResponse();

        $user_id = strtoupper($request->user_id);
        $deviceType = $request->deviceType;
        $deviceOS = $request->deviceOS;
        $deviceID = $request->deviceID;
        $transType = $request->transType;
        $otp = $request->otp;
        $authToken = session()->get('userToken');
        $userAlias = session()->get('userAlias');
        $customerNumber = session()->get('customerNumber');
        $customerPhone = session()->get('customerPhone');
        if ($request->userID) {
            $userId = $request->userID;
        } else {
            $userId = session()->get('userId');
        }
        // $userId = session()->get('userId');

        $channel = \config('otp.channel');
        $entry_source = \config('otp.entry_source');


        // return $deviceType;
        $data =  [
            // "appVersion" => env('APP_CHANNEL'),
            "authToken" => $authToken,
            "brand" => $deviceType,
            "channel" => $channel,
            "country" => $res['country'],
            "customerName" => $userAlias,
            "customerNumber" => $customerNumber,
            "deviceId" => $deviceID,
            "deviceIp" => request()->ip(),
            "entrySource" => $entry_source,
            "deviceOs" => "A",
            "name" => $deviceOS,
            "otp" => $otp,
            "phoneNumber" => $customerPhone,
            "transType" => $transType,
            "userName" => $userId

        ];

        // return $data;

        try {
            $response = Http::post(\config('base_urls.api_base_url') . "user/validateOTP", $data);

            $result = new ApiBaseResponse();
            return $result->api_response($response);
        } catch (\Exception $error) {

            return $base_response->api_response('500', 'Cannot Contact API ... Check Your Connection',  $error->getMessage()); // return API BASERESPONSE
        }
    }
}