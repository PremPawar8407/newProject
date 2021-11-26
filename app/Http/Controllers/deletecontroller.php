<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;
class deletecontroller extends Controller
{
	
    function delete(request $Request)
    {
    	
    	$delete=about::find($Request->id);
    	if($delete->delete())
    	{
    		return "data has deleted";
    	}


    }
}
