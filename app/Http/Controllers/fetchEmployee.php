<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employeemodel;

class fetchEmployee extends Controller
{
    //
    function displayemployee()
    {
    	return employeemodel::showemployee();
    }
    	
    

    /**
     * @OA\Post(
     * path="/api/employee/add",
     * summary="Create Contact",
     *   description="create contact<br/>
       ",
     * tags={"prem"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide employee details",
     *    @OA\JsonContent(
     *       @OA\Property(property="employee_id", type="numeric", example="1"),
     *       @OA\Property(property="empoyee_name", type="string", example="john_ceana"),
     *       @OA\Property(property="employee_location", type="string", example="pune"),
     *       @OA\Property(property="empolyee_salary", type="numeric", example="100000"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )	
     *     )
     * )
     */    function insertEmployee(Request $Request)
    {
    	$payload = $Request->all();
    	print_r($payload);
    	exit();
    	
    }
}
