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
        $base_response = new BaseResponse();

        $user_id = strtoupper($req->user_id);
        $password = $req->password;
        $deviceType = $req->deviceType;
        $deviceOS = $req->deviceOS;
        $deviceID = $req->deviceID;
        // return $deviceType;
        $data =  [
            "appVersion" => env('APP_CHANNEL'),
            // "brand" => Browser::deviceFamily(),
            "brand" => $deviceType,
            "country" => $res['country'],
            // "deviceId" => Browser::browserName(),
            // "deviceId" => Browser::browserName(),
            "deviceId" => $deviceID,
            "deviceIp" => request()->ip(),
            "deviceOs" => "A",
            "manufacturer" => $deviceOS,
            "model" => Browser::browserName(),
            "password" => $password,
            "userId" => $user_id,
            "channel" => env('APP_CHANNEL')

        ];
        // return $data;

        try {
            $response = Http::post(env('API_BASE_URL') . "/user/login", $data);
            return $response;
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

            if ($userDetail->customerType == "C") {
                $mandateRes = Http::post(env('CIB_API_BASE_URL') . "get-mandate/$user_id");
                // return $mandateRes['data'][0]['panel'];
                // return $mandateRes['data'][0]['panel'];
                $userMandate = $mandateRes['data'][0]['panel'];
                // $userMandate = "A";
            } else {
                $userMandate = "";
            }


            // dd(env('API_BASE_URL') . "account/accountFD/$userDetail->customerNumber");
            // $investmentResponse = Http::get(env('API_BASE_URL') . "account/accountFD/$userDetail->customerNumber");
            // $userInvestment = $base_response->api_response($investmentResponse->responseCode, $investmentResponse->message,  $investmentResponse->data);
            // return $userInvestment;

            // dd(env('API_BASE_URL') . "loans/getLoans", $userDetail->userTokens);
            // $loanResponse = Http::post(env('API_BASE_URL') . "loans/getLoans", $userDetail->userToken);
            // dd(env('API_BASE_URL') . "loans/getLoans", $userDetail->userToken);
            // return $loanResponse;




            session([
                "userId" => $userDetail->userId,
                "userAlias" => $userDetail->userAlias,
                "setPin" => $userDetail->setPin,
                "changePassword" => $userDetail->changePassword,
                "email" => $userDetail->email,
                "firstTimeLogin" => $userDetail->firstTimeLogin,
                "userToken" => $userDetail->userToken,
                "customerNumber" => $userDetail->customerNumber,
                "customerPhone" => $userDetail->customerPhone,
                "lastLogin" => $userDetail->lastLogin,
                "customerType" => $userDetail->customerType,
                "checkerMaker" => $userDetail->checkerMaker,
                "accountDescription" => $userDetail->accountsList[0]->accountDesc,
                "customerAccounts" => $userDetail->accountsList,
                "customerLoans" => $userDetail->loansList,
                // "userMandate" => 'A',
                "userMandate" => $userMandate,

                "deviceInfo" => [
                    "appVersion" => "Web",
                    "deviceBrand" => $deviceType,
                    "deviceCountry" =>  $res['country'],
                    "deviceId" => $deviceID,
                    "deviceIp" => request()->ip(),
                    "deviceManufacturer" => $deviceOS,
                    "deviceModel" => Browser::browserName(),
                    "deviceOs" =>  $deviceOS,
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
}
