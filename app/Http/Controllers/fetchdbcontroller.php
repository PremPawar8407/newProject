<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class fetchdbcontroller extends Controller

{

	/**
	* @OA\Get(
	* path="/api/fetch_data/{id}/{name}	",
	* tags={"PREM Tag"},
	* summary="Get list of available subscription plans for user",
	* description="Subscription list",
	 *     @OA\Parameter(
	  *        name="id", in="path",required=true, @OA\Schema(type="integer")
	  *     ),
	  *     @OA\Parameter(
	  *        name="name", in="path",required=true, @OA\Schema(type="string")
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
	 function fetchasc( $id,$name)
    {


       $data= DB::table("products")->select("firstname")
  	   ->orderBy('firstname','asc')
       ->get();
   
	    return $data;   
	 }

 
 
}
