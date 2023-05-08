<?php

namespace App\Http\classes\WEB;

use App\Http\classes\API\BaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApiBaseResponse
{
    public static function api_response($response)
    {

        $api_response = new BaseResponse();

        if ($response->ok()) {    // API response status code is 200

            // return $response->body();
            $result = json_decode($response->body());
            // return $result->message;


            if ($result->responseCode == '000') {

                return response()->json([
                    'responseCode' => $result->responseCode,
                    'message' => $result->message,
                    'summary' => $result->summary?? "",
                    'data' => $result->data
                ], 200);

                // return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            } else {   // API responseCode is not 000

                return response()->json([
                    'responseCode' => $result->responseCode,
                    'message' => $result->message,
                    'data' => $result->data
                ], 200);

                // return $base_response->api_response($result->responseCode, $result->message,  $result->data); // return API BASERESPONSE

            }
        } else { // API response status code not 200

            // return $response->body();
            DB::table('tb_error_logs')->insert([
                'platform' => 'ONLINE_INTERNET_BANKING',
                'user_id' => 'AUTH',
                'code' => $response->status(),
                'message' => (string) $response->body()
            ]);

            return response()->json([
                'responseCode' => '500',
                'message' => 'API SERVER ERROR',
                'data' => null
            ], 500);
        }
    }
}
