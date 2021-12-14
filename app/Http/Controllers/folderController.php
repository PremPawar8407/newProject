<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Folder\FolderServices;
use Validator;

class folderController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/addFolder",
     * summary="Create Folder",
      *   description="create folder<br/>
       Success Code:<br/>
       10004: Folder added successfullly.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7004: Please enter a valid folder_name.<br/>
       7005: Please enter a valid folder_password.<br/>
       7006: Please enter a valid folder_state(A/I).<br/>
       7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
       7008: folder_name is already exists.<br/>
       ",
     * tags={"Project"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Folder details",
     *    @OA\JsonContent(
     *       required={"folder_name", "folder_password", "folder_state", "folder_type"},
     *       @OA\Property(property="folder_name", type="string", example="Holiday"),
     *       @OA\Property(property="folder_password", type="string", example="123456"),
     *       @OA\Property(property="folder_state", type="string", example="A/I"),
     *       @OA\Property(property="folder_type", type="string", example="NORMAL/DRIP")
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
    function insertFolder(Request $req)
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
    	
    	$folderNameRules     = ['folder_name'     => 'required']; 
    	$folderPasswordRules = ['folder_password' => 'required'];
    	$folderStateRules    = ['folder_state'    => 'required'];
    	$folderTypeRules     = ['folder_type'     => 'required'];


    	//valid folder name
    	$validFolderName = Validator::make($req->all(), $folderNameRules);
    	if ($validFolderName->fails()) 
    	{
    		return responceServices::responseWithError(7004, null);
    	}
    	
    	//valid folder password
    	$validFolderPass = Validator::make($req->all(), $folderPasswordRules);
    	if ($validFolderPass->fails()) 
    	{
    		return responceServices::responseWithError(7005, null);
    	}

    	//valid folder state
    	$validFolderState = Validator::make($req->all(), $folderStateRules);
    	if ($validFolderState->fails() || !in_array((array_key_exists("folder_state", $payload) ? $payload['folder_state']:""),array('A','I'))){
    		return responceServices::responseWithError(7006,null);
    	}
    	//valid folder type
    	$validFolderType = Validator::make($req->all(), $folderTypeRules);
    	if ($validFolderType->fails() || ! in_array(array_key_exists('folder_type', $payload) ? $payload['folder_type'] : "", array('NORMAL', 'DRIP'))) 
    	{
    		return responceServices::responseWithError(7007,null);
    	}

    	$folderServices = new FolderServices;

    	//dynamic validate folder name
    	$dynamicValidFolderName = $folderServices->validateFolderName($payload['folder_name'], $usrId);
    	if (count($dynamicValidFolderName))
    	{
    		return responceServices::responseWithError(7008,null);	
    	}
    	
    	$addData = $folderServices->addFolder($payload, $usrId);
    	return responceServices::respondWithSuccess(10004, array('folder_id' => $addData));
    	
	}

	 /**
     * @OA\Get(
     * path="/api/folderList",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10005: Folder list fetch successfull.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7006: Please enter a valid folder_state(A/I).<br/>
            7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/> 
       ",
     * tags={"Project"},
     *  @OA\Parameter(
     *      name="folder_state",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="A/I"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="folder_type",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
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

       function fetchFolder(Request $req)

       {
       	$payload = $req->all();
       	$sessionToken = $req->header('session-token');

       	$folderStateRules = [ 'folder_state' => 'required'];
       	$folderTypeRules  = [ 'folder_type'  => 'required'];

       	$practiceServices = new PracticeServices;
        $getusrData       = json_decode($practiceServices->checkUserDataToken($sessionToken));
        if ($getusrData == '') 
        {
        	return responceServices::responseWithError(7002, null);
        }

        $usrId = $getusrData->data->usr_id;

       
       	//valid folder state
    	$validFolderState = Validator::make($req->all(), $folderStateRules);
    	if ($validFolderState->fails() || !in_array((array_key_exists("folder_state", $payload) ? $payload['folder_state']:""),array('A','I'))){
    		return responceServices::responseWithError(7006,null);
    	}
    	//valid folder type
    	$validFolderType = Validator::make($req->all(), $folderTypeRules);
    	if ($validFolderType->fails() || ! in_array(array_key_exists('folder_type', $payload) ? $payload['folder_type'] : "", array('NORMAL', 'DRIP'))) 
    	{
    		return responceServices::responseWithError(7007,null);
    	}

    	$folderServices = new FolderServices;
    	$folderData     = $folderServices->showFolderData($payload, $usrId);
    	return responceServices::respondWithSuccess(10005, $folderData);

         }

         /**
     * @OA\Get(
     * path="/api/listAllFolder",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10005: Folder list fetch successfull.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       		7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
       ",
     * tags={"Project"},
     *  @OA\Parameter(
     *      name="folder_type",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
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
         function fetchFolderType (Request $req)
         {

         	$sessionToken = $req->header('session-token');
         	$practiceServices = new PracticeServices;
	        $getusrData       = json_decode($practiceServices->checkUserDataToken($sessionToken));
	        if ($getusrData == '') 
	        {
	        	return responceServices::responseWithError(7002, null);
	        }

	        $payload           = $req->all();
	        $payload['usr_id'] = $getusrData->data->usr_id;

	        $folderTypeRules = [ 'folder_type' => 'required'];

	        //valid folder type
	        $validFolderType = Validator::make($req->all(), $folderTypeRules);
	        if ($validFolderType->fails() || !in_array(array_key_exists('folder_type', $payload) ? $payload['folder_type'] : "", array('NORMAL','DRIP')))
	        {
	        	return responceServices::responseWithError(7007, null);
	        }

	        $folderServices = new FolderServices;
    		$folderData     = $folderServices->folderTypeFetch($payload);
	        return responceServices::respondWithSuccess(10005, $folderData);

         }

         /**
     * @OA\Get(
     * path="/api/listAllFolderUserId",
     * summary="List all folder names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10005: Folder list fetch successfull.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
       		7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
       ",
     * tags={"Project"},
     *  @OA\Parameter(
     *      name="folder_type",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="usr_id",
     *      in="query",
     *      required=TRUE,
     *      @OA\Schema(
     *          type="number",
     *          example="1,2,3,4"
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

       function listAllFolder( Request $req)
       {
       	$payload = $req->all();
       	$sessionToken = $req->header("session-token");
       	$practiceServices = new PracticeServices;
	    $getusrData       = json_decode($practiceServices->checkUserDataToken($sessionToken));
	    if ($getusrData == '') 
	        {
	        	return responceServices::responseWithError(7002, null);
	        }

	     	$folderTypeRules = [ 'folder_type' => 'required'];

	        //valid folder type
	        $validFolderType = Validator::make($req->all(), $folderTypeRules);
	        if ($validFolderType->fails() || !in_array(array_key_exists('folder_type', $payload) ? $payload['folder_type'] : "", array('NORMAL','DRIP')))
	        {
	        	return responceServices::responseWithError(7007, null);
	        }

	        $folderServices = new FolderServices;
    		$folderData     = $folderServices->folderTypeFetch($payload);
	        return responceServices::respondWithSuccess(10005, $folderData);

       }


       /**
     * @OA\Post(
     * path="/api/update_folder",
     * summary="update Folder",
      *   description="update folder<br/>
       Success Code:<br/>
       10006: Folder update successfull.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7004: Please enter a valid folder_name.<br/>
       7005: Please enter a valid folder_password.<br/>
       7006: Please enter a valid folder_state(A/I).<br/>
       7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
       7008: folder_name is already exists.<br/>
       ",
     * tags={"Project"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Folder details",
     *    @OA\JsonContent(
     *       required={"folder_id", "folder_name", "folder_password", "folder_state", "folder_type"},
     *		 @OA\Property(property="folder_id", type="string", example="1"),
     *       @OA\Property(property="folder_name", type="string", example="Holiday"),
     *       @OA\Property(property="folder_password", type="string", example="123456"),
     *       @OA\Property(property="folder_state", type="string", example="A/I"),
     *       @OA\Property(property="folder_type", type="string", example="NORMAL/DRIP")
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
       function updateFolder(Request $req)
       {
       	$sessionToken = $req->header("session-token");
       	$payload      = $req->all();

       	$practiceServices = new PracticeServices;
       	$getData          = json_decode($practiceServices->checkUserDataToken($sessionToken));
       	$usrId            = $getData->data->usr_id;
       	if ($getData == '') 
       	{
       		return responceServices::responseWithError(7002, null);
       	}
       	
       	$folderNameRules     = ['folder_name'     => 'required'];
       	$folderPasswordRules = ['folder_password' => 'required'];
       	$folderStateRules    = ['folder_state'    => 'required'];
       	$folderTypeRules     = ['folder_type'     => 'required'];

       	//valid folder_name
       	$validFolderName = Validator::make($req->all(), $folderNameRules);
       	if ($validFolderName->fails()) 
       	{
       		return responceServices::responseWithError(7004, null);
       	}

       	//valid folder_password
       	$validFolderPass = Validator::make($req->all(), $folderPasswordRules);
       	if ($validFolderPass->fails())
       	{
       		return responceServices::responseWithError(7005, null);
       	}

       //valid folder_State
       $validFolderState = Validator::make($req->all(), $folderStateRules);
       if ($validFolderState->fails() || !in_array(array_key_exists('folder_state', $payload) ? $payload['folder_state'] : "", array('A','I'))) 
       {
       		return responceServices::responseWithError(7006, null);
       	}	

       	//valid folder type
    	$validFolderType = Validator::make($req->all(), $folderTypeRules);
    	if ($validFolderType->fails() || ! in_array(array_key_exists('folder_type', $payload) ? $payload['folder_type'] : "", array('NORMAL', 'DRIP'))) 
    	{
    		return responceServices::responseWithError(7007,null);
    	}

    	 $folderServices = new folderServices;
    	//dynamic validate folder name
    	$dynamicValidFolderName = $folderServices->validateFolderName($payload['folder_name'], $usrId);
      return $dynamicValidFolderName;
      exit;
    	if (count($dynamicValidFolderName))
    	{
    		return responceServices::responseWithError(7008,null);	
    	}
       	 
       	
       	 $folderUpdate   = $folderServices->updateFolder($payload, $usrId);
       	 return responceServices::respondWithSuccess(10006, null);
       }
}
