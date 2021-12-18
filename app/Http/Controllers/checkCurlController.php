<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Curl\curlServices;


class checkCurlController extends Controller
{
  /**
     * @OA\Get(
     * path="/api/checkCurl",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10010: Group list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       ",
     * tags={"Curl project"},
     *  @OA\Parameter(
     *      name="session-token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    function checkCurl(Request $req)
    {
    	$sessionToken = $req->header("session-token");
    	$practiceServices = new PracticeServices;
    	$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
    	if ($usrData == '') 
    	{
    		return responceServices::responseWithError(7002, null);
    	}
    	$payload =  $req->all();
    	$curlServices = new curlServices;
    	$result = $curlServices->checkCurl();


    	return $result;
    }
}
