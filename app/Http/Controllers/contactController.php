<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Contact\contactServices;
use Validator;

class contactController extends Controller
{
	/**
     * @OA\Post(
     * path="/api/addContact",
     * summary="Create contact",
      *   description="create contact<br/>
       Success Code:<br/>
       10012: Contact added successfully.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7012: Please enter a valid gorup_id.<br/>
       7013: Please enter valid contact number.<br/>
       7014: Please enter valid first name.<br/>
       7015: Please enter valid last name.<br/>
       7016: Please enter valid email.<br/>
       7017: Phone number already exists.<br/>
       ",
     * tags={"Project Contact"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide contact details",
     *    @OA\JsonContent(
     *       required={"phone_number","first_name", "last_name", "email"},
     *       @OA\Property(property="con_group_id", type="string", example="1"),
     *       @OA\Property(property="phone_number", type="string", example="1234567890"),
     *       @OA\Property(property="first_name", type="string", example="John"),
     *       @OA\Property(property="last_name", type="string", example="Deo"),
     *       @OA\Property(property="email", type="string", example="john@gamil.com"),
     *       @OA\Property(property="notes", type="string", example="test a dummy text.")
     *    ),
     * ),
     *  @OA\Parameter(
     *      name="session-token",
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
    
    function addContact(Request $req)
    {
    	$sessionToken = $req->header("session-token");
    	$practiceServices = new PracticeServices;
    	$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
    	if ($usrData == '') 
    	{
    		return responceServices::responseWithError(7002, null);
    	}
    	$payload                 =  $req->all();
    	$payload['account_id']   =  $usrData->data->usr_id;

    	$grpIDRules          = ['con_group_id' => 'required'];
    	$phoneNumberRules    = ['phone_number' => 'required|min:10|max:12'];
    	$firstNameRules      = ['first_name'   => 'required'];
    	$lastNameRules       = ['last_name'    => 'required'];
    	$emailRules          = ['email'        => 'required|email'];


    	//valid grp_id
    	$validId = Validator::make($req->all(), $grpIDRules);
	    	if ($validId->fails()) 
	    	{
	    		return responceServices::responseWithError(7012, null);
	    	}

    	//valid phone_number
    	$validPhoneNumber = Validator::make($req->all(), $phoneNumberRules);
	    	if ($validPhoneNumber->fails()) 
	    	{
	    		return responceServices::responseWithError(7013, null);
	    	}

    	//valid first_name
    	$validFirstName = Validator::make($req->all(), $firstNameRules);
	    	if ($validFirstName->fails()) 
	    	{
	    		return responceServices::responseWithError(7014, null);
	    	}

    	//valid last_name
    	$validLastName = Validator::make($req->all(), $lastNameRules);
	    	if ($validLastName->fails()) 
	    	{
	    		return responceServices::responseWithError(7015, null);
	    	}

    	//valid email
    	$validEmail = Validator::make($req->all(), $emailRules);
	    	if ($validEmail->fails()) 
	    	{
	    		return responceServices::responseWithError(7016, null);
	    	}

    	$contactServices = new contactServices;

    	//dynamic validation for phone number
    	$dynamicValidPhoneNumber = $contactServices->checkPhoneNumber($payload);
	    	if (count($dynamicValidPhoneNumber)) 
	    	{
	    		return responceServices::responseWithError(7017, $dynamicValidPhoneNumber[0]);
	    	}
    	
    	$contactID = $contactServices->addContact($payload);

    	$addRelContactGrp = $contactServices->addRelContactGrp($contactID, $payload);

    	return responceServices::respondWithSuccess(10012, array('con_id' => $contactID));

    	
    }


    /**
     * @OA\Post(
     * path="/api/updateContact",
     * summary="update contact",
      *   description="update contact<br/>
       Success Code:<br/>
       10012: Contact added successfully.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7012: Please enter a valid gorup_id.<br/>
       7013: Please enter valid contact number.<br/>
       7014: Please enter valid first name.<br/>
       7015: Please enter valid last name.<br/>
       7016: Please enter valid email.<br/>
       7017: Phone number already exists.<br/>
       ",
     * tags={"Project Contact"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide contact details",
     *    @OA\JsonContent(
     *       required={"phone_number","first_name", "last_name", "email"},
     *       @OA\Property(property="con_id", type="string", example="1"),
     *       @OA\Property(property="first_name", type="string", example="John"),
     *       @OA\Property(property="last_name", type="string", example="Deo"),
     *       @OA\Property(property="email", type="string", example="john@gamil.com"),
     *       @OA\Property(property="notes", type="string", example="test a dummy text.")
     *    ),
     * ),
     *  @OA\Parameter(
     *      name="session-token",
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
    function updateContact(Request $req)
    {
    	
    	$sessionToken     = $req->header("session-token");
    	$practiceServices = new PracticeServices;
    	$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
    	if ($usrData == '') 
    	{
    		return responceServices::responseWithError(7002, null);
    	}

    	$payload                 =  $req->all();
    	$payload['account_id']   =  $usrData->data->usr_id;

    	$conIDRules          = ['con_id'       => 'required'];
    	$firstNameRules      = ['first_name'   => 'required'];
    	$lastNameRules       = ['last_name'    => 'required'];
    	$emailRules          = ['email'        => 'required|email'];

       	//valid con_id
    	$validConId = Validator::make($req->all(), $conIDRules);
    	if ($validConId->fails()) 
    	{
    		return responceServices::responseWithError(7018, null);
    	}

    	//valid firstName
    	$validFirstName = Validator::make($req->all(), $firstNameRules);
    	if ($validFirstName->fails()) 
    	{
    		return responceServices::responseWithError(7014, null);
    	}

    	//valid lastName
    	$validLastName = Validator::make($req->all(), $lastNameRules);
    	if ($validLastName->fails()) 
    	{
    		return responceServices::responseWithError(7015, null);
    	}

    	//valid email
    	$validEmail = Validator::make($req->all(), $emailRules);
    	if ($validEmail->fails()) 
    	{
    		return responceServices::responseWithError(7016, null);
    	}

    	$contactServices = new contactServices;
    	$conUpdateID = $contactServices->updateContact($payload);
    	return responceServices::respondWithSuccess(10013, array('con_id' => $conUpdateID));



    	
    	
    }



    /**
     * @OA\Get(
     * path="/api/contactListAll",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10010: Group list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       ",
     * tags={"Project Contact"},
     *  @OA\Parameter(
     *      name="number",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1123"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="area_code",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="123"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="john"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="con_type",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="PUBLIC/PRIVATE"
     *      )
     *   ),
	 *  @OA\Parameter(
     *      name="grp_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
     *      )
     *   ),
      *  @OA\Parameter(
     *      name="num",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="10/50/150"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="offset",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="0"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="sort_by",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="phone_number, first_name, email, created_on, status"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="order",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="ASC/DESC"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="session-token",
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

       function contactListAll(Request $req)
       {
			$sessionToken     = $req->header("session-token");
			$practiceServices = new PracticeServices;
			$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
			if ($usrData == '') 
			{
				return responceServices::responseWithError(7002, null);
			}

			$payload                 =  $req->all();
			$payload['account_id']   =  $usrData->data->usr_id;

			$contactServices  = new contactServices;
    		$contactList      = $contactServices->listAllContact($payload);
			$countcontactList = count($contactList);
			
			return responceServices::respondWithSuccess(10014, array('contact_list' => $contactList, 'total_count' => $countcontactList));

       }
}
