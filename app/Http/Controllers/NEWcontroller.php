<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;


class NEWcontroller extends Controller
{
   /**
	* @OA\Get(
	* path="/api/newjoin",
	* tags={"new"},
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
    function newjoin(Request $req)
    {
    return details::join('student_fees','student.id','=','student_fees.id')->get();
    }
}
