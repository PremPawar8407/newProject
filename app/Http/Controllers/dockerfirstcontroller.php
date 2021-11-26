<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dockerdatabase;
use Illuminate\Support\Facades\Validator;
class dockerfirstcontroller extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/dockerfirst",
     *   tags={"docker"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="lastname",
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
      *  @OA\Parameter(
     *      name="address",
     *      in="query",
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
    function show(Request $req)
    {

    	$rules=array
    	(
    		'firstname'=>'required | max:30',
    		'lastname'=>'required | max:30',
    		'email'=>'required|unique:employee|email',
    		'address'=>'required|max:30'
    	);
    	  $valid=validator::make($req->all(),$rules);
    	  if ($valid->fails())
    	   {
    	  	return $valid->errors();
    	   }
    	   else
    	   {
    	  	$data=new dockerdatabase;
    	  	$data->firstname=$req->firstname;
    	  	$data->lastname=$req->lastname;
    	  	$data->email=$req->email;
    	  	$data->address=$req->address;
    	  	$data->save();
    	  	return $req->input();
    	   }
    	  
    	
    }
}
