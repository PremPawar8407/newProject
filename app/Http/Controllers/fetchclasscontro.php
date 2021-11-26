<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classmodel;

class fetchclasscontro extends Controller
{
    /**
	* @OA\Get(
	* path="/api/fetch_class/",
	* tags={"college"},
	* summary="Get list of available subscription plans for user",
	* description="Subscription list",
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
    function fetch_class(Request $req)
    {
    	return classmodel::all();
    }
}
