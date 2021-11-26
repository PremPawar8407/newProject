<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;


class joincontroller extends Controller
{
	 /**
	* @OA\Get(
	* path="/api/join",
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
   
    function join(Request $req)
    {
    return details::join('teacher','students.id','=','teacher.id')->get();

    }
}
