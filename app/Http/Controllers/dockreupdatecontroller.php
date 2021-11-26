<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dockerdatabase;

class dockreupdatecontroller extends Controller
{
    /**
    * @OA\put(
    * path="/api/dockerupdate",
    * operationId="updateProject",
    * summary="Update existing project",
    * description="Subscription list",
    * tags={"docker"},
    * @OA\RequestBody(
     *    required=true,
     *    description="Provide Folder details",
     *    @OA\JsonContent(
     *       required={"id", "firstname", "lastname","email","address"},
     *       @OA\Property(property="id", type="string", example="5465"),
     *       @OA\Property(property="firstname", type="string", example="john"),
     *       @OA\Property(property="lastname", type="string", example="doe"),
     *       @OA\Property(property="email", type="string", example="doe"),
     *       @OA\Property(property="address", type="string", example="doe")
     *    ),
     * ),
 *   @OA\Parameter(
 *     name="id",
 *     in="query",
 *     description="please enter total_round.",     
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
    function docker_update(Request $req)

    {
    	$data=dockerdatabase:: find($req->id);
    	$data->firstname=$req->firstname;
    	$data->lastname=$req->lastname;
    	$data->email=$req->email;
    	$data->address=$req->address;
    	$data->save();
    	return dockerdatabase::all()	;
    	
    }
}
