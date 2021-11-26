<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;
class firstapicontroller extends Controller
{
    //
    function first (request $req){
    	$data=new about;
    	$data->firstname=$req->name;
    	$data->lastname=$req->lname;
  if   ( $data->save())
  {
  	return "data has submited";
  }

    }
}
