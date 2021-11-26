<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;

class pagicontroller extends Controller
{
  
 function show(){
 	 $data=about::paginate(3)->offsetSet(1)->get();
 	return view("pagination",['data'=>$data]);
 }
}
