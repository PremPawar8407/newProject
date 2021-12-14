<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Group\groupServices;
use Validator;

class groupController extends Controller
{
 
 	/**
     * @OA\Post(
     * path="/api/addGroup",
     * summary="Create Group",
      *   description="create group<br/>
       Success Code:<br/>
       10007: Group added successfully.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7009: Please enter a valid group_name.<br/>
       7010: Please enter a valid group_type(PUBLIC/PRIVATE).<br/>
       7011: Group name is already exists.<br/>
       ",
     * tags={"Project Group"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Group details",
     *    @OA\JsonContent(
     *       required={"grp_name", "grp_note", "grp_type"},
     *       @OA\Property(property="grp_name", type="string", example="test"),
     *       @OA\Property(property="grp_note", type="string", example="123456"),
     *       @OA\Property(property="grp_type", type="string", example="PUBLIC/PRIVATE")
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
    function addGroup(Request $req)
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

    	$grpNameRules = ['grp_name' => 'required'];
    	$grpTypeRules = ['grp_type' => 'required'];


    	//valid group_name
    	$validGrpName = Validator::make($req->all(), $grpNameRules);
    	if ($validGrpName->fails())
    	{
    		return responceServices::responseWithError(7009, null);
    	}

    	//valid goup_type
    	$validGrpType = Validator::make($req->all(), $grpTypeRules);
    	if ($validGrpType->fails() || !in_array($payload['grp_type'], array('PUBLIC', 'PRIVATE')))
    	{
    		return responceServices::responseWithError(7010, null);
    	}

    	//dynamic validation for grp_name

    	$grpServices         = new groupServices;
    	$dynamicValidGrpName = $grpServices->validGrpName($payload);
    	   
    	if (count($dynamicValidGrpName)) 
    	{

    		return responceServices::responseWithError(7011, $dynamicValidGrpName[0]);
    	}
    	
    	//insert Group Data

    	$grpServices         = new groupServices;
    	$insertGrpID         = $grpServices->addGroup($payload);
    	return responceServices::respondWithSuccess(10007,array('grp_id' => $insertGrpID));
    }
 	
 	/**
     * @OA\Post(
     * path="/api/deleteGroup",
     * summary="Delete Group",
      *   description="create group<br/>
       Success Code:<br/>
       10008: Group deleted successfullly.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       ",
     * tags={"Project Group"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Group details",
     *    @OA\JsonContent(
     *       required={"grp_id"},
     *       @OA\Property(property="grp_id", type="number", example="1")
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

      function deleteGroup(Request $req)
      {
      	$sessionToken = $req->header("session-token");

    	$practiceServices = new PracticeServices;
    	$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
    	if ($usrData == '') 
    	{
    		return responceServices::responseWithError(7002, null);
    	}
    	
    	$payload =  $req->all();
        $usrId = $usrData->data->usr_id;    	

    	$grpServices = new groupServices;
    	$mainData = $grpServices->deleteGroup($payload, $usrId);
    	return responceServices::respondWithSuccess(10008, array('grp_id' => $payload['grp_id']));
      }

      /**
     * @OA\Post(
     * path="/api/updateGroup",
     * summary="update Group",
      *   description="update group<br/>
       Success Code:<br/>
       10009: Group details update successfull.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7009: Please enter a valid group_name.<br/>
       7010: Please enter a valid group_type(PUBLIC/PRIVATE).<br/>
       7011: Group name is already exists.<br/>
       7012: Please enter a valid gorup_id.<br/>
       ",
     * tags={"Project Group"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Group details",
     *    @OA\JsonContent(
     *       required={"grp_id", "grp_name", "grp_note", "grp_type"},
     *       @OA\Property(property="grp_id", type="number", example="0"),
     *       @OA\Property(property="grp_name", type="string", example="test"),
     *       @OA\Property(property="grp_note", type="string", example="123456"),
     *       @OA\Property(property="grp_type", type="string", example="PUBLIC/PRIVATE")
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
      function updateGroup(Request $req)
      {
        $sessionToken = $req->header("session-token");
        $practiceServices = new PracticeServices;
        $usrData      = json_decode($practiceServices->checkUserDataToken($sessionToken));

        if ($usrData == '') 
        {
           return responceServices::responseWithError(7002, null);       
        }

        $payload = $req->all();
        $payload['account_id'] = $usrData->data->usr_id;

        $grpIdRules   = ['grp_id'   => 'required|numeric'];
        $grpNameRules = ['grp_name' => 'required'];
        $grpTypeRules = ['grp_type' => 'required'];

        //valid grp_id
        $validGrpID = Validator::make($req->all(), $grpIdRules);
        if ($validGrpID->fails())
        {
            return responceServices::responseWithError(7012, null);
        }

        //valid grp_name
        $validGrpName = Validator::make($req->all(), $grpNameRules);
        if ($validGrpName->fails())
        {
            return responceServices::responseWithError(7009, null);
        }

        //valid grp_type
        $validGrpType = Validator::make($req->all(), $grpTypeRules);
        if ($validGrpType->fails() || !in_array($payload['grp_type'], array('PUBLIC', 'PRIVATE'))) 
        {
            return responceServices::responseWithError(7010, null);
        }

        //dyanamic validation for grp_name
        $grpServices         = new groupServices;
        $dynamicValidGrpName = $grpServices->validGrpName($payload);
           
        if (count($dynamicValidGrpName)) 
        {

            return responceServices::responseWithError(7011, $dynamicValidGrpName[0]);
        }
        
        $grpServices = new groupServices;
        $updateGrp = $grpServices->updateGrp($payload);
        return responceServices::respondWithSuccess(10009, null); 
      }


     /**
     * @OA\Get(
     * path="/api/listAll",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10010: Group list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       ",
     * tags={"Project Group"},
     *  @OA\Parameter(
     *      name="grp_type",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="PUBLIC/PRIVATE"
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
     *          example="grp_name/grp_note"
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

    function fetchAllGroup(Request $req)
    {
        $sessionToken = $req->header("session-token");
        $practiceServices = new PracticeServices;
        $usrData      = json_decode($practiceServices->checkUserDataToken($sessionToken));

        if ($usrData == '') 
        {
           return responceServices::responseWithError(7002, null);       
        }

        $payload = $req->all();
        $payload['account_id'] = $usrData->data->usr_id;

        $grpServices  = new groupServices;
        $grpData      = $grpServices->fetchAllGroup($payload);

        $countGrpData = count($grpData);
        return responceServices::respondWithSuccess(10010, array('grp_list' => $grpData, 'total_count' => $countGrpData));


    }


    /**
     * @OA\Get(
     * path="/api/details",
     * summary="List all group names under usr_id",
     *   description="fetch group list <br/>
      Success Code:<br/>
            10011: Group derails fetch successfully.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       ",
     * tags={"Project Group"},
     *  @OA\Parameter(
     *      name="grp_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="numeric",
     *          example="0"
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


       function groupDetails(Request $req)
       {
        $sessionToken = $req->header("session-token");
        $practiceServices = new PracticeServices;
        $usrData      = json_decode($practiceServices->checkUserDataToken($sessionToken));

        if ($usrData == '') 
        {
           return responceServices::responseWithError(7002, null);       
        }

        $payload = $req->all();
        $payload['account_id'] = $usrData->data->usr_id;

        $grpServices  = new groupServices;
        $grpIdData    = $grpServices->fetchDataGroupId($payload);
        return responceServices::respondWithSuccess(10011, $grpIdData);
       }

}
