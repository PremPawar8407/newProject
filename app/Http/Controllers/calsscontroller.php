<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\twelth;
use Illuminate\Support\Facades\Validator;
class calsscontroller extends Controller
{
     
    /**
     * @OA\Post(
     ** path="/api/class",
     *   tags={"college"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="email",
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
     *      name="phone",
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
    function twevelth(Request $req)
    {
    	
    	$rules=array(
    		'name'=>'required|max:30',
    		'email'=>'required|unique:12th_class,email',
    		'address'=>'required|max:35',
    		'phone'=>'required|max:12|unique:12th_class,phone');


     $Validator=Validator::make($req->all(), $rules);
     if ($Validator->fails())
      {
       return $Validator->errors();
     }
     else

     {  

    	$data= new twelth;
    	$data->name=$req->name;
    	$data->email=$req->email;
    	$data->address=$req->address;
    	$data->phone=$req->phone;
    	  // $data->save();
    	return "data has submitted";
      }
    }
}
