<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;

class fetchAllcontro extends Controller
{
    /**
	* @OA\Get(
	* path="/api/displayall/",
	* tags={"PREM Tag"},
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
    
 function fetchAll()
 {
 	return student::showout();
 }

}
