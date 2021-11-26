<?php

namespace App\Http\Services\newUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Resp;
use Response;

class responceServices 
{
    protected static $statusCode = Resp::HTTP_OK;
    public static function respondWithSuccess($successCode, $data = null) 
    {
        responceServices::$statusCode = Resp::HTTP_OK;
        return responceServices::respond([
                    'success' => true,
                    'message' => trans('success.'.$successCode),
                    'message_code' => $successCode,
                    'data' => $data
        ]);
    }

    public static function respond($data, $headers = []) 
    {
         return  Response::json($data, responceServices::$statusCode, $headers);
     }
    
    public static function responseWithError($errorCode, $data = null) {
        responceServices::$statusCode = Resp::HTTP_OK;
        return responceServices::respond([
                    'success' => false,
                    'message' => trans('error.'.$errorCode),
                    'message_code' => $errorCode,
                    'data' => $data
        ]);
    }
    
}
