<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\twelth;

class serachapi extends Controller
{
	/**
	* @OA\Get(
	* path="/api/searchapi",
	* tags={"college"},
	* summary="Get list of available subscription plans for user",
	* description="Subscription list",
	  *     @OA\Parameter(
	  *        name="name", in="query",required=true, @OA\Schema(type="string")
	  *     ),
	* @OA\Response(
	* response=200,
	* description="Successful operation",
	* @OA\JsonContent(ref="components/schemas/ProjectResource")
	* ),
	* @OA\Response(
	* response=401,
	* description="Unauthenticated",
	* ),
	* @OA\Response(
	* response=403,
	* description="Forbidden"
	* )
	* )
	*/
    function searchvalue(Request $req)
    {
		$search=$req['name'];
		$data = twelth::where('name','LIKE',$search.'%')->get();
    	   return $data;
    }
}
