<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;


class sigup extends Controller
{
    /**
     * @OA\Post(
     * path="/api/insertData",
     * summary="registration",
      *   description="Sign-Up<br/>
       ",
     * tags={"Project"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide employee details",
     *    @OA\JsonContent(
     *       required={"firstname", "lastname", "email", "password", "phone_number", "subscription"},
     *       @OA\Property(property="firstname", type="string", example="john"),
     *       @OA\Property(property="lastname", type="string", example="deo"),
     *       @OA\Property(property="email", type="string", example="john@gmail.com"),
     *       @OA\Property(property="password", type="string", example="Prem@234"),
     *       @OA\Property(property="phone_number", type="string", example="98956854785"),
     *       @OA\Property(property="subscription", type="numeric", example="1/2/3"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    function insertData(Request $req)
    {
    	$payload = $req->all();
       
    	$firstnameRules    =  ['firstname' 	   => 'required'];
    	$lastnameRules     =  ['lastname'  	   => 'required'];
    	$emailRules        =  ['email'     	   => 'required|email|unique:sign_up'];
    	$passwordRules     =  ['password' 	   => 'required|min:8'];
    	$phoneNumberRules  =  ['phone_number'  => 'required|max:12|min:10|unique:sign_up'];
    	$subscriptionRules =  ['subscription'  => 'required|numeric'];

    	//valid firstname
    	$validFirstName = validator::make($req->all(), $firstnameRules);
    		if ($validFirstName->fails()) 
	    	{
	    		return "please enter a valid firstname.";
	    	}


	    //valid lastname
	    $validLastName = validator::make($req->all(), $lastnameRules);
	    	if ($validLastName->fails()) 
	    	{
	    		return "please enter a valid lastname.";
	    	}

	    //valid email
	    $validEmail = validator::make($req->all(), $emailRules);
	    	if ($validEmail->fails()) 
	    	{
	    		return " please enter a valid emailRules.";
	    	}

	    //valid password
	    $validPassword = validator::make($req->all(), $passwordRules);
	    	if ($validPassword->fails())
	    	{
	    		return "please enter a valid password.";
	    	}

	    //valid password
	    $validPhoneNumber = validator::make($req->all(), $phoneNumberRules);
	    	if ($validPhoneNumber->fails())
	    	 {
	    		return "please enter a valid Phone number.";
	    	 }

	    //valid subscription
	    $validSubscription = validator::make($req->all(), $subscriptionRules);
	    	if ($validSubscription->fails())
	    	 {
	    		return "please take a valid subscription.";
	    	 }


        //insert data in database.ccc
    	 $ServicesData = new PracticeServices;
    	 $mainData     = $ServicesData->insertData($payload);


        //set data in redis
        $setDataInRedis = $ServicesData->checkcredential($payload); 
        
        return responceServices::respondWithSuccess(10003, $setDataInRedis);










    	
    }
            
}
