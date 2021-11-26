<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;

class postcontroller extends Controller
{
	
    /**
     * @OA\Post(
     ** path="/api/user",
     *   tags={"PREM Tag"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="fname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="lname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
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

    function post(Request $req)
    {
    	$valid=$req->validate([
    		'fname'=>'required|max:10',
    		 'lname'=>'required|max:10',
             'email'=>'required']);

    	
       $product= new details;
       $product->firstname=$req->fname;
       $product->lastname=$req->lname;
       $product->email=$req->email;
       //$product->save();
       return $req->all(); 
    }
}
