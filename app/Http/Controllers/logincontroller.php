<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Validator;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
class logincontroller extends Controller
{
    	/**
     * @OA\Post(
     * path="/api/login",
     * summary="User Login",
      *   description="Login user<br/>
       ",
     * tags={"Project"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", example="john@doe.com"),
     *       @OA\Property(property="password", type="string", example="123456"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response"
     *     )
     * )
     */

    function accountLogin(Request $req)
    {
   
   		$payload = $req->all();

   		$emailRules    = ['email'    => 'required'];
   		$passwordRules = ['password' => 'required'];

   		//valid email
   		$validEmail = validator::make($req->all(), $emailRules);
   		if ($validEmail->fails())
   		 {
   			return "please enter a valid email.";
   		}

   		//valid password
   		$validPassword = validator::make($req->all(), $passwordRules);
   		if ($validPassword->fails())
   		 {
   			return "please enter a valid password.";
   		}

   		$practiceServices = new PracticeServices;
   		$checkcredential  = $practiceServices->checkcredential($payload);

     
   	if (empty($checkcredential)) 
    {
      return  responceServices::responseWithError(7003, null);
    }
     return responceServices::respondWithSuccess(10001, $checkcredential);
   		
   		

   		
    	
    }

    /**
     * @OA\Get(
     * path="/api/validtoken",
     * summary="check valid token",
     *   description="check and get token.<br/>
      Success Code:<br/>
            10001: Folder list fetched successfullly.<br/>
       ",
     * tags={"Project"},
     *  @OA\Parameter(
     *      name="session_token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    function validToken(Request $req)
    {
      $token            = $req->header("session_token");
      $practiceServices = new PracticeServices;
      $getusrData       = json_decode($practiceServices->checkUserDataToken($token));

      if ($getusrData == '') 
      {
        return responceServices::responseWithError(7002, null);
      }
      else
      {
        return responceServices::respondWithSuccess(10002, $getusrData);
      }

      
    }
}
