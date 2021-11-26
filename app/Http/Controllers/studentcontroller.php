<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;
use App\Http\Services\newUtility\responceServices;

class studentcontroller extends Controller
{
	/**
     * @OA\Post(
     ** path="/api/student_table",
     *   tags={"new"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="lastname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="fees_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
        function stundentfun(Request $req)
    {
   		$data =new details;		
    	$data->firstname=$req->firstname;
    	$data->lastname=$req->lastname;
    	$data->address=$req->address;
    	$data->save();
    	return $req;

    	
    }

    /**
     * @OA\Get(
     * path="/api/responePractice",
     * summary="List all folder names under account_id",
     *   description="fetch folder details<br/>
      Success Code:<br/>
            10001: Folder list fetched successfullly.<br/>
       ",
     * tags={"prem"},
     *  @OA\Parameter(
     *      name="folder_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
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

       function responePractice(Request $req)
       {
        $payload = $req->all();
        return responceServices::responseWithError(7001, "prem");
        exit();
        return responceServices::respondWithSuccess(10001, $payload['folder_type']);
       }
}
