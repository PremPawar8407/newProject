<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\download\downloadServices;
use Validator;

class downloadUsrController extends Controller
{
    
    /**
     * @OA\Get(
     * path="/api/downloadusr",
     * summary="List all studets",
     *   description="create folder<br/>
       Success Code:<br/>
       8000: Response-Note updated successfully.<br/>
       Error Code:<br/>
       10001: Invalid session-token or its expired.<br/>
       7031: Please enter a valid subscription(1/2/3).<br/>
       7032: Please enter a valid sort by.<br/>
       7033: Please enter a valid order(ASC/DESC).<br/>
       ",
     * tags={"prem"},
     *  @OA\Parameter(
     *      name="session-token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),  
     *  @OA\Parameter(
     *      name="sort_By",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="con_first_name/con_last_name"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="order",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="ASC/DESC"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="subscription",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="0/1"
     *      )
     *   ),
     * @OA\Response(
     *    response=422,
     *    description="Please enter a valid information",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */


           function export(Request $req)
       {
        $sessionToken = $req->header("session-token");

    	$practiceServices = new PracticeServices;
    	$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
    	if ($usrData == '') 
    	{
    		return responceServices::responseWithError(7002, null);
    	}

    	$sortByRules = ['sort_By' => 'required'];
        $orderRules  = ['order'   => 'required'];
        $subscriptionRules = ['subscription'  => 'required'];

    	$payload                 =  $req->all();
    	$payload['account_id']   =  $usrData->data->usr_id;

          $sortByValidation = Validator::make($req->all(), $sortByRules);
        if ($sortByValidation->fails()) 
        {
           return responceServices::responseWithError(7032, null);
        }

          $orderValidation = Validator::make($req->all(), $orderRules);
        if ($orderValidation->fails()) 
        {
           return responceServices::responseWithError(7033, null);
        }

         $subscriptionValidation = Validator::make($req->all(), $subscriptionRules);
        if ($subscriptionValidation->fails()) 
        {
           return responceServices::responseWithError(7031, null);
        }



        $downloadServices = new downloadServices;
        $result = $downloadServices->exportservice($payload['sort_By'], $payload['order'], $payload['subscription']);

        return $result;

     
         
         

       }

}
