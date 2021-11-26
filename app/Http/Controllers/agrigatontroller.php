<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;

class agrigatontroller extends Controller
{
   function mathfun(){
   //	return about::sum('id');
   //	return about::avg('id');
   //	return about::min('id');
 		return about::max('id');

   }
}
