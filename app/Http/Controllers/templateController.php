<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Template\templateServices;
use App\Http\Services\Category\categoryServices;
use Validator;
class templateController extends Controller
{
    
    /**
     * @OA\Post(
     * path="/api/template/add",
     * summary="Create Group",
      *   description="create group<br/>
       Success Code:<br/>
       10018: Template added successfullly.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
       7019: Please enter valid folder_id.<br/>
       7021: This folder_id is not valid or belongs to other account.<br/>
       7023: Please enter valid category ID.<br/>
       7025: Please enter valid template Name.<br/>
       7030: Template name already exists.<br/>
       7026: Please enter valid template message.<br/>
       7027: Please enter valid media_id.<br/>
       7028: Please enter valid media_url.<br/>
       7029: Minimum one drip message is required.<br/>
       ",
     * tags={"Project Template"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Template details",
     *    @OA\JsonContent(
     *       required={"folder_id", "cat_id", "tmpl_name", "tmpl_message"},
     *       @OA\Property(property="folder_id", type="numeric", example="1"),
     *       @OA\Property(property="cat_id", type="numeric", example="1"),
     *       @OA\Property(property="tmpl_name", type="string", example="Template Name"),
     *       @OA\Property(property="tmpl_message", type="string", example="Lorem ipsum dummy text for testing"),
     *       @OA\Property(property="tmpl_media_id", type="numeric", example="1(optional)"),
     *       @OA\Property(property="tmpl_media_title", type="string", example="Media Title (Optional)"),
     *       @OA\Property(property="tmpl_media_url", type="string", example="http://sampleurl.png (Optional)"),
     *       @OA\Property(property="tmpl_type", type="string", example="NORMAL/DRIP"),
     *       @OA\Property(
     *             property="tmpl_drip_details",
     *             type="array",
     *                  @OA\Items(
     *                       @OA\Property(
     *                       property="drp_type",
     *                       type="string",
     *                           example="DAY/HRS_MIN"
     *                  ),
     *                  @OA\Property(
     *                      property="drp_days",
     *                      type="integer",
     *                      example=0
     *                  ),
     *                  @OA\Property(
     *                      property="drp_hours",
     *                      type="integer",
     *                      example=12
     *                  ),
     *                  @OA\Property(
     *                      property="drp_minutes",
     *                      type="integer",
     *                      example=59
     *                  ),
     *                  @OA\Property(
     *                      property="drp_meridiem",
     *                      type="string",
     *                      example="AM/PM"
     *                  ),
     *                  @OA\Property(
     *                      property="drp_message",
     *                      type="string",
     *                      example="Lorem ipsum dummy text for testing."
     *                  ),
     *                  @OA\Property(
     *                      property="drp_media_id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="drp_media_title",
     *                      type="string",
     *                      example="Media Title"
     *                  ),
     *                  @OA\Property(
     *                      property="drp_media_url",
     *                      type="string",
     *                      example="http://something.mp4"
     *                  ),
     *              ),
     *              description="multiple values for follow-up messages NOT REQUIRED FOR NORMAL DRIP MESSAGES"
     *          ),
     *      ),
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
    function addTemplate(Request $req)
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

    	$folderIdRules       = ['folder_id'    	 => 'required'];
    	$catIDRules          = ['cat_id'       	 => 'required'];
    	$tmplNameRules       = ['tmpl_name'    	 => 'required'];
    	$tmplMsgRules        = ['tmpl_message' 	 => 'required'];
    	$tmplMediaIdRules    = ['tmpl_media_id'  => 'required'];
    	$tmplMediaUrlRules   = ['tmpl_media_url' => 'required'];
    	$tmplTypeRules       = ['tmpl_type'      => 'required'];
    	$tmplDripDetailRules = ['tmpl_drip_details' => 'required'];

    	//valid folderID 

    	$categoryServices = new categoryServices;

    	//valid folderId
    	$validFolderId = Validator::make($req->all(), $folderIdRules);
    	if ($validFolderId->fails()) 
    	{
    		return responceServices::responseWithError(7019, null);
    	}

    	$folderValidationData = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
    	if (count($folderValidationData) == '') 
    	{
    		return responceServices::responseWithError(7021, null);
    	}

    	//vaid catID 
    	$validcatID = Validator::make($req->all(), $catIDRules);
    	if ($validcatID->fails()) {
    		return responceServices::responseWithError(7023, null);
    	}

    	$templateServices = new templateServices;

    	$validCatId = $templateServices->validCatID($payload); 
		 if (!count($validCatId)) 
		 {
		 	return responceServices::responseWithError(7023, null);
		 }

		 //valid tmplName

		 $validTmplName = Validator::make($req->all(), $tmplNameRules);
		 if ($validTmplName->fails()) {
		 	return responceServices::responseWithError(7025, null);
		 }

		 // dynamic validation for template name

		 $validTmplNameData = $templateServices->validTmplName($payload);
		 if (count($validTmplNameData)) {
		 	return responceServices::responseWithError(7030, $validTmplNameData[0]);
		 }

		 //valid tmplMessages
    	$validTmplMsg = Validator::make($req->all(), $tmplMsgRules);
    	if ($validTmplMsg->fails()) 
    	{
    		return responceServices::responseWithError(7026, null);
    	}

    	/*//valid mediaID
    	$validmediaID = Validator::make($req->all(), $tmplMediaIdRules);
    	if ($validmediaID->fails()) 
    	{
    		return responceServices::responseWithError(7027, null);
    	}*/

    	/*/valid mediaUrl
    	$validMediaUrl = Validator::make($req->all(), $tmplMediaUrlRules);
    	if ($validMediaUrl->fails()) 
    	{
    		return responceServices::responseWithError(7028, null);
    	}*/

    	//valid template type
    	$validTemplType = Validator::make($req->all(), $tmplTypeRules);
    	if ($validTemplType->fails() || ! in_array(array_key_exists('tmpl_type', $payload) ? $payload['tmpl_type'] : "", array('NORMAL', 'DRIP'))) 
    	{
    		return responceServices::responseWithError(7039,null);
    	}

    	//validTmpDripDetails
    	$validTmpDripDetails = Validator::make($req->all(), $tmplDripDetailRules);

    	if ($payload['tmpl_type'] == 'DRIP' && $validTmpDripDetails->fails()) 
    	{
    		return responceServices::responseWithError(7029, null);
    	}

    	if (array_key_exists('media_id', $payload)) {
            $payload['media_id'] = $templateServices->addMedia(array('media_title' => $payload['tmpl_media_title'], 'media_url' => $payload['tmpl_media_url'], 'media_source' => "TEMPLATE", 'media_created_on' => date(getenv("DATETIME_FORMAT")), 'media_created_by' => $payload['account_id']));
        }
    	
    	

    	$lastTmplID = $templateServices->addTemplate($payload, $payload['account_id']);
    	return responceServices::respondWithSuccess(10018, array('tmpl_id' => $lastTmplID));
    	

    }



    /**
     * @OA\Post(
     * path="/api/template/update",
     * summary="User Login",
     *   description="create group<br/>
       Success Code:<br/>
       10019: Template details updated successfully.<br/>
       Error Code:<br/>
       7019: Please enter a valid session-token.<br/>
       7021: This folder_id is not valid or belongs to other account.<br/>
       7023: Please enter valid category ID.<br/>
       7025: Please enter valid template Name.<br/>
       7026: Please enter valid template message.<br/>
       7027: Please enter valid media_id.<br/>
       7028: Please enter valid media_url.<br/>
       7030: Template name already exists.<br/>
       7034: pleasse enter a valid template ID.<br/>
       ",
     * tags={"Project Template"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tmpl_id", "folder_id", "cat_id", "tmpl_name", "tmpl_message"},
     *       @OA\Property(property="tmpl_id", type="numeric", example="1"),
     *       @OA\Property(property="folder_id", type="numeric", example="1"),
     *       @OA\Property(property="cat_id", type="numeric", example="1"),
     *       @OA\Property(property="tmpl_name", type="string", example="Template Name"),
     *       @OA\Property(property="tmpl_message", type="string", example="Lorem ipsum dummy text for testing"),
     *       @OA\Property(property="tmpl_media_id", type="numeric", example="1(optional)"),
     *       @OA\Property(property="tmpl_media_title", type="string", example="Media Title (Optional)"),
     *       @OA\Property(property="tmpl_media_url", type="string", example="http://sampleurl.png (Optional)"),
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
     *    description="Wrong credentials response"
     *     )
     * )
     */

    function updateTemplate(Request $req)
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

        $tmplMediaIdRules = ['tmpl_id' => 'required'];
        $folderIdRules       = ['folder_id'      => 'required'];
        $catIDRules          = ['cat_id'         => 'required'];
        $tmplNameRules       = ['tmpl_name'      => 'required'];
        $tmplMsgRules        = ['tmpl_message'   => 'required'];
        $tmplMediaIdRules    = ['tmpl_media_id'  => 'required'];
        $tmplMediaUrlRules   = ['tmpl_media_url' => 'required'];
        $tmplTypeRules       = ['tmpl_type'      => 'required'];

        //valid tmplID 

        /*$validTmplid = Validator::make($req->all(), $tmplMediaIdRules);
        if ($validTmplid->fails()) 
        {
            return responceServices::responseWithError(7034, null);
        }*/

        //dynamic validation tmplId

        $templateServices = new templateServices;

        $validTmplData = $templateServices->checkValidTmplId($payload['tmpl_id'], $payload['account_id']);
        if (!count($validTmplData)) 
        {
            return responceServices::responseWithError(7034, null);
        }

        $categoryServices = new categoryServices;

        //valid folderId
        $validFolderId = Validator::make($req->all(), $folderIdRules);
        if ($validFolderId->fails()) 
        {
            return responceServices::responseWithError(7019, null);
        }

        $folderValidationData = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
        if (count($folderValidationData) == '') 
        {
            return responceServices::responseWithError(7021, null);
        }

        //vaid catID 
        $validcatID = Validator::make($req->all(), $catIDRules);
        if ($validcatID->fails()) {
            return responceServices::responseWithError(7023, null);
        }

        $validCatId = $templateServices->validCatID($payload); 
         if (!count($validCatId)) 
         {
            return responceServices::responseWithError(7023, null);
         }

         //valid tmplName

         $validTmplName = Validator::make($req->all(), $tmplNameRules);
         if ($validTmplName->fails()) {
            return responceServices::responseWithError(7025, null);
         }

         // dynamic validation for template name

         $validTmplNameData = $templateServices->validTmplName($payload);
         if (count($validTmplNameData)) {
            return responceServices::responseWithError(7030, $validTmplNameData[0]);
         }

          //valid tmplMessages
        $validTmplMsg = Validator::make($req->all(), $tmplMsgRules);
        if ($validTmplMsg->fails()) 
        {
            return responceServices::responseWithError(7026, null);
        }

        /*valid mediaID
        $validmediaID = Validator::make($req->all(), $tmplMediaIdRules);
        if ($validmediaID->fails()) 
        {
            return responceServices::responseWithError(7027, null);
        }

        //valid mediaUrl
        $validMediaUrl = Validator::make($req->all(), $tmplMediaUrlRules);
        if ($validMediaUrl->fails()) 
        {
            return responceServices::responseWithError(7028, null);
        }*/

        if (array_key_exists('tmpl_media_url', $payload) && $payload['tmpl_media_url'] != null) 
        {
            $payload['tmpl_media_id'] = $templateServices->addMedia(array('media_title' => $payload['tmpl_media_title'], 'media_url' => $payload['tmpl_media_url'], 'media_source' => "TEMPLATE", 'media_created_on' => date(getenv("DATETIME_FORMAT")), 'media_created_by' => $payload['account_id']));
        }
        $updateData = $templateServices->updateTemplate($payload);
        return responceServices::respondWithSuccess(10019, null);
        


    }

    /**
     * @OA\Get(
     * path="/api/templateListAll",
     * summary="List all Template names under folder_id or cat_id and tmp_type",
     *   description="fetch Template list<br/>
      Success Code:<br/>
            10010: Template list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
            7021: This folder_id is not valid or belongs to other account.<br/>
            7023: Please enter valid category ID.<br/>
       ",
     * tags={"Project Template"},
     *  @OA\Parameter(
     *      name="tmpl_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="folder_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="cat_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
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

       function templateListAll(Request $req)
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

            $tmplTypeRules = ['tmpl_type' => 'required'];

            //valid tmpl type
            $validTmplType = Validator::make($req->all(), $tmplTypeRules);
            if ($validTmplType->fails() || !in_array(array_key_exists('tmpl_type', $payload) ? $payload['tmpl_type'] : '', array('NORMAL', 'DRIP'))) 
            {
                return responceServices::responseWithError(7039,null);
            }

            //check folderID
             $categoryServices = new categoryServices;

            if (array_key_exists('folder_id', $payload)) 
            {
                $folderValidationData = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
                if (count($folderValidationData) == '') 
                {
                    return responceServices::responseWithError(7021, array('folder_id' => $payload['folder_id']));
                }
            }

            //vaid catID 
            $templateServices = new templateServices;

            if (array_key_exists('cat_id', $payload)) 
            {
                $validCatId = $templateServices->validCatID($payload); 
                if (!count($validCatId)) 
                {
                    return responceServices::responseWithError(7023, null);
                }
            }
            
            $listAllTemplate = $templateServices->templateListAll($payload);
            return responceServices::respondWithSuccess(10010, $listAllTemplate);
       }


    /**
     * @OA\Get(
     * path="/api/template_list_all_by_userID",
     * summary="List all Template names under folder_id or cat_id or usr_id and tmp_type",
     *   description="fetch Template list<br/>
      Success Code:<br/>
            10010: Template list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7007: pleasse enter a valid folder_type(NORMAL/DRIP).<br/>
            7021: This folder_id is not valid or belongs to other account.<br/>
            7023: Please enter valid category ID.<br/>
       ",
     * tags={"Project Template"},
     *  @OA\Parameter(
     *      name="tmpl_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          example="NORMAL/DRIP"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="folder_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="cat_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="usr_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1"
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

       function listAllByUerID(Request $req)
       {

            $sessionToken = $req->header("session-token");
            $practiceServices = new PracticeServices;
            $usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
            if ($usrData == '') 
            {
            return responceServices::responseWithError(7002, null);
            }

            $payload                 =  $req->all();
            if (array_key_exists('usr_id', $payload)) 
            {
                $payload['account_id'] = $payload['usr_id'];
            }
            else
            {
                 $payload['account_id'] = $usrData->data->usr_id;
            }

            $tmplTypeRules = ['tmpl_type' => 'required'];

            //valid tmpl type
            $validTmplType = Validator::make($req->all(), $tmplTypeRules);
            if ($validTmplType->fails() || !in_array(array_key_exists('tmpl_type', $payload) ? $payload['tmpl_type'] : '', array('NORMAL', 'DRIP'))) 
            {
                return responceServices::responseWithError(7007,null);
            }

            //check folderID
             $categoryServices = new categoryServices;

            if (array_key_exists('folder_id', $payload)) 
            {
                $folderValidationData = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
                if (count($folderValidationData) == '') 
                {
                    return responceServices::responseWithError(7021, array('folder_id' => $payload['folder_id']));
                }
            }

            //vaid catID 
            $templateServices = new templateServices;

            if (array_key_exists('cat_id', $payload)) 
            {
                $validCatId = $templateServices->validCatID($payload); 
                if (!count($validCatId)) 
                {
                    return responceServices::responseWithError(7023, null);
                }
            }

            $listAllDataUsrID = $templateServices->templateListAllUsrId($payload);
            return responceServices::respondWithSuccess(10010, $listAllDataUsrID);
       }


       /**
     * @OA\Get(
     * path="/api/template_listDripMessages",
     * summary="List all drip message under templ_id",
     *   description="fetch Template list<br/>
      Success Code:<br/>
            10011: Drip messages list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7034: pleasse enter a valid template ID.<br/>
       ",
     * tags={"Project Template"},
     *  @OA\Parameter(
     *      name="tmpl_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example=""
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

       public function listDripMessages(Request $req)
       {
            $sessionToken = $req->header("session-token");
            $practiceServices = new PracticeServices;
            $usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
            if ($usrData == '') 
            {
            return responceServices::responseWithError(7002, null);
            }

            $payload = $req->all();
            $payload['account_id'] = $usrData->data->usr_id;
          
            $templIDRules = ['tmpl_id' => 'required'];

            ///valid tmplID 

            $validTmplid = Validator::make($req->all(), $templIDRules);
            if ($validTmplid->fails()) 
            {
                return responceServices::responseWithError(7034, null);
            }

            //dynamic validation tmplId

            $templateServices = new templateServices;

            $validTmplData = $templateServices->checkValidTmplId($payload['tmpl_id'], $payload['account_id']);
            if (!count($validTmplData)) 
            {
                return responceServices::responseWithError(7034, null);
            }

            $dripMsgData = $templateServices->dripMsgList($payload);
            return responceServices::respondWithSuccess(10021, $dripMsgData);
       }


       /**
     * @OA\Get(
     * path="/api/template_details",
     * summary="List all drip message under templ_id",
     *   description="fetch Template list<br/>
      Success Code:<br/>
            10011: Drip messages list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7034: pleasse enter a valid template ID.<br/>
       ",
     * tags={"Project Template"},
     *  @OA\Parameter(
     *      name="tmpl_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example=""
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

       function templateDetails(Request $req)
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


             $templIDRules = ['tmpl_id' => 'required'];

            ///valid tmplID 

            $validTmplid = Validator::make($req->all(), $templIDRules);
            if ($validTmplid->fails()) 
            {
                return responceServices::responseWithError(7034, null);
            }

            //dynamic validation tmplId

            $templateServices = new templateServices;

            $validTmplData = $templateServices->checkValidTmplId($payload['tmpl_id'], $payload['account_id']);
            if (!count($validTmplData)) 
            {
                return responceServices::responseWithError(7034, null);
            }           

            $result = $templateServices->fetchTemplateDetails($payload['tmpl_id']);
            return responceServices::respondWithSuccess(10010, $result);
       }


    /**
     * @OA\Post(
     * path="/api/template/delete",
     * summary="User Login",
     *   description="create group<br/>
       Success Code:<br/>
       10019: template deleted successfull.<br/>
       Error Code:<br/>
       7019: Please enter a valid session-token.<br/>
       7021: This folder_id is not valid or belongs to other account.<br/>
       ",
     * tags={"Project Template"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tmpl_id", "folder_id", "cat_id", "tmpl_name", "tmpl_message"},
     *       @OA\Property(property="tmpl_id", type="numeric", example="1")
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
     *    description="Wrong credentials response"
     *     )
     * )
     */
       function templateDelete(Request $req)
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

        $tmplMediaIdRules = ['tmpl_id' => 'required'];

        //valid tmplID 

        $validTmplid = Validator::make($req->all(), $tmplMediaIdRules);
        if ($validTmplid->fails()) 
        {
            return responceServices::responseWithError(7034, null);
        }

        //dynamic validation tmplId

        $templateServices = new templateServices;

        $validTmplData = $templateServices->checkValidTmplId($payload['tmpl_id'], $payload['account_id']);
        if (!count($validTmplData)) 
        {
            return responceServices::responseWithError(7034, null);
        }
        
        $deleteData = $templateServices->templateDelete($payload);
        return responceServices::respondWithSuccess(10030, null); 
    }


    /**
     * @OA\Post(
     * path="/api/template/updateDripMessages",
     * summary="template",
     *   description="Update drip_messages<br/>
       Success Code:<br/>
       10032: Drip messages updated successfully.<br/>
       Error Code:<br/>
       7019: Please enter a valid session-token.<br/>
       7057: Please enter a valid drip_id.<br/>
       
       ",
     * tags={"Project Template"},
     * @OA\RequestBody(
     *    required=true,
     *    description="update drip messages",
     *    @OA\JsonContent(
     *       required={"drp_id"},
     *       @OA\Property(property="drp_id", type="numeric", example="1"),
     *       @OA\Property(property="drp_type", type="strign", example="DAY/HRS_MIN"),
     *       @OA\Property(property="drp_days", type="numeric", example="1"),
     *       @OA\Property(property="drp_hours", type="numeric", example="12"),
     *       @OA\Property(property="drp_minutes", type="numeric", example="50"),
     *       @OA\Property(property="drp_meridiem", type="numeric", example="AM/PM"),
     *       @OA\Property(property="drp_message", type="string", example="Lorem ipsum dummy text for testing."),
     *       @OA\Property(property="drp_media_id", type="string", example="1"),
     *       @OA\Property(property="drp_media_title", type="string", example="media title"),
     *       @OA\Property(property="drp_media_url", type="string", example="https://sample.png")
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
     *    description="Wrong credentials response"
     *     )
     * )
     */

       function updateDripMessages(Request $req)
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

            $drpIdIdRules = ['drp_id' => 'required'];

            //valid drp_id

            $validDripId = Validator::make($req->all(), $drpIdIdRules);
            if ($validDripId->fails()) 
            {
                return responceServices::responseWithError(7057, null);
            }

            $templateServices = new templateServices;

            if (array_key_exists('drp_media_url', $payload) && $payload['drp_media_url'] != null) 
            {
                $payload['drp_media_id'] = $templateServices->addMedia(array('media_title' => $payload['drp_media_title'], 'media_url' => $payload['drp_media_url'], 'media_source' => "TEMPLATE_DRIP", 'media_created_on' => date(getenv("DATETIME_FORMAT")), 'media_created_by' => $payload['account_id']));
            }else{
                $payload['drp_media_id'] = 0;
            }
            $updateData = $templateServices->updateDripMessages($payload);
            return responceServices::respondWithSuccess(10032, null);       
        }


        /**
     * @OA\Post(
     * path="/api/template/delete_dripMessages",
     * summary="template",
     *   description="delete drip_messages<br/>
       Success Code:<br/>
       10033: Drip messages deleted successfully.<br/>
       Error Code:<br/>
       7019: Please enter a valid session-token.<br/>
       7057: Please enter a valid drip_id.<br/>
       ",
     * tags={"Project Template"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"drp_id"},
     *       @OA\Property(property="drp_id", type="numeric", example="1")
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
     *    description="Wrong credentials response"
     *     )
     * )
     */

       function deleteDripMessages(Request $req)
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

            $drpIdIdRules = ['drp_id' => 'required'];
            
            //valid drp_id
            $validDripId = Validator::make($req->all(), $drpIdIdRules);
            if ($validDripId->fails()) 
            {
                return responceServices::responseWithError(7057, null);
            }

            $templateServices = new templateServices;
            $deleteDripMessagesData = $templateServices->deleteDripMessages($payload);
            return responceServices::respondWithSuccess(10033, null);   
       }
}
