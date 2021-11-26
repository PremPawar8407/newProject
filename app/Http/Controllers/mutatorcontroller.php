<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mutatorModel;
use Illuminate\Support\Facades\Validator;

class mutatorcontroller extends Controller
{
  /**
     * @OA\Post(
     ** path="/api/mutator",
     *   tags={"mutator"},
     *   summary="new from",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="lastname",
     *      in="query",
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
    function data(Request $Request)
    {
    	
    		
            $rules=array(
                "firstname" =>'required | max:10',
                "lastname"  => 'required |max:10');
            $validator=validator::make($Request->all(), $rules);
            if ($validator->fails()) 
            {
                return $validator->errors();
            }
            else
            {
               
    	       $data=new mutatorModel;
    	       $data->firstname=$Request->firstname;
    	       $data->lastname=$Request->lastname;
            $law=array(
                "$data->firstname" =>'required | max:10',
                "$data->lastname"  => 'required |max:10');


            $valid=validator::make($law);
            if ($valid->fails()) 
            {
                return $validator->errors();
            }else
            {
                return "pp";    
                if ($data->save())

                 {
                    echo "1";
                 }
                else
                    {
                        echo "0";
                    }
             }       


            }   
    	/*if($data->save())
    	{
    		return ["result"=>"data has submitted"];
    	}else
    	{
    		echo "1";
    	}*/

    	
    }
}
