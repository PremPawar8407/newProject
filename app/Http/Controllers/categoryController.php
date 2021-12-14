<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Practice\PracticeServices;
use App\Http\Services\newUtility\responceServices;
use App\Http\Services\Category\categoryServices;
use Validator;

class categoryController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/addCategory",
     * summary="Create Category",
      *   description="create Category<br/>
       Success Code:<br/>
       10015: Category added successfully.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7019: Please enter valid folder_id.<br/>
       7020: Please enter valid category name.<br/>
       7021: This folder_id is not valid or belongs to other account.<br/>
       7022: Category name already exists.<br/>
       ",
     * tags={"Project Category"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Category details",
     *    @OA\JsonContent(
     *       required={"folder_id","cat_name"},
     *       @OA\Property(property="folder_id", type="string", example="1"),
     *       @OA\Property(property="cat_name", type="string", example="addFolders")
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
    function addCategory(Request $req)
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

    	$folderIdRules = ['folder_id' => 'required|numeric'];
    	$catNameRules  = ['cat_name'  => 'required'];

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

    	//valid folder cat_name_rules
    	$validCatName = Validator::make($req->all(), $catNameRules);
    	if ($validCatName->fails()) 
    	{
    		return responceServices::responseWithError(7020, null);
    	}

    	//dynamic validation for cat_name
    	$checkCatName = $categoryServices->checkValidName($payload);

    	if(count($checkCatName))
    	{
    		return responceServices::responseWithError(7022, $checkCatName[0]);
    	}

    	//get folder_type value and insert in cat_type.
    	$payload['folder_type'] = $folderValidationData[0]->folder_type;
    	
    	$lastInsertedID = $categoryServices->addCategory($payload);

    	return responceServices::respondWithSuccess(10015, array("cat_id" => $lastInsertedID));
    }

      /**
     * @OA\Post(
     * path="/api/updateCategory",
     * summary="Create update",
      *   description="update Category<br/>
       Success Code:<br/>
       10016: Category details updated successfully.<br/>
       Error Code:<br/>
       7002: Please enter a valid session-token.<br/>
       7019: Please enter valid folder_id.<br/>
       7020: Please enter valid category name.<br/>
       7021: This folder_id is not valid or belongs to other account.<br/>
       7022: Category name already exists.<br/>
       7023: Please enter valid category ID.<br/>
       7024: Please enter valid category state(A/I/D).<br/>
       ",
     * tags={"Project Category"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Category details",
     *    @OA\JsonContent(
     *       required={"cat_id","folder_id","cat_name","cat_state"},
     *       @OA\Property(property="cat_id", type="string", example="1"),
	 *       @OA\Property(property="folder_id", type="string", example="1"),
	 *       @OA\Property(property="cat_name", type="string", example="NewCategory"),
     *       @OA\Property(property="cat_state", type="string", example="A/I/D")
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

      function updateCategory(Request $req)
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

			$catIdRules    = ['cat_id'    => 'required|numeric'];
			$folderIdRules = ['folder_id' => 'required|numeric'];
			$catNameRules  = ['cat_name'  => 'required'];
			$catStateRules = ['cat_state' => 'required'];

			$categoryServices = new categoryServices;

			//valid catID 
			$validCatIdRules = Validator::make($req->all(), $catIdRules);
			if ($validCatIdRules->fails())
			{
				return responceServices::responseWithError(7023, null);
			}

			//dynamic validation catID
			$checkValidCatID = $categoryServices->checkValidCatID($payload);
			 if ( ! count($checkValidCatID)) 
			 {
			 	return responceServices::responseWithError(7023, array('cat_id' => $payload['cat_id']));
			 }

			//valid folderID 
			$validFolderIdRules = Validator::make($req->all(), $folderIdRules);
			if ($validFolderIdRules->fails())
			{
				return responceServices::responseWithError(7019, null);
			}

			//dynamic validation for folderID

			$checkValidFolderID = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
			if (! count($checkValidFolderID)) 
			{
				return responceServices::responseWithError(7021, null);
			}

			//valid catName 
			$validCatNameRules = Validator::make($req->all(), $catNameRules);
			if ($validCatNameRules->fails())
			{
				return responceServices::responseWithError(7020, null);
			}


			$checkCatName = $categoryServices->checkValidName($payload);

			if(count($checkCatName))
			{
				return responceServices::responseWithError(7022, $checkCatName[0]);
			}

			//valid catState 
			$validCatStateRules = Validator::make($req->all(), $catStateRules);
			if ($validCatStateRules->fails() || ! in_array((array_key_exists('cat_state', $payload) ? $payload['cat_state'] : ""), array("A", "I", "D")))
			{
				return responceServices::responseWithError(7024, null);
			}

			$updateCategory = $categoryServices->updateCategory($payload);
			return responceServices::respondWithSuccess(10016, $updateCategory);
      }

      /**
     * @OA\Get(
     * path="/api/category/listAll",
     * summary="List all category names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10017: Category list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7019: Please enter valid folder_id.<br/>
            7021: This folder_id is not valid or belongs to other account.<br/> 
       ",
     * tags={"Project Category"},
     *  @OA\Parameter(
     *      name="folder_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          example="1/2"
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
       public function categoryListAll(Request $req)
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

			$folderIdRules = ['folder_id' => 'required'];

			$categoryServices = new categoryServices;

			//valid folderID 
			$validFolderIdRules = Validator::make($req->all(), $folderIdRules);
			if ($validFolderIdRules->fails())
			{
				return responceServices::responseWithError(7019, null);
			}

			//dynamic validation for folderID

			$checkValidFolderID = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
			if (! count($checkValidFolderID)) 
			{
				return responceServices::responseWithError(7021, null);
			}

			$fetchCategoryData = $categoryServices->categoryListAll($payload);
			return responceServices::respondWithSuccess(10017, $fetchCategoryData);
       }

       /**
     * @OA\Get(
     * path="/api/category/list_all_by_user",
     * summary="List all category names under usr_id",
     *   description="fetch folder list <br/>
      Success Code:<br/>
            10017: Category list fetched successfullly.<br/>
      Error Code:<br/>
            7002: Please enter a valid session-token.<br/>
            7019: Please enter valid folder_id.<br/>
            7021: This folder_id is not valid or belongs to other account.<br/> 
       ",
     * tags={"Project Category"},
     *  @OA\Parameter(
     *      name="folder_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          example="1/2"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="usr_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number",
     *          example="1/2"
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

       public function listAllByUser(Request $req)
       {
       		$sessionToken = $req->header("session-token");
			$practiceServices = new PracticeServices;
			$usrData =  json_decode($practiceServices->checkUserDataToken($sessionToken));
			if ($usrData == '') 
			{
				return responceServices::responseWithError(7002, null);
			}

			$payload = $req->all();
			$payload['account_id'] = $payload['usr_id'];

			$folderIdRules = ['folder_id' => 'required'];

			$categoryServices = new categoryServices;

			//valid folderID 
			$validFolderIdRules = Validator::make($req->all(), $folderIdRules);
			if ($validFolderIdRules->fails())
			{
				return responceServices::responseWithError(7019, null);
			}

			//dynamic validation for folderID

			$checkValidFolderID = $categoryServices->validateFolderdetail($payload['folder_id'], $payload['account_id']);
			if (! count($checkValidFolderID)) 
			{
				return responceServices::responseWithError(7021, null);
			}
			

			$fetchCatData = $categoryServices->categoryListAll($payload);
			return responceServices::respondWithSuccess(10017, $fetchCategoryData);
       }
}
