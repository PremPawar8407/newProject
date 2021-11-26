<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class insrcontro extends Controller
{
    //
    function insert(Request $req)
    {
    	

    	  $str="prem pawat the little thing about  us maharashtra";
    	
    		$last_word_start = strrpos ( $str , "maharashtra")-1;
    	  	  $last_word_end = strlen($str);
    	  	$last_word = substr($str, $last_word_start, $last_word_end);
    	  	 return $last_word;

    }
}
