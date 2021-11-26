<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;

class login extends Controller
{
    
    function checkCredential(Request $req)
    {
    	$req->validate([
    		'firstname' => 'required',
    		 'password' => 'required']);
    	
		$result=about::where('password',$req->password)->get();
		
		return $result;
		die();
		
		if ($result = "") {
			print_r("prem");
		}else
		{
			return "new";
		}
    }
}
