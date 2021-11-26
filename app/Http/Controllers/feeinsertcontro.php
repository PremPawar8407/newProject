<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;

class feeinsertcontro extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/feeinsert",
     *   tags={"new"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="fees",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
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
  
    	     function feefun(Request $req)
    {
   		$data =new details;		
    	$data->id=$req->id;
    	$data->fees=$req->fees;
    	$data->save();
    	return $req;

    	
    }
  
}
