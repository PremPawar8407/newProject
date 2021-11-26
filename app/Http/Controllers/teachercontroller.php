<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teachers;

class teachercontroller extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/teacher_table",
     *   tags={"college"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="subject",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="teacher_phone",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    function teacherfun(Request $req)
    {
    	$data=new teachers;
    	$data->name=$req->name;
    	$data->subject=$req->subject;
    	$data->teacher_phone=$req->teacher_phone;
    	$data->save();
    	return $req;
    }
}
