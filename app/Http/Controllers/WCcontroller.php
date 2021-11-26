<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Models\about;

class WCcontroller extends Controller
{
    //
    function show ( request $Request)
    {
    	$Request->validate([
    		'firstname'=>'required',
    		 'lastname'=>'required']);
      $res= new about;
    $res->firstname=$Request->firstname;
     $res->lastname=$Request->lastname;
     //$res->save();
     //$res=about::find(7);
     //$res->delete();

     return about::all();


    }
}
