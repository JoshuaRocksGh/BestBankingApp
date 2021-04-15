<?php

namespace App\Http\classes\WEB;

use App\Http\classes\API\BaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApiBaseResponse
{
    public static function api_response($response)
    {

        $base_response = new BaseResponse();

    if($response->ok()){    // API response status code is 200

        $result = json_decode($response->body());
        // return $result->responseCode;


        if($result->responseCode == '000'){

            return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

        }else{   // API responseCode is not 000

            return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            }

        } else { // API response status code not 200

             return $response->body();
             DB::table('error_logs')->insert([
                 'platform' => 'ONLINE_INTERNET_BANKING',
                 'user_id' => 'AUTH',
                 'code' => $response->status(),
                 'message' => $response->body()
             ]);

            return $base_response->api_response('500', 'API SERVER ERROR',  NULL); // return API BASERESPONSE

        }
    }
}
