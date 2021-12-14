<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\MongoDB\mongoServices;
use Validator;


class mongoDbController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/create",
     * summary="Create Data in MongoDB",
      *   description="create<br/>
       Success Code:<br/>
       10012: Data inserted successfully in MongoDB.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7035: Please enter a valid firstname.<br/>
       7036: Please enter a valid lastname.<br/>
       7037: Please enter a valid phone.<br/>
       ",
     * tags={"MongoDb project"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Folder details",
     *    @OA\JsonContent(
     *       required={"firstname", "lastname", "phone"},
     *       @OA\Property(property="firstname", type="string", example="prem"),
     *       @OA\Property(property="lastname", type="string", example="pawar"),
     *       @OA\Property(property="Phone", type="string", example="8407595585")
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
    function crateRegistration(Request $req)
    {
    	//valid session-token
    	$token            = $req->header("session_token");
      	$practiceServices = new PracticeServices;
      	$getusrData       = json_decode($practiceServices->checkUserDataToken($token));
		if ($getusrData == '') 
		{
		return responceServices::responseWithError(7002, null);
		}
		$usrId = $getusrData->data->usr_id;
    	$payload = $req->all();

        $firstnameRules = ['firstname' => 'required'];
        $lastnameRules  = ['lastname'  => 'required'];
        $phoneRules     = ['Phone'     => 'required'];

        //valid firstname
        $validFirstName = Validator::make($req->all(), $firstnameRules);
        if ($validFirstName->fails()) 
        {
            return responceServices::responseWithError(7035, null);
        }

        //valid lastname
        $validLastName = Validator::make($req->all(), $lastnameRules);
        if ($validLastName->fails()) 
        {
            return responceServices::responseWithError(7036, null);
        }

        //valid phone
        $validPhone = Validator::make($req->all(), $phoneRules);
        if ($validPhone->fails()) 
        {
            return responceServices::responseWithError(7037, null);
        }

    	$mongoServices = new mongoServices;

    	$addData = $mongoServices->crateRegistration($payload);
    	
        return responceServices::respondWithSuccess(10012, $addData);
    	
    }

    /**
     * @OA\Get(
     * path="/api/read",
     * summary="List all data in mongoDB newdata collection",
     *   description="fetch collection value<br/>
      Success Code:<br/>
            10005: Folder list fetch successfull.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7006: Please enter a valid folder_state(A/I).<br/>
            7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/> 
       ",
     * tags={"MongoDb project"},
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

     function readData(Request $req)
     {
        //valid session-token
        $token            = $req->header("session_token");
        $practiceServices = new PracticeServices;
        $getusrData       = json_decode($practiceServices->checkUserDataToken($token));
        if ($getusrData == '') 
        {
        return responceServices::responseWithError(7002, null);
        }

        $mongoServices = new mongoServices;

        $result = $mongoServices->readData();
        return responceServices::respondWithSuccess(10013, $result);
     }


     /**
    * @OA\put(
    * path="/api/updateData",
    * operationId="update data mongodb in collection",
    * summary="Update existing project",
    * description="update data",
    * tags={"MongoDb project"},
    * @OA\RequestBody(
     *    required=true,
     *    description="Provide data details",
     *    @OA\JsonContent(
     *       required={"student_fname", "student_lname", "student_phone"},
     *       @OA\Property(property="mongo_id", type="string", example="213232131"),
     *       @OA\Property(property="firstname", type="string", example="john"),
     *       @OA\Property(property="lastname", type="string", example="doe"),
     *       @OA\Property(property="phone", type="string", example="9784")
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
     *  @OA\Parameter(
     *      name="session-token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
    * @OA\Response(
    * response=400,
    * description="Bad Request"
    * ),
    * @OA\Response(
    * response=401,
    * description="Unauthenticated",
    * ),
    * @OA\Response(
    * response=403,
    * description="Forbidden"
    * ),
    * @OA\Response(
    * response=404,
    * description="Resource Not Found"
    * )
    * )
    */
    
    function updateData(Request $req)
    {
        //valid session-token
        $token            = $req->header("session_token");
        $practiceServices = new PracticeServices;
        $getusrData       = json_decode($practiceServices->checkUserDataToken($token));
        if ($getusrData == '') 
        {
        return responceServices::responseWithError(7002, null);
        }
        $payload = $req->all();
        
        $mongoIdRules   = ['mongo_id'  => 'required'];
        $firstnameRules = ['firstname' => 'required'];
        $lastnameRules  = ['lastname'  => 'required'];
        $phoneRules     = ['phone'     => 'required'];

        //valid mongoId 
        $validMongoId = Validator::make($req->all(), $mongoIdRules);
        if ($validMongoId->fails()) 
        {
            return responceServices::responseWithError(7038, null);
        }

        $mongoServices = new mongoServices;
        //dynamic validation for mongoid

        $dynamicValidMongoId = $mongoServices->validMongoId($payload['mongo_id']);
        if (empty($dynamicValidMongoId)) 
        {
            return responceServices::responseWithError(7038, null);
        }

        //valid firstname
        $validFirstName = Validator::make($req->all(), $firstnameRules);
        if ($validFirstName->fails()) 
        {
            return responceServices::responseWithError(7035, null);
        }

        //valid lastname
        $validLastName = Validator::make($req->all(), $lastnameRules);
        if ($validLastName->fails()) 
        {
            return responceServices::responseWithError(7036, null);
        }

        //valid phone
        $validPhone = Validator::make($req->all(), $phoneRules);
        if ($validPhone->fails()) 
        {
            return responceServices::responseWithError(7037, null);
        }

        $updateData = $mongoServices->updateData($payload);
        return responceServices::respondWithSuccess(10014, null);   
    }

    /**
     * @OA\Delete(
     *      path="/api/deleteData",
     *      operationId="delete data in mongoDB",
     *      tags={"MongoDb project"},
     *      summary="delete data in mongoDB",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="mongo_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *  @OA\Parameter(
     *      name="session-token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    function deleteData (Request $req)
    {
        $token            = $req->header("session_token");
        $practiceServices = new PracticeServices;
        $getusrData       = json_decode($practiceServices->checkUserDataToken($token));
        if ($getusrData == '') 
        {
        return responceServices::responseWithError(7002, null);
        }
        $payload = $req->all();

        $mongoServices = new mongoServices;
        
        //dynamic validation for mongoID

        $dynamicValidMongoId = $mongoServices->validMongoId($payload['mongo_id']);
        if (empty($dynamicValidMongoId)) 
        {
            return responceServices::responseWithError(7038, null);
        }
         
       
        $deleteData = $mongoServices->deleteData($payload['mongo_id']);
        return responceServices::respondWithSuccess(10015, null);  
    }
}
