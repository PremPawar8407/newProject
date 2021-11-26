<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;
class updatecontroller extends Controller
{

 /**
    * @OA\put(
    * path="/api/update/",
    * operationId="updateProject",
    * summary="Update existing project",
    * description="Subscription list",
    * tags={"PREM Tag"},
    * @OA\RequestBody(
     *    required=true,
     *    description="Provide Folder details",
     *    @OA\JsonContent(
     *       required={"student_id", "student_fname", "student_lname"},
     *       @OA\Property(property="student_id", type="string", example="5465"),
     *       @OA\Property(property="student_fname", type="string", example="john"),
     *       @OA\Property(property="student_lname", type="string", example="doe")
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
    
    function update(Request $request)
    {
    	$update=about::find($request->student_id);	
    	$update->firstname=$request->student_fname;
    	$update->lastname=$request->student_lname;
    	if( $update->save())
    	{
    		return $request->all();
    	}
    }
}
