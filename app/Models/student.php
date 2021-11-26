<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class student extends Model
{
    use HasFactory;
     public static function showout()
    {
    	
    	  $mainData = DB::table('students')
    			 ->select('*')
    			 ->get();
    		return $mainData;
    				
        
	}
}
