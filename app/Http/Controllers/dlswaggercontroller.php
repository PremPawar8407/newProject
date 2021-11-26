<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\details;

class dlswaggercontroller extends Controller
{
       /**
     * @OA\Delete(
     *      path="/api/deleteswagg",
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
    function deleteswag(Request $req)
    {
    	$delete=details::find($req->id,);
       if($delete->delete())
        {
    	
            return "deleted ";
        }
    }
}
