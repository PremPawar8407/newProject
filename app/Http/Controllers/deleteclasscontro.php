<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\twelth;
class deleteclasscontro extends Controller
{
    /**
     * @OA\Delete(
     *      path="/api/delete_class",
     *      operationId="login",
     *      tags={"PREM Tag"},
     *      summary="Login",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
    function deleteclass(Request $req)
    {
    	$value= twelth::find($req->id);
    	if ($value->delete()) {
    	return "data deleted";
    	}
    
    }
}
